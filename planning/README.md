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

Only T-00001 through T-00005 retain legacy executable-ticket/PRD semantics. Their IDs, evidence, and historical
meaning are preserved; no retrospective TASKs are created. [tickets/BOARD.md](tickets/BOARD.md) is a legacy
snapshot, not a competing execution board. PRDs are no longer a mandatory parent for new TICKETs.

Use each directory's `_…_TEMPLATE.md`. After changes, run `./bin/planning-check --write`, then
`./bin/planning-check`. Record metadata is authoritative; marked generated views must not be hand-edited.
Never archive as a completion side effect. Use `./bin/archive-planning` only on an explicit request, review its
dry run, then apply it. Ignored coordination scratch stays under `.runs/` and must not be staged.
