# Roadmap

## In progress

<!-- planning:epics -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [EPIC-00001](epics/00001-EPIC.md) | Align the Laravel Application Foundation and Shared Authorization | in-progress | — | — |
<!-- /planning:epics -->

EPIC-00001's destination and five requirement areas are approved. The separately approved planning lifecycle
migration establishes EPIC → TICKET → TASK while preserving historical IDs and evidence.
[TASK-00001](tasks/00001-TASK.md) implements the selected package baseline and certification retirement with a
passing local gate. Hosted exact-head verification and independent review remain pending; T-00006 is not done.

[PRD-00002](specs/00002-PRD.md) remains supporting/historical context: prior package adoption and gate evidence
remain valid historical results; EPIC-00001 supersedes future certification obligations and the self-provisioning
gate design. Common 2.0 remains separate and unresolved under legacy [T-00003](tickets/00003-TICKET.md).

## Route to 1.0

1. Review [TASK-00001](tasks/00001-TASK.md) under [T-00006](tickets/00006-TICKET.md). Common 1.2.0 /
   AccessControl 0.4.0 are installed; bounded local integration and the canonical gate pass. Obtain separately
   authorized hosted exact-head verification before closing the remaining requirement.
2. Retire package-support certification and adopt the running-stack PHP gate under
   [T-00006](tickets/00006-TICKET.md) and [T-00007](tickets/00007-TICKET.md).
3. Settle the shared real journey and permission policy, then deliver application authorization, bounded
   Laravel/Eloquent persistence, and HTTP evidence under [T-00008](tickets/00008-TICKET.md),
   [T-00009](tickets/00009-TICKET.md), and [T-00010](tickets/00010-TICKET.md). Reconcile affected open Wayfinder
   decisions without claiming the full API/SPA map is complete. Future MCP reuses authorization; no MCP server
   is included in this epic.
4. Revisit Common 2.0 only after its owning migration authority exists. No application release version is
   selected, and no publication is authorized.

## Planning Frontier

<!-- planning:frontier -->
| Record | Status | Next planning action |
| --- | --- | --- |
| [T-00007](tickets/00007-TICKET.md) | ready-for-agent | Resolve requirement prerequisites before TASK readiness. |
| [T-00008](tickets/00008-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [T-00009](tickets/00009-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [T-00010](tickets/00010-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
<!-- /planning:frontier -->

## Completed / Released

The governed Laravel Starter Foundation is complete: legacy T-00001 has successful repository-local and hosted
`./bin/build` evidence. Those results do not certify the unimplemented replacement gate or the new package baseline.
