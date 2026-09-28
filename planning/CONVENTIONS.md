# Planning Conventions

This document is the canonical planning authority for Fight Laravel Starter. The human-approved lifecycle is
**EPIC → TICKET → TASK**. All non-archived records use it, including migrated historical work. The
[complete migration map](MIGRATION.md) records renamed/moved identities and inherited evidence without claiming
unfinished work is complete. There is no live legacy-record exception.

## Hierarchy and ownership

| Level | Owns | Path and ID |
| --- | --- | --- |
| EPIC | Approved destination, outcome, boundaries | `epics/00001-EPIC.md` · `EPIC-00001` |
| TICKET | Cohesive use cases, requirements, acceptance evidence | `tickets/00006-TICKET.md` · `T-00006` |
| TASK | Independently implementable/reviewable slice, normally one PR | `tasks/00001-TASK.md` · `TASK-00001` |
| PRD | Optional supporting specification, not a mandatory parent | `specs/00003-PRD.md` · `PRD-00003` (next available) |

Requirements TICKETs may need several TASKs and PRs. Do not implement an EPIC or TICKET directly or silently
rename a requirement into a TASK. Approve the destination, accept the requirements, then approve bounded TASKs.
Each level records use cases, commands, queries, events, validation, permissions, effects, and observable
acceptance at its own scope. Explain non-applicable concerns. A TASK should deliver a complete observable slice,
not merely one technical layer. Coordination notes belong in ignored `.runs/`, not another durable hierarchy.

ADRs remain in `adr/NNNN-description.md`, focused instructions in `agents/`, and investigation maps/decisions in
`wayfinder/`. `ROADMAP.md` records strategy. Wayfinder `WF-NNN` decisions are not requirements TICKETs or TASKs.

## Identity and templates

EPIC, TICKET, TASK, and PRD IDs have independent five-digit sequences. Retain the repository's `T-` ticket prefix;
do not renumber existing tickets to match another repository. Inspect live and archived records before allocating
IDs, including retired aliases in [MIGRATION.md](MIGRATION.md). Preserve gaps and never reuse an archived or
migrated-away identity (PRD-00001/00002 are reserved; the next optional PRD is PRD-00003). File numbers must match record IDs.

Copy the directory's `_…_TEMPLATE.md` before authoring a record. Templates are not records and receive no ID.
Every record requires `id`, `title`, and `status`. EPICs also require `target` (use `TBD` until a version is selected).
New TICKETs require `epic: EPIC-NNNNN`; TASKs require `ticket: T-NNNNN`. An optional `prd: PRD-NNNNN` on a TICKET
links supporting material without replacing its EPIC parent. PRDs may optionally link an EPIC.

TASK metadata also includes `order` (optional positive integer, lower first) and `pr` (optional full PR URL).
Those fields do not claim review, merge, release, or deployment. Each TASK's acceptance/evidence and completion
notes record actual implementation and review state. No implicit execution or publication follows from planning.

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
terminal. Otherwise it is waiting or needs a decision. An active TASK does not become permission to bypass new
parent/dependency uncertainty. No parent closes automatically: verify its own acceptance and explain any waived
or cancelled child scope first. `done` does not imply merge, deployment, or independent review acceptance.

## Boards and source of truth

Record frontmatter owns status, hierarchy, dependencies, and TASK priority. Authored prose owns decisions and
acceptance. Generated sections are bounded by `<!-- planning:NAME -->` / `<!-- /planning:NAME -->` markers.

`tasks/BOARD.md` is the canonical execution frontier. It has an authored **"What's Next?" Contract**, **Now**
human-decision section, and **Wayfinder Review** pointer. Its generated sections are **Active Work**,
**Ready Frontier**, **Waiting**, **Needs Info**, **Human Action**, **Needs Triage**, and **Recently Done**.
Only TASKs are execution rows. Never substitute a requirement TICKET because no TASK exists.

For "What's next?" or an unqualified invocation, return the human decision under **Now** and the active TASK,
if any; otherwise return the first executable TASK under **Ready Frontier**. If neither exists, say there is no
executable TASK and point to the named planning decision. Do not start a second TASK just because its ID is lower.
Priority comes from TASK `order`; unranked tasks follow ranked tasks, with IDs breaking ties deterministically.

Live EPICs list child TICKETs and live requirement TICKETs list child TASKs in generated tables. Indexes derive
statuses from records. `ROADMAP.md` retains authored strategy and a generated **Planning Frontier** for missing
children or parent closeout. This exposes decomposition without promoting planning to execution.

After editing planning records:

```sh
./bin/planning-check --write
./bin/planning-check
```

`--write` validates records/links before refreshing marked views. The read-only command fails on invalid
identities, parents, dependency cycles, impossible parent completion, broken links, or stale generated sections.
Neither command invents statuses, decisions, tickets, or tasks. The canonical build uses the read-only check.
Validate planning tooling through these owning commands and direct inspection, not product-suite meta-tests.

## Migrated records and historical evidence

The maintainer authorized complete conversion of non-archived planning, including completed live records.
[MIGRATION.md](MIGRATION.md) maps former destination PRDs to EPICs and executable tickets to requirements plus
historical TASKs. Original acceptance bodies, source references, counts and hosted links remain in those TASKs;
`done` is inherited historical acceptance, not fresh verification or an invented independent review.

T-00003 remains the EPIC-00003-linked Common 2.0 requirement, `needs-info` until its upstream artifacts exist.
Do not create an executable TASK before accepting its requirements. T-00011 preserves the concurrent develop-side
lean-gate requirement formerly named T-00006; reconcile its policy with T-00007 before successor-gate decomposition.
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
| TICKETs | `./bin/archive-planning tickets T-00006 … [--apply]` | `tickets/archive/` |
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
4. Update `ROADMAP.md` strategy when the milestone changed; refresh generated views with `--write`, then run
   the read-only planning check.
5. Run the complete repository-owned `./bin/build` using the prescribed detached execution/exit-artifact check.
   Focused checks are iteration evidence, not a substitute for the pre-submit gate.

Planning-only changes may update guidance and records under explicit human approval without fabricating an
implementation TASK for the migration itself. They still require the canonical gate before any commit or PR.
