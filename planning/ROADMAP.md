# Roadmap

## Current execution

<!-- planning:execution -->
| Route | TASK | Title | Status | Readiness |
| --- | --- | --- | --- | --- |
| Active Work | [TASK-00009](tasks/00009-TASK.md) | Adopt Agent OS Planning Identities | in-progress | — |
<!-- /planning:execution -->

The [TASK Board](tasks/BOARD.md) owns execution order and explicit current delivery handoffs. Validate current
routing with `./bin/planning-check --check-delivery`; historical milestone notes below are not pending actions.

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
on 2026-10-24. [TICKET-00012](tickets/00012-TICKET.md) / [TASK-00006](tasks/00006-TASK.md) delivered the first
slice: Common 1.4.0 / AccessControl 0.8.0, independently accepted at `4afe8af` with behavioral QA PASS.
Required hosted delivery proof passed for reconciled published head `a93e222` under the maintainer-approved
identical-tree merge-candidate contract; PR #13 merged into develop at `3fa576d`. See the TASK's completion
notes for provenance. Neither Land nor another review cycle remains pending for that slice.
EPIC-00001 remains open. The approved remaining adoption split is recorded in
[TICKET-00013](tickets/00013-TICKET.md) (workflow/evidence binding) and [TICKET-00014](tickets/00014-TICKET.md)
(prospective closeout); both have accepted concrete requirements. TICKET-00013's complete two-TASK plan is approved:
TASK-00009 migrates naming and TASK-00010 delivers the workflow/report binding after TASK-00009. TICKET-00014's
complete single-TASK plan is approved as TASK-00011, with no TASK blockers. TASK plans for this selected slice
are complete; the TASK Board owns execution order. TASK-00009 implements coherent naming and the approved
local default-Build recommendation, awaiting independent Review, applicable QA and required hosted proof.
TICKET-00013 remains in progress; TASK-00010's binding and TASK-00011's general closeout rollout remain
unimplemented. TASK-00007 supplies standalone-bug planning support. TASK-00008's bounded routing/delivery
synchronization repair is delivered and merged through PR #15 at `54a071d`; its completion notes preserve acceptance and merge evidence.
These slices do not implement the entire amendment or authorize changing the harness provider.

[EPIC-00003](epics/00003-EPIC.md), formerly PRD-00002, preserves historical package/gate evidence and the
unresolved Common 2.0 requirement [TICKET-00003](tickets/00003-TICKET.md). EPIC-00001 supersedes continuing
certification and the self-provisioning gate design; historical success does not certify their replacements.

## Security maintenance

[TASK-00007](tasks/00007-TASK.md) is done for the independently accepted PHP/Node/NGINX container-baseline
repair and narrow standalone-bug planning support. QA-01 remains preserved as the prior-candidate finding; the
cycle-1 bounded build-cache cleanup was independently reviewed and affected QA passed on the repaired candidate.
Completion records accepted local delivery, not production deployment, release, merge, or resolution of existing
Composer advisories. It remains independent of successor-gate and package-upgrade work; its pre-existing CLI
entrypoint finding remains a separate scope decision.

## Route to 1.0

1. Follow the [TASK Board](tasks/BOARD.md) for execution of the fully planned adoption slice:
   [TICKET-00013](tickets/00013-TICKET.md)'s [TASK-00009](tasks/00009-TASK.md) and dependent
   [TASK-00010](tasks/00010-TASK.md), plus [TICKET-00014](tickets/00014-TICKET.md)'s independent
   [TASK-00011](tasks/00011-TASK.md). No further child decomposition remains in these accepted splits; no
   acceptance is claimed for unfinished work. Naming implementation now reconciles records, references and tooling
   while preserving numeric suffixes and history; independent assessment and hosted acceptance proof are pending.
   Account for delivered standalone-bug support and bounded planning synchronization without duplicating them. Preserve the existing gate until its replacement lands. This
   explicitly selected foundation slice does not complete the broader API/SPA map's decisions or EPIC handoff.
2. Reconcile the successor-gate requirements in [TICKET-00007](tickets/00007-TICKET.md) and
   [TICKET-00011](tickets/00011-TICKET.md): exact Unit-only versus all-suite coverage, Covers annotations, PHPCS
   standard, production-install inspection and explicit CI setup/lifecycle. Both scopes remain preserved;
   neither is ready for TASK decomposition until the policy is settled. TICKET-00006's prerequisite is now satisfied.
3. Select the real journey and permission policy, then deliver application authorization, Laravel/Eloquent
   persistence and HTTP evidence under [TICKET-00008](tickets/00008-TICKET.md), [TICKET-00009](tickets/00009-TICKET.md), and
   [TICKET-00010](tickets/00010-TICKET.md). Preserve their dependency edges and open Wayfinder decisions.
   Future MCP reuses authorization; no MCP server or full API/SPA implementation is included in this epic.
4. Revisit Common 2.0 only after its owning migration authority exists. No application release version is selected.

## Planning Frontier

<!-- planning:frontier -->
| Record | Status | Next planning action |
| --- | --- | --- |
| [TICKET-00003](tickets/00003-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [TICKET-00007](tickets/00007-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [TICKET-00008](tickets/00008-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [TICKET-00009](tickets/00009-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [TICKET-00010](tickets/00010-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
| [TICKET-00011](tickets/00011-TICKET.md) | needs-info | Resolve the record's named decisions before decomposition. |
<!-- /planning:frontier -->

## Completed / Released

TASK-00001/TICKET-00006 are accepted at `03207b9` for the released-package consumer cutover and certification retirement.
The final-delivery review accepts `fbd110f`, and local develop includes PR #10's merge at `f13a727`.
This current routing reconciliation does not rewrite the original acceptance checkpoint or claim release/deployment.

[EPIC-00002](epics/00002-EPIC.md) preserves the completed governed starter foundation through TICKET-00001 and
TASK-00002. Historical Common adoption, gate and recertification are retained under TICKET-00002/TASK-00003,
TICKET-00004/TASK-00004 and TICKET-00005/TASK-00005. These records stay live and use the same hierarchy; no archive,
new verification, release or deployment is claimed by migrating them.
