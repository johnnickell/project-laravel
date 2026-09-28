# Wayfinder Map: Complete Laravel AccessControl API and SPA

**Label:** `wayfinder:map`
**Status:** Active

> This map is an **index, not a store**. Each material decision lives in exactly one linked ticket under
> `tickets/`; this map only summarizes the linked resolutions and shows the next decision frontier.

## Destination

Produce an implementation-ready capability spine for the Laravel-owned development environment, complete
Fight AccessControl HTTP API, and reusable React SPA. The handoff must preserve Fight Common and Fight
AccessControl Domain/Application ownership while making Laravel's framework, delivery, persistence, HTTP,
OpenAPI, security,
presentation, and operational responsibilities explicit.

**Done** = every linked decision ticket is closed; the runtime, capability inventory, upstream contract,
persistence, HTTP/security, asynchronous delivery, realtime, and SPA adoption decisions are internally
consistent; the remaining fog is resolved or excluded; and the approved handoff links to its resulting EPIC,
requirements TICKETs, and subsequent bounded TASK handoff.

## Notes

- The approved [foundation epic](../epics/00001-EPIC.md) and
  [T-00006](../tickets/00006-TICKET.md) supersede the old package-baseline assumptions below with approved
  Common 1.2.0 / AccessControl 0.4.0. Both are installed; the
  [bounded contract handoff](fight-package-baseline.md) records local integration and its limits. Full capability,
  persistence, and security decisions remain pending; reconcile them before dependent implementation.
  The EPIC → TICKET → TASK lifecycle changes handoff terminology, not this map's unresolved technical decisions.
- This is a planning-only map. It does not authorize production-code changes, dependency publication, release,
  deployment, or copying package-owned source.
- The selected package baseline is Common `1.2.0` / AccessControl `0.4.0`; WF-002's complete inventory is open.
- The original OpenAPI plan assumed AccessControl `0.2.0` scan-only reusable component schemas. WF-003 must
  verify the selected 0.4.0 catalog before retaining that handshake. Laravel owns paths, operations,
  operation IDs, security schemes, status codes, framework errors, servers, tags, the generator command, the one
  checked-in OpenAPI 3.1 document, Swagger UI, and drift checks.
- A Laravel-owned Artisan generator scans the installed package `resources/openapi/` carriers and Laravel Actions,
  request/response DTOs, routes, security declarations, and project components in one pass. It never merges specs.
- Laravel owns providers, container composition, routing, middleware, invokable HTTP handlers, persistence,
  queues, realtime, presentation, and local operations. Fight Common and Fight AccessControl remain Composer
  packages and retain their Domain/Application source.
- The Symfony client establishes the reusable frontend baseline. Laravel backend decisions may proceed while
  that external dependency remains visible.
- Exact production-code coverage is required. Tooling, wrapper, configuration, CI, and Markdown meta-tests are
  excluded; those artifacts are verified through their owning commands and direct inspection.

## Decisions so far

1. **[Development runtime topology](tickets/WF-001-development-runtime-topology.md) is open.** Fix the complete,
   worktree-safe Compose and wrapper contract before executable TASKs are produced.
2. **[AccessControl capability inventory](tickets/WF-002-access-control-capability-inventory.md) is open.** Map
   every package command, query, and service entrypoint to an external HTTP operation or an intentionally
   operational-only entrypoint.
3. **[OpenAPI and release handshake](tickets/WF-003-openapi-and-release-handshake.md) is open.** Define the
   selected-release shared-component handshake, Laravel-owned one-pass OpenAPI generation, and Symfony wire compatibility.
4. **[Persistence and transaction model](tickets/WF-004-persistence-and-transaction-model.md) is open.** Define
   Eloquent record mapping, UnitOfWork, migrations, concurrency, refresh sessions, and atomic audit behavior.
5. **[HTTP and security conventions](tickets/WF-005-http-and-security-conventions.md) is open.** Settle JWT,
   middleware, validation, authorization, routes, paired Action/Responder handlers, and error mapping.
6. **[Queues, scheduling, and mail](tickets/WF-006-queues-scheduling-and-mail.md) is open.** Define Redis/Horizon,
   retry and failure policy, scheduled recovery, security email, and Mailpit behavior.
7. **[Realtime invalidation](tickets/WF-007-realtime-invalidation.md) is open.** Define private Mercure topics,
   post-commit publication, reconnect and renewal behavior, and authoritative HTTP refetch.
8. **[Portable React SPA](tickets/WF-008-portable-react-spa.md) is open.** Define the Symfony-led portable client
   architecture and exact Laravel adoption contract for all self-service and administrative journeys.
9. **[Capability-spine approval and handoff](tickets/WF-009-capability-spine-handoff.md) is open.** Reconcile the
   decisions and obtain human approval before creating the EPIC, requirements TICKETs, and subsequent TASKs.

## Tickets

| Ticket | Type | Mode | Status | Depends On | Gate |
|---|---|---|---|---|---|
| [WF-001 — Development runtime topology](tickets/WF-001-development-runtime-topology.md) | Grilling | HITL | **Open** | — | — |
| [WF-002 — AccessControl capability inventory](tickets/WF-002-access-control-capability-inventory.md) | Research | AFK | **Open** | — | Common 1.2.0 / AccessControl 0.4.0 installed; complete inventory pending |
| [WF-003 — OpenAPI and release handshake](tickets/WF-003-openapi-and-release-handshake.md) | Grilling | HITL | **Open** | WF-002 | Symfony canonical wire contract |
| [WF-004 — Persistence and transaction model](tickets/WF-004-persistence-and-transaction-model.md) | Prototype | HITL | **Open** | WF-002 | — |
| [WF-005 — HTTP and security conventions](tickets/WF-005-http-and-security-conventions.md) | Grilling | HITL | **Open** | WF-002, WF-003, WF-004 | Symfony authentication contract |
| [WF-006 — Queues, scheduling, and mail](tickets/WF-006-queues-scheduling-and-mail.md) | Grilling | HITL | **Open** | WF-001, WF-004, WF-005 | — |
| [WF-007 — Realtime invalidation](tickets/WF-007-realtime-invalidation.md) | Grilling | HITL | **Open** | WF-001, WF-005, WF-006 | Symfony realtime contract |
| [WF-008 — Portable React SPA](tickets/WF-008-portable-react-spa.md) | Prototype | HITL | **Open** | WF-003, WF-005, WF-007 | Immutable accepted Symfony client reference |
| [WF-009 — Capability-spine approval and handoff](tickets/WF-009-capability-spine-handoff.md) | Grilling | HITL | **Open** | WF-001 through WF-008 | Human approval of the handoff |

## Blocking relationships

```text
WF-001 ───────────────────────────────┬──→ WF-006 ──→ WF-007 ──┐
                                      │                         │
WF-002 ──→ WF-003 ────────────────────┼────────────────────────→ WF-008 ──┐
    └────→ WF-004 ──→ WF-005 ─────────┴──→ WF-006 ──→ WF-007 ──┘          │
                                                                           ├──→ WF-009 ──→ EPIC / TICKETs / TASKs
Symfony wire/realtime/client gates ────────────────────────────→ WF-003/WF-005/WF-007/WF-008
```

WF-001 remains first because the requested sequence is environment-first. WF-002's package-availability gate is
now satisfied for the selected baseline; its complete inventory is independently researchable, not an approved
implementation TASK.

## Frontier

[WF-001 — Development runtime topology](tickets/WF-001-development-runtime-topology.md) is the first grillable
decision.

## Not yet specified (fog)

- Exact AccessControl `0.4.0` component manifest and compatibility with the original OpenAPI plan.
- Exact Symfony client baseline reference and its generated-contract/adoption artifacts.
- Final route matrix, schemas, record shapes, channel names, queue names, retry budgets, and supervisor sizing;
  the linked decision tickets must settle these before implementation TASK generation.
- Production authorization policies for Horizon and Swagger UI; both remain local-only by default and fail closed
  outside development.

## Out of scope

- Production deployment topology and literal production cron configuration.
- MCP transport and inbound HMAC-authenticated requests made by Agents.
- Multi-tenancy, Fight Common 2.0, release publication, and template enablement.
- Implementing the same capability spine in other framework starters.
- Copying Fight Common, Fight AccessControl, Symfony Domain/Application, or private reference implementation
  source into Laravel.
