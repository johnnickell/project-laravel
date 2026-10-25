#!/usr/bin/env python3
"""Validate planning, refresh views, or explicitly reconcile verified delivery handoffs."""

from __future__ import annotations

import argparse
import datetime
import json
import os
import re
import subprocess
import sys
from pathlib import Path
from urllib.parse import urlparse

ROOT = Path(__file__).resolve().parents[1]
PLANNING = ROOT / "planning"
VALID_STATUSES = {
    "needs-triage", "needs-info", "ready-for-agent", "ready-for-human",
    "in-progress", "done", "wontfix",
}
TERMINAL = {"done", "wontfix"}
ACCEPTED = {"ready-for-agent", "in-progress"}
KINDS = {
    "epics": ("EPIC", "EPIC"),
    "tickets": ("TICKET", "TICKET"),
    "tasks": ("TASK", "TASK"),
    "specs": ("PRD", "PRD"),
}
Record = tuple[Path, dict[str, str]]
Records = dict[str, Record]


def frontmatter(path: Path) -> dict[str, str]:
    return parse_frontmatter(path.read_text(encoding="utf-8"))


def parse_frontmatter(text: str) -> dict[str, str]:
    text = text.replace("\r\n", "\n").replace("\r", "\n")
    match = re.match(r"\A---\n(.*?)\n---(?:\n|$)", text, re.DOTALL)
    if not match:
        raise ValueError("missing or unclosed frontmatter")
    values: dict[str, str] = {}
    for line in match.group(1).splitlines():
        key, separator, value = line.partition(":")
        key = key.strip()
        if not separator or not re.fullmatch(r"[a-z_]+", key) or key in values:
            raise ValueError(f"invalid or duplicate frontmatter field: {line}")
        values[key] = value.strip()
    return values


def blockers(data: dict[str, str]) -> list[str]:
    return [value.strip() for value in data.get("blocked_by", "").split(",") if value.strip()]


def parent_ids(data: dict[str, str]) -> list[str]:
    return [data[key] for key in ("epic", "ticket", "prd") if data.get(key)]


def is_live(path: Path) -> bool:
    return "archive" not in path.relative_to(PLANNING).parts


def load_records(errors: list[str]) -> Records:
    records: Records = {}
    for directory, (prefix, suffix) in KINDS.items():
        for path in sorted((PLANNING / directory).rglob(f"*-{suffix}.md")):
            if path.name.startswith("_"):
                continue
            label = str(path.relative_to(ROOT))
            try:
                data = frontmatter(path)
            except ValueError as exception:
                errors.append(f"{label}: {exception}")
                continue
            identifier = data.get("id", "")
            if not re.fullmatch(rf"{prefix}-\d{{5}}", identifier):
                errors.append(f"{label}: invalid id {identifier!r}")
                continue
            if path.name != f"{identifier.rsplit('-', 1)[1]}-{suffix}.md":
                errors.append(f"{label}: filename does not match {identifier}")
            if identifier in records:
                errors.append(f"duplicate id: {identifier}")
                continue
            for required in ("title", "status"):
                if not data.get(required):
                    errors.append(f"{label}: missing {required}")
            if data.get("status") not in VALID_STATUSES:
                errors.append(f"{label}: invalid status {data.get('status')!r}")
            if directory == "epics" and not data.get("target"):
                errors.append(f"{label}: missing target (use TBD until selected)")
            records[identifier] = (path, data)
    return records


def validate_records(records: Records, errors: list[str]) -> None:
    for identifier, (path, data) in records.items():
        label = str(path.relative_to(ROOT))
        prefix = identifier.rsplit("-", 1)[0]
        required_parent = ""
        allowed_parents: set[str] = set()
        if prefix == "TICKET":
            required_parent = "epic"
            allowed_parents = {"epic", "prd"}
        elif prefix == "TASK":
            kind = data.get("kind", "feature")
            if kind not in {"feature", "bug"}:
                errors.append(f"{label}: kind must be feature or bug")
            if kind != "bug":
                required_parent = "ticket"
            elif "ticket" not in data:
                errors.append(f"{label}: standalone bug requires an explicit empty ticket field")
            allowed_parents = {"ticket"}
        elif prefix == "PRD":
            allowed_parents = {"epic"}
        if required_parent and not data.get(required_parent):
            errors.append(f"{label}: missing {required_parent} parent")
        for field, expected_prefix in (("epic", "EPIC-"), ("ticket", "TICKET-"), ("prd", "PRD-")):
            parent = data.get(field)
            if not parent:
                continue
            if field not in allowed_parents:
                errors.append(f"{label}: {field} is not a parent at this level")
            if parent not in records or not parent.startswith(expected_prefix):
                errors.append(f"{label}: invalid {field} parent {parent}")
        dependencies = blockers(data)
        if len(set(dependencies)) != len(dependencies):
            errors.append(f"{label}: duplicate blocker")
        for dependency in dependencies:
            if prefix not in {"TICKET", "TASK"} or not re.fullmatch(rf"{prefix}-\d{{5}}", dependency):
                errors.append(f"{label}: blocker must be a same-level TICKET or TASK: {dependency}")
            elif dependency not in records:
                errors.append(f"{label}: unknown blocker {dependency}")
            elif data.get("status") == "done" and records[dependency][1].get("status") not in TERMINAL:
                errors.append(f"{label}: done record has unfinished blocker {dependency}")
        if prefix == "TASK":
            order = data.get("order", "")
            if order and not re.fullmatch(r"[1-9]\d*", order):
                errors.append(f"{label}: order must be a positive integer")
            pr = data.get("pr", "")
            if pr:
                try:
                    url = urlparse(pr)
                    valid_url = url.scheme in {"http", "https"} and bool(url.netloc) and bool(url.path.strip("/"))
                except ValueError:
                    valid_url = False
                if not valid_url:
                    errors.append(f"{label}: pr must be a full URL")
        if data.get("delivery"):
            if prefix != "TASK" or not is_live(path) or data["delivery"] != "awaiting-merge":
                errors.append(f"{label}: delivery must be awaiting-merge on a live TASK, or empty")
            if data.get("status") != "done":
                errors.append(f"{label}: awaiting-merge delivery requires done acceptance status")
            if not data.get("pr"):
                errors.append(f"{label}: an awaiting-merge delivery handoff requires its PR URL")
        if data.get("status") in TERMINAL:
            unfinished = [child_id for child_id, (_, child) in records.items()
                          if identifier in parent_ids(child) and child.get("status") not in TERMINAL]
            if unfinished:
                errors.append(f"{label}: terminal parent has unfinished children: {', '.join(unfinished)}")

    visiting: set[str] = set()
    visited: set[str] = set()

    def visit(identifier: str) -> None:
        if identifier in visiting:
            errors.append(f"dependency cycle at {identifier}")
            return
        if identifier in visited or identifier not in records:
            return
        visiting.add(identifier)
        for dependency in blockers(records[identifier][1]):
            visit(dependency)
        visiting.remove(identifier)
        visited.add(identifier)

    for identifier in records:
        visit(identifier)


def validate_links(errors: list[str]) -> None:
    markdown_link = re.compile(r"\!?\[[^\]]*\]\(([^\s)]+)")
    for path in PLANNING.rglob("*.md"):
        if path.name.startswith("_"):
            continue
        for target in markdown_link.findall(path.read_text(encoding="utf-8")):
            destination, _, _anchor = target.partition("#")
            if not destination.endswith(".md") or destination.startswith(("/", "http:", "https:", "mailto:")):
                continue
            if not (path.parent / destination).resolve().is_file():
                errors.append(f"{path.relative_to(ROOT)}: broken local Markdown link {target}")


def task_waiting(data: dict[str, str], records: Records) -> list[str]:
    reasons = [dependency for dependency in blockers(data) if records[dependency][1]["status"] not in TERMINAL]
    ticket_id = data.get("ticket")
    if not ticket_id:
        return reasons
    ticket = records[ticket_id][1]
    epic_id = ticket["epic"]
    if ticket["status"] not in ACCEPTED:
        reasons.append(f"{ticket_id} ({ticket['status']})")
    if records[epic_id][1]["status"] not in ACCEPTED:
        reasons.append(f"{epic_id} ({records[epic_id][1]['status']})")
    reasons.extend(dependency for dependency in blockers(ticket) if records[dependency][1]["status"] not in TERMINAL)
    return reasons


def cell(value: str) -> str:
    return value.replace("|", "\\|").replace("\n", " ") or "—"


def link(identifier: str, source: Path, records: Records) -> str:
    relative = os.path.relpath(records[identifier][0], source.parent).replace(os.sep, "/")
    return f"[{identifier}]({relative})"


def table(identifiers: list[str], source: Path, records: Records) -> str:
    if not identifiers:
        return "None."
    lines = ["| ID | Title | Status | Parent | Blocked by |", "| --- | --- | --- | --- | --- |"]
    for identifier in identifiers:
        data = records[identifier][1]
        parents = ", ".join(link(parent, source, records) for parent in parent_ids(data)) or "—"
        dependencies = ", ".join(link(dependency, source, records) for dependency in blockers(data)) or "—"
        lines.append(f"| {link(identifier, source, records)} | {cell(data['title'])} | {data['status']} | {parents} | {dependencies} |")
    return "\n".join(lines)


def task_groups(records: Records) -> dict[str, list[str]]:
    """Share ordering and Laravel ancestor/blocker readiness across current routing views."""
    groups: dict[str, list[str]] = {name: [] for name in (
        "Active Work", "Ready Frontier", "Waiting", "Needs Info", "Human Action", "Needs Triage", "Recently Done",
    )}
    task_ids = [identifier for identifier, (path, _) in records.items() if identifier.startswith("TASK-") and is_live(path)]
    task_ids.sort(key=lambda identifier: (
        not bool(records[identifier][1].get("order")),
        int(records[identifier][1].get("order") or 0),
        identifier,
    ))
    for identifier in task_ids:
        data = records[identifier][1]
        status = data["status"]
        if status == "ready-for-agent":
            section = "Waiting" if task_waiting(data, records) else "Ready Frontier"
        else:
            section = {"in-progress": "Active Work", "needs-info": "Needs Info", "ready-for-human": "Human Action",
                       "needs-triage": "Needs Triage", "done": "Recently Done", "wontfix": "Recently Done"}[status]
        groups[section].append(identifier)
    return groups


def routing_summary(source: Path, records: Records, groups: dict[str, list[str]]) -> str:
    selected = [(name, identifier) for name in ("Human Action", "Needs Info") for identifier in groups[name]]
    active, ready = groups["Active Work"], groups["Ready Frontier"]
    if active:
        selected.extend(("Active Work", identifier) for identifier in active)
    elif ready:
        selected.append(("Ready Frontier", ready[0]))
    else:
        for name in ("Needs Triage", "Waiting"):
            selected.extend((name, identifier) for identifier in groups[name][:1])
    lines = ["| Route | TASK | Title | Status | Readiness |", "| --- | --- | --- | --- | --- |"]
    for name, identifier in selected:
        data = records[identifier][1]
        reasons = ", ".join(task_waiting(data, records))
        lines.append(f"| {name} | {link(identifier, source, records)} | {cell(data['title'])} | "
                     f"{data['status']} | {cell(reasons)} |")
    if not selected:
        lines.append("| None | — | — | — | — |")
    if not active and not ready:
        lines.extend(["", "No TASK is currently executable; unresolved planning or human decisions may remain."])
    return "\n".join(lines)


def delivery_summary(source: Path, records: Records) -> str:
    handoffs = current_delivery(records)
    if not handoffs:
        return "No current delivery handoffs. Historical PR links do not imply pending delivery."
    lines = ["| TASK | Current delivery | PR |", "| --- | --- | --- |"]
    for identifier, _, data in handoffs:
        lines.append(f"| {link(identifier, source, records)} | Published; verify live state | {data['pr']} |")
    return "\n".join(lines)


def board(source: Path, records: Records, groups: dict[str, list[str]]) -> str:
    sections = []
    for heading, identifiers in groups.items():
        text = [f"## {heading}", ""]
        if not identifiers:
            text.append("No TASKs.")
        else:
            text.extend(["| Order | TASK | Title | Parent TICKET | Status | Blocked by / readiness | PR |",
                         "| --- | --- | --- | --- | --- | --- | --- |"])
            for identifier in identifiers:
                data = records[identifier][1]
                dependencies = ", ".join(link(dependency, source, records) for dependency in blockers(data))
                waiting = task_waiting(data, records) if data["status"] not in TERMINAL else []
                readiness = "; ".join(filter(None, [dependencies, ", ".join(waiting)])) or "—"
                parent = link(data['ticket'], source, records) if data.get('ticket') else "—"
                text.append(f"| {cell(data.get('order', ''))} | {link(identifier, source, records)} | {cell(data['title'])} | "
                            f"{parent} | {data['status']} | {readiness} | {cell(data.get('pr', ''))} |")
        sections.append("\n".join(text))
    return "\n\n".join(sections)


def planning_frontier(source: Path, records: Records) -> str:
    lines = ["| Record | Status | Next planning action |", "| --- | --- | --- |"]
    for identifier, (path, data) in sorted(records.items()):
        if not is_live(path) or data["status"] in TERMINAL:
            continue
        if not identifier.startswith(("EPIC-", "TICKET-")):
            continue
        field = "epic" if identifier.startswith("EPIC-") else "ticket"
        child_prefix = "TICKET-" if field == "epic" else "TASK-"
        children = [child for child_id, (_, child) in records.items()
                    if child_id.startswith(child_prefix) and child.get(field) == identifier]
        if not children:
            if data["status"] not in ACCEPTED:
                action = "Resolve the record's named decisions before decomposition."
            elif any(records[dependency][1]["status"] not in TERMINAL for dependency in blockers(data)):
                action = "Resolve requirement prerequisites before TASK readiness."
            else:
                action = "Decompose into requirements TICKETs." if field == "epic" else "Decompose accepted requirements into TASKs."
        else:
            continue
        lines.append(f"| {link(identifier, source, records)} | {data['status']} | {action} |")
    return "\n".join(lines) if len(lines) > 2 else "No decomposition frontier."


def generated_views(records: Records) -> list[tuple[Path, str, str]]:
    views: list[tuple[Path, str, str]] = []
    for directory, (prefix, _) in KINDS.items():
        path = PLANNING / directory / "README.md"
        identifiers = sorted(identifier for identifier in records if identifier.startswith(prefix + "-"))
        views.append((path, "index", table(identifiers, path, records)))
    groups = task_groups(records)
    path = PLANNING / "tasks/BOARD.md"
    views.append((path, "tasks", board(path, records, groups)))
    views.append((path, "next", routing_summary(path, records, groups)))
    views.append((path, "delivery", delivery_summary(path, records)))
    path = PLANNING / "ROADMAP.md"
    views.append((path, "execution", routing_summary(path, records, groups)))
    epics = sorted(identifier for identifier, (record_path, _) in records.items()
                   if identifier.startswith("EPIC-") and is_live(record_path) and records[identifier][1]["status"] not in TERMINAL)
    views.append((path, "epics", table(epics, path, records)))
    views.append((path, "frontier", planning_frontier(path, records)))
    for identifier, (path, _) in records.items():
        if not is_live(path) or not identifier.startswith(("EPIC-", "TICKET-")):
            continue
        field = "epic" if identifier.startswith("EPIC-") else "ticket"
        child_prefix = "TICKET-" if field == "epic" else "TASK-"
        children = sorted(child_id for child_id, (_, data) in records.items()
                          if child_id.startswith(child_prefix) and data.get(field) == identifier)
        views.append((path, "children", table(children, path, records)))
    return views


def complete_parents(records: dict) -> dict[Path, str]:
    """Plan bottom-up parent closure from all live and archived child records."""
    pending = {}
    for kind, parent_key in (("TICKET-", "ticket"), ("EPIC-", "epic")):
        for identifier, (path, data) in sorted(records.items()):
            if not identifier.startswith(kind) or "archive" in path.parts or data["status"] in TERMINAL:
                continue
            children = [child for _, child in records.values() if child.get(parent_key) == identifier]
            if not children or any(child["status"] not in TERMINAL for child in children):
                continue
            status = "wontfix" if all(child["status"] == "wontfix" for child in children) else "done"
            text = path.read_text()
            header, body = text[4:].split("\n---\n", 1)
            header = re.sub(r"^status:[^\n]*$", f"status: {status}", header, count=1, flags=re.MULTILINE)
            pending[path] = f"---\n{header}\n---\n{body}"
            data["status"] = status
    return pending


def refresh_views(records: Records, write: bool, errors: list[str], pending: dict[Path, str] | None = None) -> None:
    changes = complete_parents(records)
    changes.update(pending or {})
    stale = set(changes)
    for path, name, content in generated_views(records):
        if not path.is_file():
            errors.append(f"{path.relative_to(ROOT)}: missing generated view host")
            continue
        text = changes.get(path, path.read_text(encoding="utf-8"))
        start = f"<!-- planning:{name} -->"
        end = f"<!-- /planning:{name} -->"
        if text.count(start) != 1 or text.count(end) != 1 or text.index(start) >= text.index(end):
            errors.append(f"{path.relative_to(ROOT)}: missing or ambiguous {name} markers")
            continue
        before, _, rest = text.partition(start)
        _old, _, after = rest.partition(end)
        updated = f"{before}{start}\n{content}\n{end}{after}"
        if updated != text:
            stale.add(path)
        changes[path] = updated
    if errors:
        return
    if write:
        for path in sorted(stale):
            path.write_bytes(changes[path].encode("utf-8"))
            print(f"Refreshed {path.relative_to(ROOT)}")
    else:
        errors.extend(f"{path.relative_to(ROOT)}: stale generated view; run ./bin/planning-check --write" for path in sorted(stale))


def current_delivery(records: Records) -> list[tuple[str, Path, dict[str, str]]]:
    """Only explicit current handoffs, never historical prose, done status or PR links."""
    return [(identifier, path, data) for identifier, (path, data) in sorted(records.items())
            if data.get("delivery") == "awaiting-merge"]


def delivery_identity(records: Records) -> tuple[list[tuple[str, Path, dict[str, str]]], str | None, list[str]]:
    handoffs = current_delivery(records)
    if not handoffs:
        return handoffs, None, []
    if len(handoffs) > 16:
        return handoffs, None, ["at most 16 current delivery handoffs may be verified per invocation"]
    try:
        origin = subprocess.run(["git", "-c", f"safe.directory={ROOT.resolve()}", "remote", "get-url", "origin"],
                                cwd=ROOT, capture_output=True, text=True, timeout=5, check=True).stdout.strip()
    except (OSError, subprocess.SubprocessError):
        return handoffs, None, ["delivery identity incomplete: cannot read target origin; planning owner must resolve it"]
    match = re.fullmatch(r"(?:git@github\.com:|https://github\.com/)([A-Za-z0-9_.-]+/[A-Za-z0-9_.-]+?)(?:\.git)?", origin)
    if not match:
        return handoffs, None, ["delivery identity incomplete: origin must identify one GitHub repository"]
    repository = match[1]
    errors = []
    for identifier, path, data in handoffs:
        if not re.fullmatch(rf"https://github\.com/{re.escape(repository)}/pull/[1-9][0-9]*", data["pr"]):
            errors.append(f"{path.relative_to(ROOT)} ({identifier}): delivery PR identity does not match target origin")
    return handoffs, repository, errors


def local_git(*arguments: str) -> str:
    """Inspect local objects only, without replacement ancestry or implicit partial-clone fetches."""
    return subprocess.run(
        ["git", "--no-replace-objects", "-c", f"safe.directory={ROOT.resolve()}", *arguments],
        cwd=ROOT, capture_output=True, text=True, timeout=5, check=True,
        env={**os.environ, "GIT_NO_LAZY_FETCH": "1"},
    ).stdout.strip()


ResolvedDelivery = tuple[str, Path, dict]


def verify_delivery(handoffs: list[tuple[str, Path, dict[str, str]]], repository: str | None) -> tuple[list[ResolvedDelivery], list[str]]:
    """Observe live delivery; only exact merged, accepted and locally integrated work is resolved."""
    resolved: list[ResolvedDelivery] = []
    errors = []
    for identifier, path, data in handoffs:
        label = f"{path.relative_to(ROOT)} ({identifier})"
        number = int(data["pr"].rsplit("/", 1)[1])
        try:
            result = subprocess.run(
                ["gh", "pr", "view", str(number), "--repo", repository, "--json",
                 "number,url,title,state,mergedAt,baseRefName,headRefName,headRefOid,mergeCommit"],
                cwd=ROOT, capture_output=True, text=True, timeout=15, check=True,
                env={**os.environ, "GH_PROMPT_DISABLED": "1"},
            )
            if len(result.stdout) > 16384:
                raise ValueError("oversized metadata")
            pr = json.loads(result.stdout)
            if (not isinstance(pr, dict) or type(pr.get("number")) is not int or pr["number"] != number
                    or pr.get("url") != data["pr"] or not isinstance(pr.get("title"), str)
                    or pr["title"] != identifier + " — " + data["title"]
                    or pr.get("baseRefName") != "develop"
                    or not isinstance(pr.get("headRefName"), str)
                    or not re.fullmatch(rf"feature/task-{identifier[5:]}-[a-z0-9][a-z0-9-]*", pr["headRefName"])
                    or not isinstance(pr.get("headRefOid"), str)
                    or not re.fullmatch(r"[0-9a-f]{40}", pr["headRefOid"])):
                raise ValueError("identity mismatch")
            state = pr.get("state")
            if state not in {"OPEN", "MERGED", "CLOSED"} or "mergedAt" not in pr or "mergeCommit" not in pr:
                raise ValueError("invalid state")
            if state == "MERGED":
                if not isinstance(pr["mergedAt"], str) or not re.fullmatch(r"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z", pr["mergedAt"]):
                    raise ValueError("invalid merge time")
                datetime.datetime.fromisoformat(pr["mergedAt"].replace("Z", "+00:00"))
                commit = pr.get("mergeCommit")
                if (not isinstance(commit, dict) or not isinstance(commit.get("oid"), str)
                        or not re.fullmatch(r"[0-9a-f]{40}", commit["oid"])):
                    raise ValueError("invalid merge commit")
                if data["status"] != "done":
                    errors.append(f"{label}: PR #{number} is MERGED but TASK is not done; resolve the current TASK scope before routing.")
                    continue
                try:
                    local_head = local_git("rev-parse", "--verify", "HEAD^{commit}")
                    local_git("merge-base", "--is-ancestor", pr["headRefOid"], commit["oid"])
                    local_git("merge-base", "--is-ancestor", commit["oid"], local_head)
                except (OSError, subprocess.SubprocessError):
                    errors.append(f"{label}: PR #{number} is MERGED but local integration is UNVERIFIED; obtain/integrate the exact merge through authorized Git work, then rerun. No fetch or merge was performed.")
                    continue
                pr["localHead"] = local_head
                resolved.append((identifier, path, pr))
                print(f"Delivery resolved: {identifier} PR #{number} is MERGED and locally integrated ({commit['oid']}); no human merge or cleanup request remains.")
            elif pr["mergedAt"] is not None or pr.get("mergeCommit") is not None:
                raise ValueError("contradictory merge evidence")
            elif state == "CLOSED":
                errors.append(f"{label}: stale awaiting-merge handoff; PR #{number} is CLOSED WITHOUT MERGE. Planning owner must correct the handoff and refresh views.")
            else:
                print(f"Delivery fresh: {identifier} PR #{number} is OPEN; human review/merge remains pending.")
        except (OSError, subprocess.SubprocessError, ValueError, TypeError):
            # Raw CLI/API diagnostics may contain credentials; do not echo them.
            errors.append(f"{label}: delivery verification INCOMPLETE (tooling/authentication/API/metadata or identity unavailable); planning owner must recover authoritative evidence. No fresh pass or merge is inferred.")
    return resolved, errors


def reconcile_delivery(records: Records, resolved: list[ResolvedDelivery]) -> dict[Path, str]:
    """Plan explicit administrative retirement, retaining exact observed merge/integration facts."""
    pending = {}
    observed = datetime.datetime.now(datetime.timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ")
    for identifier, path, pr in resolved:
        text = path.read_bytes().decode("utf-8")
        header, boundary, body = re.split(r"((?:\r\n|\r|\n)---(?:(?:\r\n|\r|\n)|$))", text, maxsplit=1)
        end = boundary.index("---")
        # Match the reader's stripped-key semantics; retain other bytes and line endings.
        header = "".join(line for line in (header + boundary[:end]).splitlines(keepends=True)
                         if line.partition(":")[0].strip() != "delivery")
        retired = header + boundary[end:] + body
        expected = {key: value for key, value in records[identifier][1].items() if key != "delivery"}
        if parse_frontmatter(retired) != expected:
            raise ValueError(f"{path.relative_to(ROOT)}: planned delivery retirement did not preserve the expected frontmatter")
        pending[path] = retired + "\n\n" + (
            f"### Delivery reconciliation — PR #{pr['number']}\n\n"
            f"Observed {observed}: {pr['url']} is MERGED into `{pr['baseRefName']}` at "
            f"`{pr['mergedAt']}`. Published head `{pr['headRefOid']}` is an ancestor of merge "
            f"`{pr['mergeCommit']['oid']}`, which is integrated in local HEAD `{pr['localHead']}`. "
            "Retired the ended delivery marker; implementation acceptance/QA and historical publication "
            "remain separate. No approval, merge, release or deployment was performed by reconciliation.\n"
        )
        records[identifier][1].pop("delivery")
    return pending


def main() -> int:
    parser = argparse.ArgumentParser(description=__doc__)
    mode = parser.add_mutually_exclusive_group()
    mode.add_argument("--write", action="store_true", help="refresh marked views after validating records and links")
    mode.add_argument("--check-delivery", action="store_true", help="read-only local validation plus live verification of explicit current delivery handoffs")
    mode.add_argument("--reconcile-delivery", action="store_true", help="authorized write: retire exact merged/integrated done handoffs, retain evidence and refresh views; fail closed otherwise")
    args = parser.parse_args()
    writing = args.write or args.reconcile_delivery
    errors: list[str] = []
    records = load_records(errors)
    validate_records(records, errors)
    validate_links(errors)
    try:
        ignored = subprocess.run(["git", "-c", f"safe.directory={ROOT.resolve()}", "check-ignore", "-q", ".runs/planning-check"],
                                 cwd=ROOT, check=False)
    except FileNotFoundError:
        ignored = None
    if ignored is not None and ignored.returncode != 0:
        errors.append(".runs/ must be gitignored")
    if not errors:
        for identifier, (_, data) in records.items():
            if identifier.startswith("TASK-") and data["status"] == "in-progress":
                waiting = task_waiting(data, records)
                if waiting:
                    errors.append(f"{identifier}: active TASK has unmet prerequisites: {', '.join(waiting)}")
    handoffs, repository = [], None
    if not errors:
        handoffs, repository, identity_errors = delivery_identity(records)
        errors.extend(identity_errors)
    resolved: list[ResolvedDelivery] = []
    pending: dict[Path, str] = {}
    if not errors and args.reconcile_delivery:
        resolved, delivery_errors = verify_delivery(handoffs, repository)
        errors.extend(delivery_errors)
        if not errors:
            try:
                pending = reconcile_delivery(records, resolved)
            except ValueError as exception:
                errors.append(str(exception))
    if not errors:
        refresh_views(records, writing, errors, pending)
    if errors:
        print("Planning validation failed:")
        for error in errors:
            print(f"- {error}")
        return 1
    active = sum(1 for _, data in records.values() if data["status"] not in TERMINAL)
    print(f"Local planning validation passed (offline): {len(records)} records, {active} active")
    if args.reconcile_delivery:
        print(f"Delivery reconciliation passed: {len(resolved)} ended handoff(s) retired; OPEN handoffs preserved. No historical PRs queried.")
        return 0
    if not args.check_delivery:
        print("Delivery freshness NOT CHECKED; routing publication/merge handoffs requires --check-delivery.")
        return 0
    resolved, delivery_errors = verify_delivery(handoffs, repository)
    if delivery_errors:
        print("Delivery verification failed or incomplete:")
        for error in delivery_errors:
            print(f"- {error}")
        return 1
    print(f"Delivery verification passed: {len(handoffs) - len(resolved)} OPEN handoff(s), {len(resolved)} merged/integrated handoff(s) resolved read-only; no historical PRs queried.")
    return 0


if __name__ == "__main__":
    sys.exit(main())
