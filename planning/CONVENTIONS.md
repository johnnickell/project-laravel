# Planning Conventions

## Lightweight work routing

For “What's next?”, `next`, or an unqualified `/ask-matt`, use the routing entry in root AGENTS.md.
This read-only path precedes general orientation; full implementation, review, QA and delivery requirements
still apply when the selected workflow is invoked.

1. Run `./bin/planning-check --check-delivery` once before selection. It validates local views and live PR state
   for explicit current delivery handoffs only. Failure or unavailable evidence stops selection with the actual
   error and planning-owner handoff; do not refresh views or infer a merge. An ordinary offline planning/build
   pass is not delivery freshness. With no current delivery markers, no hosted query or credentials are needed.
2. Read only the Board's current human decision, active work, and (if no active work) first ready entry.
   Use local section names and authoritative order. Return all active TASKs, not a new winner. Inspect selected
   TASK metadata and its current handoff, plus blocker metadata only as needed. An unresolved contradiction
   is a named input gap, not permission to audit every record or infer acceptance from `done`.
3. Read the Wayfinder index's map-status/frontier inventory. Closed or decision-complete maps need no historical
   reread. For active/open maps, read only current frontier and decision/dependency status or explicit external
   prerequisite evidence needed for availability. Unknown state or an absent frontier needs its owner's input.
   Multiple available maps remain independent choices; no global priority is implied.
4. Use the Board/Roadmap's current planning handoff for unfinished decomposition, including closed maps.
   Verify the named phase in the owning record's current progress/approval section. Map closure, parent status
   and child counts do not prove complete decomposition. If the handoff is missing or contradictory, report
   the missing phase/owner; do not reconstruct it by reading every closed map and descendant.
5. Read canonical review/QA identity and disposition only when they change the selected route. Unresolved
   identity is an evidence handoff, never acceptance. Resolve capabilities under
   [implementation routing](#implementation-routing); load full skill instructions and references when invoked,
   not merely to recommend them.

Prefer heading searches and bounded section reads. Aim to retrieve no more than about 24,000 characters
of routing evidence; stop with a precise unresolved input before exceeding that scope unless the user requests
a deeper audit. Do not read append-only task histories, other worktrees' entire tasks, general architecture,
or all receiving skills to produce a recommendation. Return TASK, WAYFINDER, and relevant PLANNING/HUMAN INPUT;
stop without invoking a workflow or changing files. Missing indexes are reported, not fabricated.

During authorized planning updates, keep authored planning/decomposition handoffs source-linked and concise:
target, phase, pending decision/owner. Generated Board/Roadmap summaries own current TASK selection; do not
repeat it in authored prose. The Board's generated delivery section owns explicit current merge handoffs;
TASK completion notes preserve acceptance and historical delivery checkpoints, not a second live routing source.
Keep Wayfinder pointers current. These views are navigation aids, not acceptance or delivery proof. Preserve
historical decisions and label superseded checkpoints; reconcile affected READMEs rather than copying live state.

Routing sources: [TASK Board](tasks/BOARD.md), [Wayfinder inventory](wayfinder/README.md), [Roadmap](ROADMAP.md).

This document is the canonical planning authority for Fight Laravel Starter. The human-approved lifecycle is
**EPIC → TICKET → TASK**. All non-archived records use it, including migrated historical work. The
[complete migration map](MIGRATION.md) records renamed/moved identities and inherited evidence without claiming
unfinished work is complete. There is no live legacy-record exception.

## Implementation routing

For an approved executable TASK needing new implementation or confirmed implementation/QA defect repair,
recommend `/skill:build TASK-NNNNN` with its actual ID by default. Use `/skill:work TASK-NNNNN` only when the
operator explicitly requests implementation alone. A recommendation neither invokes a workflow nor grants
mutation, delegation or publication authority. During an already authorized Build, its coordinator owns stage
continuation and the shared revision allowance; do not start a nested Build or reset that allowance.

Resolve the actual configured provider's resources from harness/operator metadata or its supplied synopsis.
Explicit-only installed skills may be absent from the model-advertised list; absence alone is not evidence of
unavailability. Do not guess installation paths, copy a provider catalog or silently substitute Work for Build.
If the resource or authority cannot be established, name the missing prerequisite and stop the affected action.

Preserve evidence-specific routes: committed Work goes to independent `/skill:review TASK-NNNNN`; accepted
implementation with applicable QA outstanding goes to independent `/skill:qa TASK-NNNNN`; accepted implementation
with satisfied QA goes to authorized `/skill:land TASK-NNNNN`. Missing initial hosted proof alone uses the
authorized Land draft-evidence route then focused independent Review, not implementation repair. QA INCOMPLETE
names its prerequisite before QA resumes. Accepted A with administrative B awaiting final delivery proof stays
Land-owned. Planning, unavailable evidence and human decisions keep their actual owner; no default Build
recommendation overrides these routes or an explicit implementation-alone request. Full workflow/report binding
remains TASK-00010 scope, not a capability installed by these routing instructions.

## Hierarchy and ownership

| Level | Owns | Path and ID |
| --- | --- | --- |
| EPIC | Approved destination, outcome, boundaries | `epics/00001-EPIC.md` · `EPIC-00001` |
| TICKET | Cohesive use cases, requirements, acceptance evidence | `tickets/00006-TICKET.md` · `TICKET-00006` |
| TASK | Independently implementable/reviewable slice, normally one PR | `tasks/00001-TASK.md` · `TASK-00001` |
| PRD | Optional supporting specification, not a mandatory parent | `specs/00003-PRD.md` · `PRD-00003` (next available) |

Requirements TICKETs may need several TASKs and PRs. Do not implement an EPIC or TICKET directly or silently
rename a requirement into a TASK. Approve the destination, accept the requirements, then approve bounded TASKs.
Each level records use cases, commands, queries, events, validation, permissions, effects, and observable
acceptance at its own scope. Explain non-applicable concerns. A TASK should deliver a complete observable slice,
not merely one technical layer. Coordination notes belong in ignored `.runs/`, not another durable hierarchy.

ADRs remain in `adr/NNNN-description.md`, focused instructions in `agents/`, and investigation maps/decisions in
`wayfinder/`. `ROADMAP.md` records strategy. Wayfinder `WF-NNN` decisions are not requirements TICKETs or TASKs.

## Automatic parent completion

When a TASK becomes `done` or `wontfix`, complete eligible parent TICKETs and then EPICs in the same operation.
Count live and archived children. A live, non-terminal parent with at least one child closes when every child
is terminal: use `wontfix` if every child is `wontfix`, otherwise `done`. Parents without children or with an
unfinished child remain open. Preserve already-terminal and archived parents.

Child acceptance and intentional `wontfix` decisions remain with the child records. Parent completion requires
no separate assessment, independent review, QA, confirmation, or skill invocation. Record any remaining work as
an unfinished child rather than a separate parent-closeout gate. Parent status does not assert review, merge,
release, deployment or publication, and completion never archives records automatically.

Run `./bin/planning-check --write` during completion; it closes eligible parents and refreshes views.
Then run the read-only `./bin/planning-check`. Read-only validation never writes completion metadata.


## Identity and templates

EPIC, TICKET, TASK, and PRD IDs have independent five-digit sequences. TICKETs use `TICKET-NNNNN` identities
and numeric `NNNNN-TICKET.md` filenames, as approved in [TICKET-00013](tickets/00013-TICKET.md) and implemented
by TASK-00009. The former `T-NNNNN` encoding is historical provenance only, not an accepted metadata alias.
Suffixes, filenames and dependency semantics are preserved. Inspect live and archived records before allocating
IDs, including retired aliases in
[MIGRATION.md](MIGRATION.md). Preserve gaps and never reuse an archived or migrated-away identity
(PRD-00001/00002 are reserved; the next optional PRD is PRD-00003). File numbers must match record IDs.

Copy the directory's `_…_TEMPLATE.md` before authoring a record. Templates are not records and receive no ID.
Every record requires `id`, `title`, and `status`. EPICs also require `target` (use `TBD` until a version is selected).
New TICKETs require `epic: EPIC-NNNNN`; feature TASKs require `ticket: TICKET-NNNNN`. Standalone bug TASKs use
`kind: bug` and an explicit empty `ticket:` field; do not invent a parent merely to track a small repair.
TASK `kind` may be `feature` or `bug`; omitted kind means feature for existing records. An optional `prd: PRD-NNNNN` on a TICKET
links supporting material without replacing its EPIC parent. PRDs may optionally link an EPIC.

TASK metadata also includes `order` (optional positive integer, lower first) and `pr` (optional full PR URL).
Those fields do not claim review, merge, release, or deployment. Each TASK's acceptance/evidence and completion
notes record actual implementation and review state. No implicit execution or publication follows from planning.

### Current delivery handoffs

A live `done` TASK may set optional `delivery: awaiting-merge` with its verified `pr` URL to identify the current
human review/merge handoff. Omit or clear it when that handoff ends. Neither `done`, a historical PR link nor a
completion checkpoint creates a current delivery claim. The generated Board `planning:delivery` block mirrors
these markers. The marker does not assert final-head CI success or authorize merge; pending delivery proof stays
explicit in the owning TASK/PR and remains blocking under the existing acceptance/delivery contract.

Offline validation checks marker/TASK/PR/origin identity and generated views. `--check-delivery` additionally
uses existing operator `gh` access for at most 16 current handoffs, one read-only 15-second request per PR.
GitHub URL, number, repository and TASK-prefixed title must agree. OPEN permits the current human handoff;
MERGED and CLOSED WITHOUT MERGE reject it with distinct planning-owner corrections. Missing CLI/authentication,
API/network failure, malformed/contradictory metadata or identity mismatch is INCOMPLETE, never inferred merge
or a fresh pass. No historical PRs are queried and no fetch, publish, merge or record mutation occurs.

`--write` and `--check-delivery` are mutually exclusive. Ordinary checks, including the existing fail-fast
planning step in `./bin/build`, remain offline; the rest of the build still requires registry/dependency access.
Land sets the marker in its authorized publication closeout and follows [delivery pre-submit](#delivery-pre-submit-and-final-handoff).
After human merge/closure, the authorized planning owner verifies identity/evidence, reconciles the TASK's
current notes and affected docs, clears the marker and refreshes views. Read-only `next` reports the needed
reconciliation without making it; neither a marker nor its removal establishes acceptance.

## Status and readiness

The same status vocabulary has level-specific readiness:

| Status | Meaning |
| --- | --- |
| `needs-triage` | Scope/ownership has not been classified |
| `needs-info` | Named decisions or required evidence are missing |
| `ready-for-human` | Human judgment or an external action is next |
| `ready-for-agent` | EPIC: approved for requirement decomposition; TICKET: accepted and decision-complete for TASK decomposition; TASK: approved and executable when dependencies permit |
| `in-progress` | Child delivery or TASK implementation/revision is underway |
| `done` | The record's acceptance and required verification are complete; all children are terminal |
| `wontfix` | Explicitly closed without delivery; children must also be terminal |

Approval of an EPIC does not settle every child requirement. Approval of a ticket split does not resolve missing
package facts, policy choices, or a still-unspecified user journey. Record those as `needs-info` and name the
next decision. Do not invent implementation details to make the Board look ready.

`blocked_by` is a comma-separated list of same-level IDs: TICKETs reference TICKETs; TASKs reference TASKs.
EPICs/PRDs do not use execution blockers. External gates and Wayfinder decisions belong in the record's decision
section with links, not fictitious blocker IDs. Blocking is derived from non-terminal prerequisites; never store
`blocked` as a status. Preserve dependency edges after completion for traceability. A cancelled prerequisite
must be reviewed for whether the dependent requirement still makes sense before execution resumes.

A TASK is executable only when it is `ready-for-agent`, its TASK blockers are terminal, its parent TICKET and
EPIC have accepted scope (`ready-for-agent` or `in-progress`), and the parent TICKET's requirement blockers are
terminal. An approved standalone `kind: bug` TASK has no ancestor readiness or parent completion; its own
acceptance, TASK blockers, verification and independent review obligations still apply. Otherwise it is waiting or needs a decision. An active TASK does not become permission to bypass new
parent/dependency uncertainty. Apply [Automatic parent completion](#automatic-parent-completion) in the same operation that closes children. `done` does not imply merge, deployment, or independent review acceptance.

## Boards and source of truth

Record frontmatter owns status, hierarchy, dependencies, and TASK priority. Authored prose owns decisions and
acceptance. Generated sections are bounded by `<!-- planning:NAME -->` / `<!-- /planning:NAME -->` markers.

`tasks/BOARD.md` is the canonical execution frontier. It has an authored **"What's Next?" Contract**, **Now**
human-decision section, and **Wayfinder Review** pointer. Its `planning:next` summary in **Now** and Roadmap
`planning:execution` summary share the same priority/readiness grouping as **Active Work**, **Ready Frontier**,
**Waiting**, **Needs Info**, **Human Action**, **Needs Triage**, and **Recently Done**. They show all active TASKs,
otherwise the first ready TASK, plus human/needs-info inputs and the first waiting/triage reasons when idle.
The Board's **Current delivery** is generated separately from explicit delivery markers. Only TASKs are
execution rows. Never substitute a requirement TICKET because no TASK exists.

For "What's next?" or an unqualified invocation, return the human decision under **Now** and the active TASK,
if any; otherwise return the first executable TASK under **Ready Frontier**. If neither exists, say there is no
executable TASK and point to the named planning decision. Do not start a second TASK just because its ID is lower.
Priority comes from TASK `order`; unranked tasks follow ranked tasks, with IDs breaking ties deterministically.

Live EPICs list child TICKETs and live requirement TICKETs list child TASKs in generated tables. Indexes derive
statuses from records. `ROADMAP.md` retains authored strategy and a generated **Planning Frontier** for missing
children for decomposition. This exposes decomposition without promoting planning to execution.

After editing planning records:

```sh
./bin/planning-check --write
./bin/planning-check
```

`--write` validates records/links before refreshing marked views. The read-only command fails on invalid
identities, parents, dependency cycles, impossible parent completion, broken links, or stale generated sections.
The write command derives eligible parent completion; neither command invents child acceptance, decisions or records.
Current TASK summaries and delivery rows are checked alongside indexes. The canonical build uses the offline
read-only check; it cannot certify authored prose or live hosting state.
Validate planning tooling through these owning commands and direct inspection, not product-suite meta-tests.

## Migrated records and historical evidence

The maintainer authorized complete conversion of non-archived planning, including completed live records.
[MIGRATION.md](MIGRATION.md) maps former destination PRDs to EPICs and executable tickets to requirements plus
historical TASKs. Original acceptance bodies, source references, counts and hosted links remain in those TASKs;
`done` is inherited historical acceptance, not fresh verification or an invented independent review.

TICKET-00003 remains the EPIC-00003-linked Common 2.0 requirement, `needs-info` until its upstream artifacts exist.
Do not create an executable TASK before accepting its requirements. TICKET-00011 preserves the concurrent develop-side
lean-gate requirement formerly named T-00006; reconcile its policy with TICKET-00007 before successor-gate decomposition.
The old `tickets/BOARD.md` is removed; only `tasks/BOARD.md` routes execution. No archive or new completion follows
from conversion. Archived records, if present during a future migration, are not moved as an implicit side effect.

## Wayfinder

Maps investigate uncertain destinations before the requirements or implementation route is clear. Each map has
an Active/Closed status, destination and done condition, linked decision summaries, a ticket table, dependencies,
one Frontier, remaining fog, and exclusions. Use `_MAP_TEMPLATE.md`. Material decisions live in linked
`WF-NNN` records; a map is their index, not a duplicate policy store. Use the decision template and keep its
status Open or Closed. Research artifacts stay with the map.

`wayfinder/README.md` indexes maps. The TASK Board may name one concrete, unblocked Wayfinder Review candidate;
link the map and its frontier decision. This advisory pointer never overrides implementation priority or the
map's decision authority. Say none if there is no suitable candidate; do not invent planning work.

A resolved map hands off to an approved EPIC, accepted requirements TICKETs, then bounded TASKs, with optional
supporting PRDs. Closing a map requires all its decisions closed, no frontier, and links to its handoff.
Lifecycle migration alone never closes a map or changes an unsettled technical decision.

## Archive operation — explicit request only

Use `./bin/archive-planning` only when explicitly asked to archive. Inspect its dry run before `--apply`.
Never move records manually or archive as a completion side effect.

| Records | Command shape | Destination |
| --- | --- | --- |
| TASKs | `./bin/archive-planning tasks TASK-00001 … [--apply]` | `tasks/archive/` |
| TICKETs | `./bin/archive-planning tickets TICKET-00006 … [--apply]` | `tickets/archive/` |
| EPICs | `./bin/archive-planning epics EPIC-00001 … [--apply]` | `epics/archive/` |
| PRDs | `./bin/archive-planning specs PRD-00001 … [--apply]` | `specs/archive/` |
| Wayfinder | `./bin/archive-planning wayfinder map-name [--apply]` | Existing Wayfinder archive directories |

Selected records must be terminal; all child/descendant records, including archived ones, must be terminal.
Optional supporting PRD relationships remain part of descendant validation. Wayfinder maps additionally require Closed
decisions, no frontier, and a linked handoff. The tool repairs links and refreshes generated views. After an
applied archive, inspect references and authored Board/Roadmap narrative, then run `./bin/planning-check`.
Records remain addressable: never renumber, flatten, or replace them with summaries.

## Branches and completion synchronization

Use `feature/<description>` branches from `develop`; preserve established branches and never commit directly
to `develop` or `main`. `.runs/<YYYY-MM-DD>-<slug>/` is ignored coordination scratch and must not be staged.

Before a commit or PR:

1. Record the TASK's actual acceptance, verification, review state, and PR link when known. Mark `done` only when
   its required acceptance and verification are complete; outstanding review/publication remain explicit.
2. Reconcile parent TICKET and EPIC progress against their criteria; one completed TASK does not complete a
   multi-TASK requirement. Update any affected supporting PRD without rewriting historical outcomes.
3. Preserve dependency edges, recalculate readiness, and update the Board's authored **Now** decision and
   Wayfinder pointer if their authority changed.
4. Update `ROADMAP.md` strategy and affected README/context/current record handoffs when the milestone changed;
   remove obsolete current actions while preserving historical checkpoints. Refresh generated views with
   `--write`, then run the read-only planning check. Generated consistency is not a prose audit.
5. Run the complete repository-owned `./bin/build` using the prescribed detached execution/exit-artifact check.
   Focused checks are iteration evidence, not a substitute for the pre-submit gate.

### Delivery pre-submit and final handoff

These target-specific steps apply to shared Land in this repository, without modifying or copying the provider
skill. Land owns authorized TASK/parent closeout, generated views and affected authored documentation together:

1. At intake and immediately before push/PR publication, run `./bin/planning-check --check-delivery`. An offline
   build or an earlier live check does not substitute. If it reports an ended handoff, verify the exact PR's
   merge/closure evidence; within authorized planning scope reconcile current TASK notes, clear its marker,
   and update affected Board/Roadmap/README/context and parent handoffs. Missing scope/evidence stops publication
   with the precise owner/input. Preserve historical review/QA reports and acceptance identities.
2. Before closeout commits, reconcile these same authored documents with the verified implementation and actual
   stage; point readers to current generated routing rather than repeating a transient Land/merge instruction.
   Label any retained delivery-pending note as a checkpoint in its owning record, not the next action in Board,
   Roadmap or READMEs. Refresh views with `--write`, inspect the resulting diff/parent rollup, and rerun validation.
3. Record the actual PR URL and current `delivery: awaiting-merge` marker as part of authorized closeout. Run the
   canonical gate before every commit/PR as above. Any metadata commit moves the delivery candidate: retain the
   draft and resources until required final-head proof covers that candidate. This changes no acceptance or
   hosted-verification requirement and authorizes no extra commit merely to record successful CI.
4. After final metadata/view changes and publication, rerun `--check-delivery` and inspect affected authored
   handoffs. Verify the intended published head and required delivery proof separately; an OPEN PR is not CI,
   independent acceptance, QA or merge approval. Record final proof in the ignored receipt/PR body under the
   existing finite closeout contract. No successful Land handoff while required verification is incomplete.
5. Hand off the actual PR to human review/merge. A later human merge or closure ends the marker; subsequent
   routing catches it and requests authorized reconciliation, never another implementation/review cycle merely
   because delivery history moved. Land does not merge and cannot promise freshness after a concurrent change.

Planning-only changes may update guidance and records under explicit human approval without fabricating an
implementation TASK for the migration itself. They still require the canonical gate before any commit or PR.
