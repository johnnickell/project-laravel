# AccessControl capability inventory

**Labels:** `wayfinder:research`, `area:access-control`
**Mode:** AFK
**Status:** Open
**Gate:** Installable Fight Common 1.2.0 and Fight AccessControl 0.2.0
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** —

## Question

What is the complete public Fight AccessControl `0.2.0` command, query, and service-entrypoint inventory, and
which capabilities belong to the external resource-oriented HTTP API versus workers or the scheduler?

## Must decide

- Inventory every public command, query, result, failure, event, and coordinating service without reaching
  through package contracts or copying package-owned Domain/Application source.
- Map all externally meaningful User, Role, Permission, Session, Managed Policy, and Agent administration
  operations to proposed `/api/v1/access/*` resources and HTTP methods.
- Include self-service and authorized administration operations, with explicit actor, target, preconditions,
  success result, expected conflict/not-found/forbidden cases, and emitted side effects.
- Classify internal delivery, retry, expiry, cleanup, and recovery commands as worker/scheduler entrypoints and
  explain why they are intentionally absent from public HTTP.
- Distinguish human-administered Agent provisioning and credential administration from inbound API calls made
  by Agents; the latter HMAC-authenticated transport remains deferred.
- Identify capabilities that cannot be represented safely or completely by the proposed resources so the map
  can resolve them rather than silently omit them.

## Required evidence

- A traceable capability matrix covers every discovered public command, query, and service entrypoint exactly
  once as external, operational-only, deferred, or out of scope.
- Every external capability has a proposed resource, method, route name, authorization intent, and response
  shape input for WF-003 and WF-005.
- Every internal capability has an owning worker/scheduler trigger and explicit rationale.
- A completeness check detects both unmapped package capabilities and invented HTTP operations with no
  AccessControl behavior behind them.

## Resolution boundary

This ticket settles scope and classification, not OpenAPI syntax, Laravel persistence mechanics, middleware,
transport authentication, queue topology, or frontend presentation. It remains independently takeable from
WF-001 because package capability discovery does not require the runtime topology.

## Resolution

Open. Link the completed capability matrix or record its durable conclusions here before closing this ticket.
