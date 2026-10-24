---
id: T-00012
epic: EPIC-00001
title: Upgrade the Laravel Consumer to Current Stable Fight Packages
status: done
blocked_by: T-00006
---

# Upgrade the Laravel Consumer to Current Stable Fight Packages

## Problem and outcome

Use the latest published stable Fight package baseline as the first implementation slice of the maintainer's
approved broad Agent OS adoption, retaining Laravel-native composition and existing observable behavior.
The 2026-10-24 release selection is Common 1.4.0 and AccessControl 0.8.0; this is not a floating promise to
adopt later releases without verification. T-00006's completed 1.2.0/0.4.0 cutover remains historical acceptance.

## Scope

- In scope: Composer constraints/lock, installed public-contract and migration inspection, required local
  compatibility changes, existing behavior verification, and current dependency/planning handoffs.
- Preserve Laravel/Eloquent/Pint, `app/`, existing HTML and credential/transaction behavior, exact configured
  coverage, and direct consumption of package-owned contracts.
- Out of scope: the successor gate, full API/SPA inventory, new authentication or authorization journeys,
  persistence schemas, upstream changes/publication, harness changes, enrollment, and certification machinery.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Restore the approved stable dependency baseline | Composer maintenance only; no business command | Inspect published/installed contracts | N/A: no new business fact | Reproducible lock and compatible application composition |
| Continue existing application interactions | Existing credential and transaction operations | Existing homepage and token reading | No new events | Preserve successful outcomes and fail-closed rejection/rollback |

## Validation and permissions

The maintainer approved the scope and main-checkout feature-branch execution on 2026-10-24. No new actor,
permission policy or endpoint is introduced. Keep credentials out of evidence and preserve application security
behavior. Package APIs remain upstream-owned; incompatible required contracts need a named decision, not aliases.

## Acceptance and evidence

- [x] Published stable Common 1.4.0 and AccessControl 0.8.0 resolve with matching lock/installed metadata and
      reviewed dependency changes, without unrelated upgrades or development aliases.
- [x] Relevant migration notes and public signatures are inspected; current consumer and downstream handoffs
      distinguish retained integrations from unimplemented capabilities.
- [x] Homepage, credential rejection/key selection/time tolerance, and transaction commit/rollback remain
      verified with exact 100% configured `app/` statement coverage; no coverage exclusions or meta-tests added.
- [ ] The existing canonical local gate passes; independent review/QA and exact-head hosted delivery evidence
      remain distinct. Required final delivery proof is not waived by a successful local build.

## Decisions and dependencies

The maintainer accepted this concrete first slice and checkout choice after the adoption assessment. Packagist
lists Common 1.4.0 at `87b9580c072f3149d574e09865daa79620c92118` and AccessControl 0.8.0 at
`319738255e682d587642b67856039f882b9588d6`. Both require PHP >=8.5; AccessControl requires Common ^1.3,
which admits 1.4.0. A successful consumer solve and owned behavior checks are still required.

Sources: [Common metadata](https://repo.packagist.org/p2/johnnickell/fight-common.json) and
[AccessControl metadata](https://repo.packagist.org/p2/johnnickell/fight-access-control.json).

One approved TASK covers this bounded requirement. T-00007/T-00011 retain their unresolved gate policies;
package adoption does not choose their winner. Broader workflow adoption remains an explicit EPIC planning handoff.

## TASKs

<!-- planning:children -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [TASK-00006](../tasks/00006-TASK.md) | Upgrade Fight Common to 1.4 and AccessControl to 0.8 | done | [T-00012](00012-TICKET.md) | [TASK-00001](../tasks/00001-TASK.md) |
<!-- /planning:children -->

## Progress

Requirements and the single-TASK slice accepted by the maintainer on 2026-10-24. TASK-00006's implementation
in the main checkout now installs both selected releases with only two package-record changes. Existing behavior
passes 13 tests / 27 assertions with 38/38 statements covered; the canonical local gate and production boot pass.
The [current contract handoff](../wayfinder/fight-package-baseline-1.4-0.8.md) records migration boundaries and
unresolved advisories in two unchanged third-party dependencies. Independent review accepts candidate
`4afe8af9b8673ef9a188acbd8516c64eb774ca34`; independent behavioral QA passes all seven scenarios, with visual
N/A and no findings. TASK-00006 records accepted completion and this TICKET closes automatically with its only
child. The final acceptance checkbox retains the outstanding exact-head hosted delivery portion, not missing
local review/QA. Publication/final-head verification are pending at this administrative checkpoint; no merge
is claimed. EPIC-00001 remains in progress because T-00007–T-00011 are unfinished. See the child's current
completion notes and eventual PR for delivery provenance; no separate parent-closeout action is needed.
