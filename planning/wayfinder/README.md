# Wayfinder Maps

Wayfinder maps chart an uncertain feature before it becomes an epic, PRD, or implementation ticket. A map is an
index of linked decision tickets, not a second source of decisions. Start with an active map's **Frontier**; when
none is available, offer to chart a new feature.

## Active maps

| Map | Destination | Frontier | State |
|---|---|---|---|
| [Complete Laravel AccessControl API and SPA](complete-access-control-api-and-spa-map.md) | Implementation-ready runtime, complete AccessControl HTTP API, and reusable React SPA capability spine | [WF-001 — Development runtime topology](tickets/WF-001-development-runtime-topology.md) | Active |

WF-002 is also independently unblocked for capability inventory work; WF-001 remains the explicit first
frontier because this map is sequenced environment-first.

Use `_MAP_TEMPLATE.md` and `tickets/_WAYFINDER_TICKET_TEMPLATE.md` for new work. `research/` holds linked
evidence, never a parallel decision record. Archive only through `../../bin/archive-planning` after a map is Closed,
its decisions are Closed, its frontier is empty, and its implementation handoff is linked.
