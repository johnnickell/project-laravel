# Current Fight consumer baseline — Common 1.4.0 / AccessControl 0.8.0

Bounded installed-contract handoff for [TICKET-00012](../tickets/00012-TICKET.md) /
[TASK-00006](../tasks/00006-TASK.md), inspected on 2026-10-24. This supersedes the
[1.2.0/0.4.0 handoff](fight-package-baseline.md) for current development without rewriting its historical evidence.
It supports open [WF-002](tickets/WF-002-access-control-capability-inventory.md); it is not a full capability matrix,
consumer certification or production authentication claim.

## Release and installation

| Package | Constraint | Lock and installed version | Source reference |
| --- | --- | --- | --- |
| `johnnickell/fight-common` | `^1.4` | `v1.4.0` | `87b9580c072f3149d574e09865daa79620c92118` |
| `johnnickell/fight-access-control` | `^0.8` | `v0.8.0` | `319738255e682d587642b67856039f882b9588d6` |

[Common](https://repo.packagist.org/p2/johnnickell/fight-common.json) and
[AccessControl](https://repo.packagist.org/p2/johnnickell/fight-access-control.json) stable metadata supplied this
selection. Both require PHP >=8.5; AccessControl requires Common ^1.3. `composer.lock` and
`vendor/composer/installed.json` agree. The repository-owned update with `--with-all-dependencies --minimal-changes`
changed only these two package records: no additions/removals or unrelated locked-version changes. Laravel remains
13.31.0. Normal setup installs the lock; it does not update dependencies.

AccessControl's versioned overview retains its release-preparation checkpoint language. That historical prose
is not current publication authority: registry metadata and the successful dist installation establish this
consumer's selected release. They do not establish upstream signing or this application's full integration.

## Retained integration and compatibility

Production remains the single Laravel `app/Providers/FightServiceProvider.php`, registering the package Laravel
transaction provider and four configured JWT/HMAC capabilities. No AccessControl handler, principal provider,
repository, schema, worker, protected route, MCP endpoint or OpenAPI document is composed here.

- Common's `TransactionalUnitOfWork`, Laravel transaction adapter/provider, HMAC request signer/helper, and
  command/query bus contracts are byte-unchanged from 1.2.0. The HMAC authenticator and JWT encoder/decoder differ
  only in PHPDoc formatting. No local adapter or test rewrite is necessary for these integrations.
- `TransactionalUnitOfWork::commitTransactional(callable): mixed` and `isClosed(): bool` remain the public
  contract. The Laravel adapter uses the selected `db.connection`, propagates results/exceptions and rejects
  nested transactional execution. Future repositories must share that connection; wrapping a transaction-owning
  package handler in another transaction is not supported.
- JWT decoding verifies the configured signature; it is not session revocation or complete temporal-policy
  enforcement. HMAC has no configured persistent nonce repository here. Missing credentials remain fail-closed.
  No new authentication, replay prevention or authorization guarantee follows from installing newer packages.
- The existing homepage/security/transaction tests prove real owned outcomes on the SQLite test connection.
  Keep all `app/` in the existing coverage denominator. Their combined coverage is not a unit-only result,
  MySQL concurrency proof or durable-delivery evidence. Actual results belong to TASK-00006.

Immutable sources: [transaction contract](https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/src/Application/Repository/TransactionalUnitOfWork.php),
[Laravel adapter](https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/src/Adapter/Persistence/Laravel/LaravelTransactionalUnitOfWork.php),
[Laravel provider](https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/src/Adapter/ServiceContainer/Laravel/PersistenceServiceProvider.php).

## Relevant migration findings

The installed Common 1.3/1.4 and AccessControl 0.5–0.8 changelog sections and current Role/recovery composition
guides were inspected. New capability availability is not authorization to expose it.

| Change | Laravel disposition and downstream obligation |
| --- | --- |
| Common 1.4 StreamId equality/hash/JSON change | No owned StreamId use or persisted event streams exist. No migration needed for this application; future adopters must use current identity/serialization semantics. Do not assume every minor-release change is behavior-preserving. |
| Common 1.4 strict Pagination, immutable JSON snapshots, values and safe HTTP errors | Additive/opt-in except the documented legacy-constructor deprecation. No existing owned caller needs migration. Select safe error presentation during real API design; do not install an unused handler or restore legacy error exposure. |
| Common 1.3 MCP and OAuth boundaries | No local consumers. No automatic endpoint, identity, permission or disclosure policy is supplied or enabled. |
| AccessControl 0.5 Agent/Feature/delivery and repository changes | No local Agent/grant/Feature storage or adapters exist to migrate. WF-002 must inventory the current API; TICKET-00008/TICKET-00009 must honor current operation/cohort, reference-fence and complete-state contracts, not recreate old compatibility paths. |
| AccessControl 0.6 retry Clock dependency | `RetryInvitationDeliveryHandler` requires Clock before the dispatcher. No existing local binding; future worker composition must use the installed signature. |
| AccessControl 0.7 registration/origin contracts | Activation origin, delivery invocation, pending-registration replacement and initial Role assignment now have explicit contracts. No local stored grants or registration flow exists. Future persistence must retain origin and shared transaction-duration fences. |
| AccessControl 0.8 Role revisions | Role Views require `RoleRevision`; rename/remove require displayed `expectedRevision`. Persist incarnation/sequence and implement non-writing `RoleRepository::validateCurrent(Role): bool`; stale intent must not silently adopt a fresh token. No local Role API or schema currently requires migration. |
| AccessControl 0.8 recovery and notifications | Persist immutable RecoveryAuthority; implement `UserRepository::validateRecoveryAuthority(User): bool`; reset workers and disable/delete handlers require updated repositories. Constant failure notifications preserve the original throwable, but consumers still sanitize responses/logs. No current local bindings or data need conversion. |

Sources: [Common changes](https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/CHANGELOG.md),
[AccessControl changes](https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/CHANGELOG.md),
[Role revision composition](https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/docs/role-revisions.md),
[operation/recovery composition](https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/docs/operation-outcomes.md).

## Current representative public contracts

- `AuthenticationContext(UserId, RefreshSessionId, int authenticationVersion)`, `CurrentPrincipalProvider` and
  `SecurityContext` are unchanged from the prior baseline. Compose a fresh current-principal provider per request
  or job; its cached resolution must not leak into subsequent work. The resolver remains package-owned.
- `InvitePendingUserHandler` retains its eight constructor dependencies, including `TransactionalUnitOfWork`.
  It now issues an explicit `ActivationOrigin::PRIVATE_INVITATION` and sends best-effort constant failure
  notifications without replacing the primary throwable. Its repositories must implement the current broader
  public interfaces. No application invitation/delivery behavior is exercised by this upgrade.
- `ListUsersHandler(UserRepository)` and its `ResultSet<UserView>` output remain unchanged. Safe UserView
  fields do not include credentials. The query still needs the application's future authorization boundary.
- Common `CommandBus::execute(Command): void` / `dispatch(CommandMessage): void` and
  `QueryBus::fetch(Query): mixed` / `dispatch(QueryMessage): mixed` remain available. No current application bus
  registration is required; future use must dispatch package messages without aliases or handler bypasses.

Sources: [principal provider](https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/src/Application/AccessControl/Authorization/Service/CurrentPrincipalProvider.php),
[invitation handler](https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/src/Application/AccessControl/User/CommandHandler/InvitePendingUserHandler.php),
[list handler](https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/src/Application/AccessControl/User/QueryHandler/ListUsersHandler.php).

## Remaining decisions and risks

WF-002's full inventory, WF-003's OpenAPI/wire handshake and TICKET-00008/TICKET-00009/TICKET-00010's actual journey remain open.
Package versions do not settle authorization, schemas, locking, retry, recovery or API compatibility. No data reset,
consumer certification, upstream modification or full-provider inventory is introduced.

The explicit update/audit reported three advisories in unchanged `league/commonmark` 2.10.1 and
`symfony/http-foundation` 8.1.6: `GHSA-97jj-33gv-5xf9`, `GHSA-3q6v-r5mr-hxv8`, and `CVE-2026-108082`.
They are not introduced or fixed by the Fight upgrade. The maintainer must separately scope their remediation;
this note does not assert non-exploitability. Audit remains dependency-maintenance evidence, not a newly installed
product-suite test or a replacement for the canonical gate.
