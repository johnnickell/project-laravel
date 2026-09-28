---
id: T-00002
epic: EPIC-00003
title: Adopt Fight Common 1.2
status: done
blocked_by:
---

# Adopt Fight Common 1.2

## Problem and outcome

Historically adopt and certify the complete Laravel platform profile at the Common 1.2 candidate. Application
routes, templates, secrets, event mappings and policy remain local. The original executable record, exact
source references, test counts and lane/receipt hashes now live in [TASK-00003](../tasks/00003-TASK.md).

## Scope

- Candidate dependency graph, all 15 Common Laravel providers/shared fallbacks, booted integration journeys,
  fail-closed credential defaults, canonical receipt and lowest/latest evidence.
- Exclude Common 2.0, copied package source and release publication. Certification is historical, not a current
  obligation: [TASK-00001](../tasks/00001-TASK.md) retires it.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Install and certify the candidate profile | Maintenance install/verification, not a business command | Inspect package/profile compatibility | Synthetic certification events only; no new production event | Candidate lock, receipt and bounded integration evidence |

## Validation and permissions

Match the exact candidate/alias and reject unexpected Composer warnings. Preserve fail-closed JWT/HMAC
credentials. The provider inventory and synthetic messaging journeys did not establish a complete production
authentication, actor/target authorization, or durable-delivery use case.

## Acceptance and evidence

- [x] The `1.2.0-dev` alias resolves the recorded `dev-develop` candidate.
- [x] All 15 package Laravel providers and documented fallbacks are registered with local configuration.
- [x] The canonical complete-profile receipt and lowest/latest evidence match that candidate.
- [x] Only the intentional immutable-reference Composer warning is allowed; the exception is temporary.
- [x] Planning and the full build pass after the candidate HMAC request-signing fix.

Exact identities, hashes, all retained acceptance details and verification counts are preserved in TASK-00003.
These checkboxes retain historical acceptance, not a claim about today's retired platform profile.

## Decisions and dependencies

Former PRD-00002 is now [EPIC-00003](../epics/00003-EPIC.md). T-00005/TASK-00005 record the subsequent
source-tree-equivalent authorship rewrite; EPIC-00001 owns the later application-consumer direction.

## TASKs

<!-- planning:children -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [TASK-00003](../tasks/00003-TASK.md) | Adopt Fight Common 1.2 | done | [T-00002](00002-TICKET.md) | — |
<!-- /planning:children -->

## Progress

Historically complete. The [migration](../MIGRATION.md) preserves evidence and separates requirement ownership
from its delivered TASK; it neither recreates certification nor asserts fresh independent acceptance.
