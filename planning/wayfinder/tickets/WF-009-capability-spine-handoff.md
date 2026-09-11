# Capability-spine approval and handoff

**Labels:** `wayfinder:grilling`, `area:planning`
**Mode:** HITL
**Status:** Open
**Gate:** Human approval of the handoff
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** [WF-001](WF-001-development-runtime-topology.md), [WF-002](WF-002-access-control-capability-inventory.md), [WF-003](WF-003-openapi-and-release-handshake.md), [WF-004](WF-004-persistence-and-transaction-model.md), [WF-005](WF-005-http-and-security-conventions.md), [WF-006](WF-006-queues-scheduling-and-mail.md), [WF-007](WF-007-realtime-invalidation.md), [WF-008](WF-008-portable-react-spa.md)

## Question

Do the eight resolved decisions form a complete, coherent, implementation-ready Laravel capability spine that
can be approved and handed to `/to-spec`, `/to-tickets`, and vertical-slice delivery?

## Must decide

- Reconcile route/schema, persistence/transaction, auth/security, queue/scheduler/mail, realtime, runtime, and
  SPA decisions; resolve contradictions rather than passing them into implementation.
- Confirm every WF-002 external capability is represented in OpenAPI, Laravel HTTP composition, persistence,
  authorization, frontend UX, verification, and an owning future slice.
- Confirm every operational-only capability has a worker/scheduler owner and every deferred or excluded
  capability is visible with rationale.
- Approve an epic destination, coherent PRD boundaries, and independently verifiable vertical slices with
  dependency edges, acceptance criteria, rollback/failure boundaries, and explicit exclusions.
- Sequence the handoff environment-first while preserving parallel work where dependencies allow it; WF-002's
  independent start must remain visible.
- Require installable Fight Common `1.2.0`, Fight AccessControl `0.2.0`, and the accepted
  Symfony client baseline as external readiness gates rather than silently embedding their work in Laravel.
- Define the implementation gate: exact production-code coverage; meaningful Unit, Integration, Functional,
  security, concurrency, and browser evidence; `./bin/planning-check`; and a detached repository-owned
  `./bin/build` whose exit artifact contains `0` before any later commit or PR.

## Required evidence

- A traceability review has no orphan capability, OpenAPI operation, route, persistence responsibility, async
  effect, realtime signal, UI journey, or implementation slice.
- The future tickets cover Compose health and lifecycle; MySQL migration and concurrency;
  JSend/HTTP failures; JWT, refresh, CSRF/Origin, dashboards, and private channels; Horizon, recovery, Mailpit,
  Mercure two-browser/reconnect; frontend quality and deterministic assets.
- The handoff requires one valid checked-in Laravel-generated OpenAPI document and rendered local Swagger UI,
  normalized Symfony parity, generated-client compilation, unauthorized operation/subscription rejection, refresh
  rotation/reuse, invitation-led bootstrap, queue retry/outbox, scheduler overlap, recovery, and `./bin/build`.
- No proposed automated test exists merely to inspect wrappers, tooling, configuration, CI, or Markdown.
- Human approval is explicit before the map is closed or implementation planning is generated.

## Resolution boundary

This ticket may approve and create the linked epic, PRDs, and executable T-tickets, then close the map with an
empty frontier. It does not authorize implementation, dependency publication, commits, pull requests,
deployment, template enablement, archive operations, or cleanup.

## Resolution

Open. After approval, link the resulting epic, PRDs, and implementation tickets here and from the map before
closing either record.
