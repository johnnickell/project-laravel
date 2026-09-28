---
id: T-00006
epic: EPIC-00001
title: Adopt Current Fight Packages as an Application Consumer
status: done
blocked_by:
---

# Adopt Current Fight Packages as an Application Consumer

## Problem and outcome

The application still consumes development snapshots and certifies a complete upstream platform profile.
Adopt a verified Common 1.2+ / AccessControl 0.4+ release baseline and retain only application-owned behavior
and meaningful integration evidence. This is a requirement TICKET, not a single-PR implementation assignment.

Package adoption and certification retirement are one requirement because current receipts, validators, and
lanes hard-code the old candidate. Do not invent transitional recertification to separate them.

## Scope

- In scope: exact compatible release selection; Composer constraints/lock; removal of candidate aliases and
  candidate-warning exceptions; public contract inventory for transactions, principals, permissions, messages,
  handlers, and safe Views; application composition compatibility; retirement of receipts, receipt/hash
  validators, lowest/latest certification locks/lanes, provider-resolution inventories, and certification-only
  or structural/meta-tests; accurate current instructions and dependency documentation.
- Preserve Laravel/Eloquent/Pint, `app/`, the homepage, genuine application integration contracts, inward
  dependencies, and exact owned-production coverage. Classify tests by the behavior they prove, not filenames.
- Out of scope: upstream source changes or publication, Common 2.0, new business endpoints, authentication
  journeys, replacement certification tooling, or waiting indefinitely for unreleased AccessControl 0.5.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Select and install a compatible release baseline | N/A: dependency maintenance, not a business command | Inspect published and installed public APIs; no application query introduced | N/A: no business fact created | Reproducible application lock and compatible composition |
| Retire upstream certification | N/A: repository maintenance | N/A: no runtime lookup | N/A: no runtime event | Remove certification machinery without relocating it or losing owned behavior |
| Continue existing application behavior | Existing owned interactions only | Preserve existing homepage behavior | Preserve any actually required existing effects | Application remains usable with the selected packages |

## Validation and permissions

Verify actual installable releases and installed signatures; a source branch or planned release is not release
availability. Evaluate AccessControl 0.5 if published and compatible, otherwise a qualifying 0.4 release is valid.
Do not add consumer scaffolding around the retiring `UnitOfWork`, `RoleAdministrationAuthorization`, or
`AgentPermissionAdministrationAuthorization` contracts. If a required replacement is not publicly available,
record the precise blocker rather than concealing it behind an alias.

No new business permission, command, query, or event is introduced by maintenance. Security concerns here are
package provenance, credentials kept out of logs/artifacts, and preserving fail-closed owned behavior. Public
API behavior must not change accidentally as a side effect of dependency adoption.

## Acceptance and evidence

- [x] Exact mutually compatible Common 1.2+ / AccessControl 0.4+ releases are selected and installed; Composer
      metadata agrees with the lock, with no compatibility-only candidate alias or obsolete warning allowlist.
- [x] The actual public transaction, principal/permission, and representative message/handler/View contracts
      are documented for downstream requirements, including removed contracts and any remaining uncertainty.
- [x] Support receipts, validators, certification locks/lanes, complete-provider probes, and upstream-only or
      meta-tests are removed, not moved to another application gate or a new certification subsystem.
- [x] Retained production composition and tests have a demonstrated application purpose. Preserve meaningful
      owned behavior; do not mask it with coverage exclusions or manufacture binding assertions for coverage.
- [x] Existing application/homepage behavior and important integration outcomes pass with exact 100% configured
      owned-production statement coverage and an explicit source denominator.
- [x] Instructions/current context describe an application consumer, distinguish historical receipts from current
      authority, and name explicit setup requirements without rewriting completed historical records.
- [x] Required local and hosted verification is recorded for the delivered TASKs. Gate changes needed to stop
      invoking removed certification checks occur with retirement; the larger gate redesign belongs to T-00007.

## Decisions and dependencies

The human maintainer approved the exact baseline below and one cohesive adoption/retirement TASK under
[EPIC-00001](../epics/00001-EPIC.md). Requirements were accepted for execution planning. TASK-00001 now records
successful installation and bounded integration. Independent review accepts implementation
`03207b90cb833d3dfe75849eb2b8be31144de1db`, including the complete planning correction and hosted evidence.
The maintainer approved the [TASK's acceptance/closeout contract](../tasks/00001-TASK.md#approved-acceptance-and-closeout-contract--2026-09-28):
`done` records that accepted candidate; a metadata-only closeout requires its own hosted proof and independent
final-delivery review before PR #10 becomes ready. Those delivery gates are pending at this checkpoint.
If implementation discovers an incompatible dependency
or missing required public contract, record the blocker and seek a decision rather than silently changing the
baseline or adding a retiring-interface shim.

### Approved release baseline

| Package | Selected release | Published source reference | Evidence |
| --- | --- | --- | --- |
| Fight Common | 1.2.0 | `a2cd615d9b5064c9c30e994655536176249cd73b` | [Packagist metadata](https://repo.packagist.org/p2/johnnickell/fight-common.json) |
| Fight AccessControl | 0.4.0 | `380b134b35c722e6416787b13f5c20c64bd05388` | [Packagist metadata](https://repo.packagist.org/p2/johnnickell/fight-access-control.json) |

At planning inspection, AccessControl 0.4.0 required Common `^1.2` and PHP `>=8.5`; Common 1.2.0 also required
PHP `>=8.5`. AccessControl 0.5 was not listed in Packagist's stable metadata. This establishes published release
availability and compatible declared package requirements, not a successful dependency solve for this application.

The immutable release sources were inspected at these bounded contracts:

- Common's [TransactionalUnitOfWork](https://github.com/johnnickell/fight-common/blob/a2cd615d9b5064c9c30e994655536176249cd73b/src/Application/Repository/TransactionalUnitOfWork.php)
  exposes `commitTransactional(callable): mixed` and `isClosed(): bool`; its
  [Laravel persistence provider](https://github.com/johnnickell/fight-common/blob/a2cd615d9b5064c9c30e994655536176249cd73b/src/Adapter/ServiceContainer/Laravel/PersistenceServiceProvider.php)
  binds that contract to `LaravelTransactionalUnitOfWork` using the Laravel database connection.
- AccessControl's [InvitePendingUserHandler](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Application/AccessControl/User/CommandHandler/InvitePendingUserHandler.php)
  now requires `TransactionalUnitOfWork`, not the retiring `UnitOfWork`. The complete released
  [source tree](https://api.github.com/repos/johnnickell/fight-access-control/git/trees/380b134b35c722e6416787b13f5c20c64bd05388?recursive=1)
  contains neither `RoleAdministrationAuthorization` nor `AgentPermissionAdministrationAuthorization`.
- [CurrentPrincipalProvider](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Application/AccessControl/Authorization/Service/CurrentPrincipalProvider.php)
  takes `AuthenticationContextProvider` and `AuthoritativePrincipalResolver`, caching authoritative resolution
  for one request. Consumers must compose a fresh instance per request.
- [SecurityContext](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Application/AccessControl/Authorization/Service/SecurityContext.php)
  accepts `AuthenticatedAuthority` and exposes permission/role checks; this does not implement the application's
  missing operation-policy boundary. `ExactPermissionResolver` is marked internal and is not a consumer port.
- [ListUsersHandler](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Application/AccessControl/User/QueryHandler/ListUsersHandler.php)
  depends on `UserRepository` and returns `ResultSet<UserView>`, not raw user entities.

These observations bound the known compatibility concerns; they are not a complete capability inventory,
installed-signature verification, permission design, or database transaction proof. The TASK must install and
verify the approved baseline and document the downstream public contracts it actually inspects.

Coordinate the public inventory with [WF-002](../wayfinder/tickets/WF-002-access-control-capability-inventory.md)
and replace its old 0.2 assumptions before downstream implementation. Supersede future obligations in
[EPIC-00003](../epics/00003-EPIC.md), migrated from PRD-00002, without erasing historical evidence. Do not create
duplicate package inventory or certification authorities.

## TASKs

<!-- planning:children -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [TASK-00001](../tasks/00001-TASK.md) | Adopt Released Fight Packages and Retire Certification | done | [T-00006](00006-TICKET.md) | — |
<!-- /planning:children -->

## Progress

[TASK-00001](../tasks/00001-TASK.md) implements the approved Common 1.2.0 / AccessControl 0.4.0 cutover and
certification retirement in the authorized current checkout/branch. Installation, bounded security/transaction
integration, unchanged homepage, exact 38/38 statement coverage, and the local canonical gate pass. The
[installed-contract handoff](../wayfinder/fight-package-baseline.md) supplies downstream signatures and explicit
limits; WF-002's full inventory remains open. All seven requirement criteria are satisfied by the single accepted
TASK: released installation, documented public contracts, certification retirement, justified composition/tests,
exact configured coverage, current consumer instructions, and separate local/hosted verification. Nothing is waived.
The current independent `accept` resolves the original missing-hosted R1; hosted run
[36378700857](https://github.com/johnnickell/project-laravel/actions/runs/36378700857) proves the accepted tree.

This TICKET is done for accepted implementation A under the TASK's approved closeout contract, not merely
because its child changed status. Final metadata-head delivery remains pending; PR #10 is not approved or merged.
Preserve all downstream dependency edges: T-00006 is now terminal, but T-00007/T-00011 still need gate-policy
reconciliation, T-00008 still needs the shared authorization journey, T-00009 still depends on unfinished T-00008,
and T-00010 still depends on unfinished T-00007/T-00008/T-00009. No downstream TASK becomes executable.
EPIC-00001 remains in progress. See [the migration mapping](../MIGRATION.md).
