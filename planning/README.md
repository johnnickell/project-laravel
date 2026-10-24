# Planning

This directory is the committed planning authority for Fight Laravel Starter.

- `epics/` owns approved destinations and boundaries.
- `tickets/` owns cohesive requirements and acceptance evidence, not implementation assignments.
- `tasks/` owns bounded implementation slices, normally one PR each.
- [tasks/BOARD.md](tasks/BOARD.md) is the canonical execution frontier and "What's next?" entrypoint.
- `specs/` holds optional supporting PRDs and historical specifications.
- `ROADMAP.md` records strategy and exposes the planning/decomposition frontier.
- `adr/` records architectural decisions; `agents/` contains focused working instructions.
- [wayfinder/README.md](wayfinder/README.md) indexes pre-implementation investigation maps and decision tickets.

Read [CONVENTIONS.md](CONVENTIONS.md) for EPIC → TICKET → TASK ownership, approval/readiness, metadata,
completion synchronization, and explicit-only archives. Each record level has an independent five-digit ID
sequence. TICKETs keep `T-NNNNN`; TASKs use `TASK-NNNNN`. Inspect live and archived records before allocation.

All non-archived records use this structure, including historical completed work. The
[complete migration map](MIGRATION.md) traces former destination PRDs to EPICs and executable tickets to
requirements plus historical TASKs. Counts, acceptance and source references retain their historical meaning;
no new verification or independent acceptance is fabricated. There is no second ticket execution board.
PRDs are optional supporting specifications, never substitutes for EPIC parents.

Use each directory's `_…_TEMPLATE.md`. After changes, run `./bin/planning-check --write`, then
`./bin/planning-check`. Before routing or publication use `./bin/planning-check --check-delivery` for explicit
current handoffs; the offline check does not verify live PR state. Record metadata is authoritative; marked
generated views must not be hand-edited. Land reconciles affected authored Board/Roadmap/README handoffs under
[delivery pre-submit](CONVENTIONS.md#delivery-pre-submit-and-final-handoff); later human merge/closure requires
authorized marker reconciliation, not a new acceptance cycle.
Never archive as a completion side effect. Use `./bin/archive-planning` only on an explicit request, review its
dry run, then apply it. Ignored coordination scratch stays under `.runs/` and must not be staged.
