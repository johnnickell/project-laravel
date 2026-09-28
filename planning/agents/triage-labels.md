# Triage and readiness

Use the status definitions in [planning conventions](../CONVENTIONS.md#status-and-readiness).

- `needs-triage`: unclassified scope or ownership.
- `needs-info`: named decisions or evidence are missing.
- `ready-for-human`: human judgment or an external action is next.
- `ready-for-agent`: approved EPIC for requirements decomposition; accepted, decision-complete TICKET for TASK
  decomposition; approved TASK for execution when its own and parent dependencies permit.
- `in-progress`: child delivery or TASK implementation/revision is underway.
- `done`: acceptance and required verification complete, with all children terminal.
- `wontfix`: explicitly closed without delivery, with all children terminal.

Blocking is derived from unfinished same-level `blocked_by` edges and TASK ancestor readiness, never stored as
`blocked`. Preserve completed dependency edges. Do not confuse an approved split with resolved requirements,
TASK completion with parent completion, or `done` with independent review, merge, release, or deployment.
