# Roadmap

## In progress

<!-- planning:epics -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [EPIC-00001](epics/00001-EPIC.md) | Align the Laravel Application Foundation and Shared Authorization | in-progress | — | — |
| [EPIC-00003](epics/00003-EPIC.md) | Fight Common Version Adoption and Support Evidence | in-progress | — | — |
<!-- /planning:epics -->

All non-archived planning now uses EPIC → TICKET → TASK. The [migration map](MIGRATION.md) preserves old
identities, source snapshots and historical evidence; no live legacy execution tier or second Board remains.

[EPIC-00001](epics/00001-EPIC.md) owns the application-consumer direction and shared authorization foundation.
[TASK-00001](tasks/00001-TASK.md) delivered released packages/certification retirement and the planning
migration through [PR #10](https://github.com/johnnickell/project-laravel/pull/10). Local develop contains its
merge at `f13a727`; the canonical independent review accepts final-delivery candidate `fbd110f`, retaining
implementation acceptance at `03207b9`. Earlier tracked delivery-pending notes are historical checkpoints.

The maintainer approved [broad Agent OS adoption with Laravel exceptions](epics/00001-EPIC.md#approved-broad-adoption-amendment--2026-10-24)
on 2026-10-24. [T-00012](tickets/00012-TICKET.md) / [TASK-00006](tasks/00006-TASK.md) is the accepted first
slice: Common 1.4.0 / AccessControl 0.8.0 in the main checkout on a feature branch. Candidate `4afe8af` now has
independent review acceptance and behavioral QA PASS; TASK-00006/T-00012 are done, with final publication and
exact-head hosted delivery verification pending at the administrative checkpoint. EPIC-00001 remains open.
Remaining workflow/binding and future closeout changes need bounded decomposition after this slice.
TASK-00007 supplies the narrow standalone-bug planning support; the broader amendment does not claim its other
mechanisms are implemented or authorize changing the harness provider.

[EPIC-00003](epics/00003-EPIC.md), formerly PRD-00002, preserves historical package/gate evidence and the
unresolved Common 2.0 requirement [T-00003](tickets/00003-TICKET.md). EPIC-00001 supersedes continuing
certification and the self-provisioning gate design; historical success does not certify their replacements.

## Security maintenance

[TASK-00007](tasks/00007-TASK.md) is done for the independently accepted PHP/Node/NGINX container-baseline
repair and narrow standalone-bug planning support. QA-01 remains preserved as the prior-candidate finding; the
cycle-1 bounded build-cache cleanup was independently reviewed and affected QA passed on the repaired candidate.
Completion records accepted local delivery, not production deployment, release, merge, or resolution of existing
Composer advisories. It remains independent of successor-gate and package-upgrade work; its pre-existing CLI
entrypoint finding remains a separate scope decision.

## Route to 1.0

1. Complete authorized publication and exact published-head hosted delivery verification for accepted
   TASK-00006, then human PR review/merge. Its review/QA acceptance is complete; do not reopen it solely for
   administrative closeout. The planning owner next decomposes the remaining approved workflow adoption into
   requirements and TASKs; preserve the existing gate until its replacement lands.
2. Reconcile the successor-gate requirements in [T-00007](tickets/00007-TICKET.md) and
   [T-00011](tickets/00011-TICKET.md): exact Unit-only versus all-suite coverage, Covers annotations, PHPCS
   standard, production-install inspection and explicit CI setup/lifecycle. Both scopes remain preserved;
   neither is ready for TASK decomposition until the policy is settled. T-00006's prerequisite is now satisfied.
3. Select the real journey and permission policy, then deliver application authorization, Laravel/Eloquent
   persistence and HTTP evidence under [T-00008](tickets/00008-TICKET.md), [T-00009](tickets/00009-TICKET.md), and
   [T-00010](tickets/00010-TICKET.md). Preserve their dependency edges and open Wayfinder decisions.
   Future MCP reuses authorization; no MCP server or full API/SPA implementation is included in this epic.
4. Revisit Common 2.0 only after its owning migration authority exists. No application release version is selected.

## Planning Frontier

<!-- planning:frontier -->
| Record | Status | Next planning action |
| --- | --- | --- |
| [T-00003](tickets/00003-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [T-00007](tickets/00007-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [T-00008](tickets/00008-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [T-00009](tickets/00009-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [T-00010](tickets/00010-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [T-00011](tickets/00011-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
<!-- /planning:frontier -->

## Completed / Released

TASK-00001/T-00006 are accepted at `03207b9` for the released-package consumer cutover and certification retirement.
The final-delivery review accepts `fbd110f`, and local develop includes PR #10's merge at `f13a727`.
This current routing reconciliation does not rewrite the original acceptance checkpoint or claim release/deployment.

[EPIC-00002](epics/00002-EPIC.md) preserves the completed governed starter foundation through T-00001 and
TASK-00002. Historical Common adoption, gate and recertification are retained under T-00002/TASK-00003,
T-00004/TASK-00004 and T-00005/TASK-00005. These records stay live and use the same hierarchy; no archive,
new verification, release or deployment is claimed by migrating them.
