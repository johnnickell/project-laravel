# AccessControl capability inventory

**Labels:** `wayfinder:research`, `area:access-control`
**Mode:** AFK
**Status:** Open
**Gate:** Selected Common 1.4.0 / AccessControl 0.8.0 are installed locally under TICKET-00012/TASK-00006; complete inventory remains open
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** —

## Question

What is the complete public Fight AccessControl `0.8.0` command, query, and service-entrypoint inventory, and
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

Open. [TASK-00006](../../tasks/00006-TASK.md) upgrades the installed baseline to Common 1.4.0 / AccessControl
0.8.0. The [current bounded handoff](../fight-package-baseline-1.4-0.8.md) records retained transaction/security
integration, principal/permission and representative message/handler/View observations, plus breaking Role,
registration, recovery and Agent contract boundaries. It is not the complete matrix or approval of API routes.
Complete the current-release inventory before closing this ticket. TASK-00001's earlier 1.2.0/0.4.0 inspection
remains [historical evidence](../fight-package-baseline.md), not the current inventory input.
