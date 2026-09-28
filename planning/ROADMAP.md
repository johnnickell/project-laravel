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
[TASK-00001](tasks/00001-TASK.md) implements released packages/certification retirement. Draft
[PR #10](https://github.com/johnnickell/project-laravel/pull/10) also corrects the complete planning migration and
integrates the planning added by develop PR #9. Independent review accepts implementation `03207b9` with
local/hosted proof; TASK-00001 and T-00006 are done for that accepted candidate. The maintainer-approved
closeout contract keeps final metadata-head hosted verification and independent evidence review as delivery
gates; those gates are pending at this checkpoint, not waived by implementation acceptance.

[EPIC-00003](epics/00003-EPIC.md), formerly PRD-00002, preserves historical package/gate evidence and the
unresolved Common 2.0 requirement [T-00003](tickets/00003-TICKET.md). EPIC-00001 supersedes continuing
certification and the self-provisioning gate design; historical success does not certify their replacements.

## Route to 1.0

1. Complete the metadata-head delivery gates for accepted TASK-00001, then hand PR #10 to the maintainer for
   approval/merge. Preserve candidate acceptance separately from final delivery evidence.
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
Final closeout delivery remains pending at this checkpoint; no merge, release, or deployment is claimed.

[EPIC-00002](epics/00002-EPIC.md) preserves the completed governed starter foundation through T-00001 and
TASK-00002. Historical Common adoption, gate and recertification are retained under T-00002/TASK-00003,
T-00004/TASK-00004 and T-00005/TASK-00005. These records stay live and use the same hierarchy; no archive,
new verification, release or deployment is claimed by migrating them.
