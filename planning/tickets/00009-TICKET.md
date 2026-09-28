---
id: T-00009
epic: EPIC-00001
title: Persist Authoritative AccessControl State and Required Effects
status: needs-info
blocked_by: T-00006, T-00008
---

# Persist Authoritative AccessControl State and Required Effects

## Problem and outcome

Authorization and package use cases need authoritative persisted state and explicit transaction guarantees,
not only in-memory principals or a demonstration that a service resolves. Provide bounded Laravel/Eloquent
integration for the foundation journey selected with T-00008 and T-00010.

## Scope

- In scope: necessary Eloquent records, migrations, mappings, and public repository implementations; identity,
  permission, target, and revocation state required by the chosen journey; current transaction capability on
  one connection; applicable uniqueness/concurrency guarantees; atomic required audit/durable intent;
  post-commit effects and recovery; direct MySQL-backed evidence.
- Out of scope: exhaustive aggregate persistence, PostgreSQL/Doctrine, framework objects in Domain, retired
  UnitOfWork scaffolding, a generic replacement for package-owned delivery behavior, full Horizon/Mercure
  topology, or exactly-once external delivery claims.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Read current permission/identity/target authority | N/A for a pure read | Supported package contracts selected under T-00006/T-00008 | N/A: reads do not create business facts | Current persisted authority controls the result |
| Execute the selected authorized mutation | Actual selected package command | Only required authoritative lookups | Preserve the package-owned facts | State, required audit, and required delivery intent commit atomically |
| Reject invalid, conflicting, or failed changes | Same real command failure paths | Required lookups only | No success event for rolled-back state | No partial committed business state or pre-commit external publication |
| Recover required external work after interruption | Existing package recovery command/capability where available | Due durable work only | Actual delivery facts, not renamed events | Retry resumes durable work under explicit idempotency guarantees |

## Validation and permissions

Persist and reconstruct package aggregates through public contracts. Eloquent records do not become Domain
entities. Preserve package validation and intrinsic invariants; map database conflicts through approved safe
application contracts instead of leaking SQL or bypassing policy.

Permission/revocation lookups must reflect the freshness contract selected by T-00008. Failed authorization must
not produce protected state/effects. Audit attribution uses trusted actor context. Never store or log secret
material merely to simplify evidence. State-dependent authorization and mutation must compose safely with the
selected locking/transaction strategy; a preflight permission check alone does not settle race behavior.

## Acceptance and evidence

- [ ] The exact records/mappings and repository capabilities needed by the approved journey are specified and
      exercised against MySQL, without copying package Domain/Application source or inventing unused adapters.
- [ ] The selected public transaction capability and repositories participate on one connection; commit,
      rollback, nesting behavior, relevant uniqueness, stale-write, and concurrency outcomes are explicit.
- [ ] Real persistence tests prove current, revoked, and invalid authority outcomes required by T-00008.
      Tests do not infer authoritative behavior from a cached token claim or an in-memory stub alone.
- [ ] Required state, audit evidence, and delivery intent are atomic. Failure evidence proves no required
      partial write and no external effect before commit.
- [ ] Where the selected journey requires delivery, interruption/retry tests prove durable recovery and the
      agreed idempotency behavior. After-commit dispatch alone is not presented as crash-safe intent.
- [ ] If a selected read or mutation has no event/external effect, record that explicitly; do not invent an
      outbox or event solely to satisfy an architectural diagram or coverage percentage.
- [ ] Child TASK evidence includes meaningful unit/integration tests, exact owned-production coverage, and
      the canonical application gate, not a reinstated package certification lane.

## Decisions and dependencies

Depends on [T-00006](00006-TICKET.md) and [T-00008](00008-TICKET.md). Coordinate
[WF-004](../wayfinder/tickets/WF-004-persistence-and-transaction-model.md) and
[WF-006](../wayfinder/tickets/WF-006-queues-scheduling-and-mail.md); runtime setup must support the required
MySQL evidence without implicitly approving the whole expanded stack.

Before TASK decomposition, settle the shared representative journey, exact schemas/public repositories,
transaction/nesting and locking rules, audit requirements, required effect/recovery contracts, and non-applicable
categories. Package availability and these choices remain unresolved. T-00008 can prove pure application policy
without waiting for this implementation; this ticket supplies the actual database guarantees it cannot prove.

## TASKs

<!-- planning:children -->
None.
<!-- /planning:children -->

## Progress

Persistence requirement boundary approved. No schemas, mappings, transaction integration, durable delivery,
MySQL runtime changes, or implementation TASKs have been created.
