# Realtime invalidation

**Labels:** `wayfinder:grilling`, `area:realtime`, `area:security`
**Mode:** HITL
**Status:** Open
**Gate:** Symfony realtime contract
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** [WF-001](WF-001-development-runtime-topology.md), [WF-005](WF-005-http-and-security-conventions.md), [WF-006](WF-006-queues-scheduling-and-mail.md)

## Question

How does Mercure securely notify authorized browsers of committed AccessControl changes while keeping HTTP
refetch authoritative and remaining correct across reconnects and credential renewal?

## Must decide

- Private topic taxonomy and names for self-service state and authorized administrative scopes, including
  subscription cardinality and tenant-independent information-leak boundaries.
- Server-side subscription authorization, JWT/refresh interaction, CSRF/Origin behavior, authorization revocation,
  and protection of Horizon/Mercure operational endpoints.
- Minimal invalidation event schemas, stable event names/versioning, affected-resource identifiers, correlation
  metadata, and explicit exclusion of authoritative sensitive state from broadcast payloads.
- Post-commit publication and retry semantics, ordering and duplicate tolerance, and the relationship to the
  queue/outbox decisions in WF-004 and WF-006.
- Client reconnect, missed-event, credential-expiry/renewal, subscription replacement, backoff, and offline
  behavior; every signal leads to an authoritative HTTP refetch rather than direct local mutation.
- Mercure hub/JWT composition and local proof without prematurely deciding production topology.

## Required evidence

- Authorization tests prove a user can subscribe only to permitted private channels and loses access after
  relevant revocation or policy change.
- Transaction tests prove rolled-back mutations never broadcast and committed events contain only the approved
  invalidation data.
- A two-browser journey proves an authorized mutation in one browser invalidates and refetches state in the
  other without treating the SSE event as source of truth.
- Reconnect journeys cover missed events, duplicate messages, expired credentials, single renewal, resubscribe,
  and authoritative reconciliation.

## References

- [Mercure](https://mercure.rocks/docs/mercure)

## Resolution boundary

This ticket settles Mercure private-topic authorization and invalidation semantics. It does not carry full resource
state over realtime, replace HTTP consistency, define production hub deployment, or add inbound Agent HMAC.

## Resolution

Open. Record the channel, event, authorization, and reconnect contracts here before closing this ticket.
