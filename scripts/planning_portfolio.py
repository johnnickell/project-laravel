#!/usr/bin/env python3
"""Validate planning records and optionally refresh their explicitly marked views."""

from __future__ import annotations

import argparse
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
LEGACY_TICKETS = {f"T-{number:05d}" for number in range(1, 6)}
KINDS = {
    "epics": ("EPIC", "EPIC"),
    "tickets": ("T", "TICKET"),
    "tasks": ("TASK", "TASK"),
    "specs": ("PRD", "PRD"),
}
Record = tuple[Path, dict[str, str]]
Records = dict[str, Record]


def frontmatter(path: Path) -> dict[str, str]:
    text = path.read_text(encoding="utf-8")
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
        if prefix == "T":
            required_parent = "prd" if identifier in LEGACY_TICKETS else "epic"
            allowed_parents = {"prd"} if identifier in LEGACY_TICKETS else {"epic", "prd"}
        elif prefix == "TASK":
            required_parent = "ticket"
            allowed_parents = {"ticket"}
        elif prefix == "PRD":
            allowed_parents = {"epic"}
        if required_parent and not data.get(required_parent):
            errors.append(f"{label}: missing {required_parent} parent")
        for field, expected_prefix in (("epic", "EPIC-"), ("ticket", "T-"), ("prd", "PRD-")):
            parent = data.get(field)
            if not parent:
                continue
            if field not in allowed_parents:
                errors.append(f"{label}: {field} is not a parent at this level")
            if parent not in records or not parent.startswith(expected_prefix):
                errors.append(f"{label}: invalid {field} parent {parent}")
            elif prefix == "TASK" and parent in LEGACY_TICKETS:
                errors.append(f"{label}: legacy executable tickets cannot parent new TASKs")
        dependencies = blockers(data)
        if len(set(dependencies)) != len(dependencies):
            errors.append(f"{label}: duplicate blocker")
        for dependency in dependencies:
            if prefix not in {"T", "TASK"} or not re.fullmatch(rf"{prefix}-\d{{5}}", dependency):
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
    ticket_id = data["ticket"]
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


def board(source: Path, records: Records) -> str:
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
                text.append(f"| {cell(data.get('order', ''))} | {link(identifier, source, records)} | {cell(data['title'])} | "
                            f"{link(data['ticket'], source, records)} | {data['status']} | {readiness} | {cell(data.get('pr', ''))} |")
        sections.append("\n".join(text))
    return "\n\n".join(sections)


def planning_frontier(source: Path, records: Records) -> str:
    lines = ["| Record | Status | Next planning action |", "| --- | --- | --- |"]
    for identifier, (path, data) in sorted(records.items()):
        if not is_live(path) or data["status"] in TERMINAL or identifier in LEGACY_TICKETS:
            continue
        if not identifier.startswith(("EPIC-", "T-")):
            continue
        field = "epic" if identifier.startswith("EPIC-") else "ticket"
        child_prefix = "T-" if field == "epic" else "TASK-"
        children = [child for child_id, (_, child) in records.items()
                    if child_id.startswith(child_prefix) and child.get(field) == identifier]
        if not children:
            if data["status"] not in ACCEPTED:
                action = "Resolve the record's named decisions before decomposition."
            elif any(records[dependency][1]["status"] not in TERMINAL for dependency in blockers(data)):
                action = "Resolve requirement prerequisites before TASK readiness."
            else:
                action = "Decompose into requirements TICKETs." if field == "epic" else "Decompose accepted requirements into TASKs."
        elif all(child["status"] in TERMINAL for child in children):
            action = "Review parent acceptance and explicitly close or plan remaining scope."
        else:
            continue
        lines.append(f"| {link(identifier, source, records)} | {data['status']} | {action} |")
    return "\n".join(lines) if len(lines) > 2 else "No decomposition or closeout frontier."


def generated_views(records: Records) -> list[tuple[Path, str, str]]:
    views: list[tuple[Path, str, str]] = []
    for directory, (prefix, _) in KINDS.items():
        path = PLANNING / directory / "README.md"
        identifiers = sorted(identifier for identifier in records if identifier.startswith(prefix + "-"))
        if directory == "tickets":
            views.append((path, "requirements", table([identifier for identifier in identifiers if identifier not in LEGACY_TICKETS], path, records)))
            views.append((path, "legacy", table([identifier for identifier in identifiers if identifier in LEGACY_TICKETS], path, records)))
        else:
            views.append((path, "index", table(identifiers, path, records)))
    path = PLANNING / "tasks/BOARD.md"
    views.append((path, "tasks", board(path, records)))
    path = PLANNING / "ROADMAP.md"
    epics = sorted(identifier for identifier, (record_path, _) in records.items()
                   if identifier.startswith("EPIC-") and is_live(record_path) and records[identifier][1]["status"] not in TERMINAL)
    views.append((path, "epics", table(epics, path, records)))
    views.append((path, "frontier", planning_frontier(path, records)))
    for identifier, (path, _) in records.items():
        if not is_live(path) or identifier in LEGACY_TICKETS or not identifier.startswith(("EPIC-", "T-")):
            continue
        field = "epic" if identifier.startswith("EPIC-") else "ticket"
        child_prefix = "T-" if field == "epic" else "TASK-"
        children = sorted(child_id for child_id, (_, data) in records.items()
                          if child_id.startswith(child_prefix) and data.get(field) == identifier)
        views.append((path, "children", table(children, path, records)))
    return views


def refresh_views(records: Records, write: bool, errors: list[str]) -> None:
    changes: dict[Path, str] = {}
    stale: set[Path] = set()
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
            path.write_text(changes[path], encoding="utf-8")
            print(f"Refreshed {path.relative_to(ROOT)}")
    else:
        errors.extend(f"{path.relative_to(ROOT)}: stale generated view; run ./bin/planning-check --write" for path in sorted(stale))


def main() -> int:
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--write", action="store_true", help="refresh marked views after validating records and links")
    args = parser.parse_args()
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
    if not errors:
        refresh_views(records, args.write, errors)
    if errors:
        print("Planning validation failed:")
        for error in errors:
            print(f"- {error}")
        return 1
    active = sum(1 for _, data in records.values() if data["status"] not in TERMINAL)
    print(f"Planning validation passed: {len(records)} records, {active} active")
    return 0


if __name__ == "__main__":
    sys.exit(main())
