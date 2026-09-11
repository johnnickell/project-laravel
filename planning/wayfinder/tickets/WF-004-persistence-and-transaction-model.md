# Persistence and transaction model

**Labels:** `wayfinder:prototype`, `area:persistence`
**Mode:** HITL
**Status:** Open
**Gate:** —
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** [WF-002](WF-002-access-control-capability-inventory.md)

## Question

How does Laravel persist and transact Fight AccessControl aggregates through Eloquent without turning Eloquent
records into Domain models or weakening security-critical consistency?

## Must decide

- Record schemas, migrations, indexes, foreign keys, uniqueness rules, and mapping boundaries for Users,
  Roles, Permissions, Sessions, Managed Policy, Agents, and security-audit records.
- Repository adapters that reconstruct package aggregates from Eloquent records and persist aggregate state
  without copying Domain/Application source or leaking framework objects across the package boundary.
- The Laravel UnitOfWork contract: transaction ownership, aggregate save ordering, event collection,
  post-commit dispatch, rollback behavior, and nested-use-case semantics.
- Optimistic and/or pessimistic locking per mutation, stale-write conflict behavior, unique constraint mapping,
  and concurrent administrator operations.
- Refresh-session storage, hashed token material, family/rotation state, expiry, revocation, reuse detection,
  cleanup, and transactional relationship to access credentials.
- Atomic security-audit behavior: which state changes and audit facts must commit together, what may occur only
  after commit, and how failed delivery is recovered without falsifying audit history.
- Disposable MySQL verification for every mapping, migration, locking, uniqueness, and concurrency behavior; no
  PostgreSQL lane or abstraction requirement.

## Required evidence

- Unit tests cover pure record-to-aggregate and aggregate-to-record mapping code exactly.
- Integration tests cover migrations, repositories, transaction rollback/commit, uniqueness, locking,
  refresh rotation and reuse, audit atomicity, and concurrent conflicts against MySQL.
- Failure injection proves no event, queue dispatch, realtime invalidation, or security mail is published before
  the owning database transaction commits.
- The design identifies and documents deliberate MySQL-specific behavior at the adapter boundary.

## Resolution boundary

This ticket settles Laravel persistence and transaction semantics. It does not redefine AccessControl
aggregates/use cases, choose HTTP schemas, configure Horizon supervisors, or design client state.

## Resolution

Open. Record the selected mapping, transaction, and concurrency model here before closing this ticket.
