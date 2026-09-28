# Installed Fight package baseline

Bounded consumer handoff for [T-00006](../tickets/00006-TICKET.md) and [TASK-00001](../tasks/00001-TASK.md),
inspected on 2026-09-27. This note supports [WF-002](tickets/WF-002-access-control-capability-inventory.md);
it is not the complete API capability matrix, a support receipt, or a new certification authority.

## Release and installation evidence

| Package | Constraint | Lock and installed version | Lock and installed source reference |
| --- | --- | --- | --- |
| `johnnickell/fight-common` | `^1.2` | `v1.2.0` | `a2cd615d9b5064c9c30e994655536176249cd73b` |
| `johnnickell/fight-access-control` | `^0.4` | `v0.4.0` | `380b134b35c722e6416787b13f5c20c64bd05388` |

The repository-owned Composer update used `--with-all-dependencies --minimal-changes`; only these two locked
packages changed. Lock and `vendor/composer/installed.json` agree. Both require PHP `>=8.5`; AccessControl
requires Common `^1.2`. Published Packagist releases replace the VCS overrides, development constraints, inline
alias, and candidate-specific warning exception. Common 2.0 and AccessControl 0.5 are not selected by these ranges.
Normal `composer install` reproduces the lock; do not use an unreviewed update as setup.

Sources: [Common metadata](https://repo.packagist.org/p2/johnnickell/fight-common.json),
[AccessControl metadata](https://repo.packagist.org/p2/johnnickell/fight-access-control.json), and the immutable
release sources linked below. The installed `vendor/johnnickell/` contracts were read directly after installation.
Package-development requirements are not application runtime requirements.

## Retained application boundaries

| Boundary | Why retained | Evidence and limit |
| --- | --- | --- |
| HTML homepage | Existing user-facing application behavior | `tests/Feature/HomePageTest.php` performs a real GET; unchanged route, title, and greeting |
| Missing-credential rejection | Existing application-owned fail-closed rule in `FightServiceProvider` | `FightSecurityTest` rejects absent, whitespace, or non-string required credentials without returning their values; no binding-resolution inventory |
| Configured JWT/HMAC key selection and HMAC time tolerance | Existing consumer integration contract, not a new authentication journey | `FightSecurityTest` exercises successful operations and wrong-key/time-window rejection through the application's selected adapters |
| Default Laravel transaction connection | Existing integration and the current transaction contract required by AccessControl | `FightTransactionTest` proves committed state, result propagation, rollback, and exception propagation on the application's SQLite test connection; not a MySQL/concurrency claim |

The provider now registers only the Common Laravel persistence provider and the four existing security contracts.
The security tests cover application credential selection and rejection, not JWT/HMAC algorithm conformance.
No API authentication middleware or protected AccessControl operation has been introduced. In particular, this
composition does not establish token expiry/session revocation policy or persistent nonce replay prevention.
It must not be treated as a complete production authentication boundary; T-00008/T-00010 own those decisions.

Removed from the complete-platform profile: messaging routers/buses and queue demonstrations with synthetic
`ProfileCommand`/`ProfileEvent`; in-memory publication stores; private publication convention checks; file,
cache, mail, SMS, scheduler, process, HTTP, routing, and templating port inventories; upstream filesystem and
JSend demonstrations; and structural/receipt tests. No production handler or route used those Fight bindings.
Laravel's own native facilities remain available. Reintroduce a Fight capability only with a demonstrated
application use case and appropriate behavior evidence, not to restore platform completeness.

The configured production coverage denominator remains all PHP under `app/`, without new exclusions. The
current retained provider contains 38 executable statements, covered by integration/functional execution.
There is no owned Domain/Application unit suite yet; combined 100% coverage is not a unit-coverage claim.
Routes, configuration, templates, vendor, scripts, and tests remain outside that pre-existing source filter.

## Transaction contract

[TransactionalUnitOfWork](https://github.com/johnnickell/fight-common/blob/a2cd615d9b5064c9c30e994655536176249cd73b/src/Application/Repository/TransactionalUnitOfWork.php)
provides `commitTransactional(callable): mixed` and `isClosed(): bool`.
The [Laravel adapter](https://github.com/johnnickell/fight-common/blob/a2cd615d9b5064c9c30e994655536176249cd73b/src/Adapter/Persistence/Laravel/LaravelTransactionalUnitOfWork.php)
uses its injected Laravel `Connection`, propagates callback results/exceptions, and rejects an already-open
transaction with `LogicException` rather than promising nested transactions. The package's persistence provider
selects `db.connection`. Repositories for a future atomic use case must use that same connection.

Common still ships its legacy `UnitOfWork`; this application does not bind or alias it. Installed AccessControl
handlers now declare `TransactionalUnitOfWork`. Database schemas, locking/concurrency, principal-state freshness,
and durable-effect recovery still belong to T-00009/WF-004/WF-006. Do not wrap a transaction-owning handler in
another transaction without reconciling the adapter's nesting prohibition.

## Principal and permission contracts

- [AuthenticationContext](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Application/AccessControl/Authorization/Service/AuthenticationContext.php)
  takes `UserId`, `RefreshSessionId`, and a positive authentication-version integer, not a list of trusted
  client-supplied permissions. `AuthenticationContextProvider::getAuthenticationContext()` is the consumer port.
- [CurrentPrincipalProvider](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Application/AccessControl/Authorization/Service/CurrentPrincipalProvider.php)
  takes that provider and `AuthoritativePrincipalResolver`; `getCurrentPrincipal()` returns an
  `AuthenticatedUserPrincipal` cached for one request. Never bind this principal lifetime as a cross-request
  singleton in a long-running worker.
- The resolver's constructor requires user, refresh-session, role, and permission repositories plus `Clock`.
  It checks current identities, active user/session/version, roles, and permission definitions. Both
  `AuthoritativePrincipalResolver` and `ExactPermissionResolver` are marked `@internal`: their method bodies are
  not consumer policy ports to copy, override, or dispatch directly. Future composition must honor the public
  principal-provider constructor while leaving resolution behavior package-owned.
- [SecurityContext](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Application/AccessControl/Authorization/Service/SecurityContext.php)
  takes `AuthenticatedAuthority` and exposes `hasPermission(PermissionName): bool`, `hasRole(RoleName): bool`,
  and the selected authority. This snapshot does not define application operation/target policies by itself.
- Neither `RoleAdministrationAuthorization` nor `AgentPermissionAdministrationAuthorization` exists in the
  installed AccessControl release. Do not recreate them. T-00008 must define shared fail-closed application
  authorization for commands and queries, including non-HTTP execution, using the supported principal boundary.

No principal-provider binding, transport context, permission matrix, or repository implementation is claimed here.

## Representative messages, handlers, and safe results

These signatures inform downstream selection; they do not choose the real read/write journey or expose routes.

| Contract | Installed shape | Ownership/effect |
| --- | --- | --- |
| Common `CommandBus` | `execute(Command): void`; `dispatch(CommandMessage): void` | Preserve package messages; no application alias |
| Common `QueryBus` | `fetch(Query): mixed`; `dispatch(QueryMessage): mixed` | Result type comes from the selected use case |
| AccessControl `InvitePendingUser` | Constructor: actor string, `UserId`, `EmailAddress` | Intent; actor input is not permission proof |
| `InvitePendingUserHandler` | User, activation-grant, and audit repositories; `TransactionalUnitOfWork`; credential generator; delivery cipher; clock; event dispatcher | Atomically records pending identity, invitation/delivery intent, and audit evidence; triggers `UserInvited` after commit. On failure triggers `CommandFailedEvent` then rethrows. This is source inspection, not this application's durable-delivery proof |
| AccessControl `ListUsers` | Constructor: `Pagination`; serialized page, per-page, orderings | Read-only query |
| `ListUsersHandler` | Constructor: `UserRepository`; `handle(QueryMessage): ResultSet` documented as `ResultSet<UserView>` | Maps repository results to safe Views; does not supply the application's missing query permission gate |
| `UserView` | User ID, email, state, role IDs, created/updated timestamps; safe getters and `toArray()` | No password hash, credential, or authentication-version field. Responders must still choose the authorized transport representation |

Immutable references:
[command](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Domain/AccessControl/User/Command/InvitePendingUser.php),
[command handler](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Application/AccessControl/User/CommandHandler/InvitePendingUserHandler.php),
[query](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Domain/AccessControl/User/Query/ListUsers.php),
[query handler](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Application/AccessControl/User/QueryHandler/ListUsersHandler.php),
[View](https://github.com/johnnickell/fight-access-control/blob/380b134b35c722e6416787b13f5c20c64bd05388/src/Domain/AccessControl/User/Query/UserView.php).

## Remaining authority

WF-002 stays Open until the complete capability matrix exists. T-00008/T-00009/T-00010 still need their shared
real journey, trusted principal source, permission/target rules, authoritative persistence, and safe transport
failures. Package facts do not settle those application decisions. T-00007 still owns the running-stack build
redesign; this cutover only replaces obsolete Composer validation and removes certification lane invocation.
Local gate results, warnings, hosted limitations, and independent-review state belong in TASK-00001.
