# Development runtime topology

**Labels:** `wayfinder:grilling`, `area:operations`
**Mode:** HITL
**Status:** Open
**Gate:** Agent OS ingress integration contract and pending shared database/cache/test-isolation decisions
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** —

## Question

What exact Laravel-owned local runtime and wrapper contract makes the full AccessControl API and SPA
repeatable, observable, healthy, and isolated across ordinary checkouts and linked worktrees?

## Must decide

- The Compose topology for Nginx, PHP-FPM, MySQL, Redis, Mercure, Horizon-managed PHP-CLI workers,
  Cron-triggered `artisan schedule:run`, and Mailpit, including startup ordering and failure propagation.
- Compose-native health checks and dependency readiness for every service, plus application, Mercure, and
  development-tool routing through Laravel Nginx and Agent OS shared HTTPS ingress; no private-service host ports.
- Named-volume versus bind-mount ownership, database and Redis persistence defaults, container users,
  permissions, cache paths under `var/cache/`, and deterministic `public/dist/` availability.
- The `.env.example` contract for database, Redis, queues, cache, mail, Mercure, JWT, frontend, and local
  dashboard/spec URLs, including safe local defaults and explicit required secrets.
- Thin Compose-backed `./bin/up` and `./bin/down` lifecycle semantics, log and exit behavior, and cleanup limited
  to owned resources. Consume upstream project/resource identity rules once settled rather than designing them here.
- MySQL as the only relational database in this starter family; no PostgreSQL runtime or certification lane.
- Local-only access defaults for Horizon and Swagger UI, with fail-closed non-local behavior until separate
  authorization policy exists.

## Required evidence

- Rendered Compose configuration names every service, network, port, dependency, health check, and volume.
- A documented clean-start, health, log, and shutdown journey covers each service and distinguishes Laravel-owned
  resources from shared services; `./bin/down` does not stop or remove upstream-owned resources.
- Once the upstream isolation contract is settled, two concurrent worktrees demonstrate non-conflicting identities,
  hostnames, and test data boundaries without publishing private-service host ports.
- MySQL is the application database; Redis backs cache, queues, Horizon, and scheduler locks; `artisan horizon`
  runs in a PHP-CLI worker, Cron invokes `artisan schedule:run`, and Mercure runs as the shared private SSE hub.

## References

- [Laravel scheduling](https://laravel.com/framework/docs/13.x/scheduling)

## Resolution boundary

This ticket settles the local developer topology, configuration surface, isolation rules, and wrapper behavior.
It does not design production deployment, literal production cron, application persistence mappings, queue job
semantics, API routes, or SPA behavior.

## Resolution

Open. The following interview decisions are accepted planning constraints, not implemented or verified runtime behavior.

### Accepted: full stack and shared ingress

Normal startup provides the full development stack, not optional profiles for mail, realtime, workers, or scheduling.
This does not decide whether database/cache services are project-owned or supplied by shared upstream infrastructure.

Consume Agent OS's installation-owned shared `nginx-proxy` ingress rather than adding another public proxy or
allocating Laravel host ports. Only Laravel's Nginx entrypoint joins the external ingress network and the
project-private network. PHP-FPM, MySQL, Redis, Mercure, Horizon workers, Cron, and Mailpit remain private with
no published host ports. Browser-facing development tools must route through Laravel's Nginx; their exact routes
and access controls are still pending. Private networking alone is not browser authorization.

The upstream contract selects canonical HTTPS on shared ports 80/443, default `<name>.localhost` names, and
operator-approved custom domains. DNS/hosts changes, certificate generation and trust are explicit upstream
host-side operations, not Laravel startup effects. Laravel does not own the shared proxy lifecycle or receive
its Docker socket. Exact external network names and enrollment configuration must come from upstream.

### Accepted: Mercure and frontend delivery

Mercure browser connections use `/.well-known/mercure` on the application's HTTPS origin, proxied through
Laravel's Nginx to the private hub. Authorization, topics, subscriptions, and renewal remain WF-007 decisions.

Normal startup and verification serve compiled frontend assets. Interactive development may explicitly enable
containerized Vite, routing both assets and hot-reload connections through Laravel's Nginx. No extra published
ports or host Node installation are required. Asset preparation and exact container configuration remain to be
settled; this decision does not put dependency installation or frontend orchestration into the startup wrapper.

### Accepted: thin lifecycle wrappers

Keep `./bin/up` a simple Compose wrapper in the Fight CMS / Omphalos style: build, detached Compose startup,
and optional log following. `./bin/down` delegates to Compose shutdown. Do not add a custom readiness supervisor,
diagnostic orchestration, or automatic failure teardown. Compose owns declared health checks and dependency
ordering; container startup alone is not proof that the complete browser journey is ready.

The inspected Fight CMS wrapper adds database-principal reconciliation; Omphalos delegates to a Compose wrapper
with worktree naming. Those project-specific policies are not adopted here. Neither database provisioning nor
worktree identity should be designed ahead of the pending upstream contract.

### Pending upstream and remaining questions

- Shared versus project-owned database/cache, isolated test databases, worktree identities, persistence and volume
  ownership, and cleanup rules remain upstream decisions. Shared database/cache with isolated test databases is a
  possibility, not an accepted topology. Do not assume one MySQL/Redis instance or volume per worktree.
- Agent OS's exact ingress integration contract is still pending. Its WF-023 settles architectural boundaries;
  the inspected TASK-00072 records runtime implementation as not started. No available integration is claimed.
- Still settle Laravel-specific service health/dependency declarations, container users and permissions, cache
  paths, asset preparation, environment/secrets configuration, and development-tool routes/access boundaries.
- Retain the existing MySQL-only and local-only/fail-closed dashboard requirements. Do not import Agent OS's
  PostgreSQL, runner, storage, or workflow services into Laravel.

### Inspected planning and wrapper sources

- `fight-agent-os/planning/wayfinder/tickets/WF-023-define-local-runtime-and-shared-ingress-topology.md`:
  accepted shared ingress, private-service boundary, hostnames and explicit host operations.
- `fight-agent-os/planning/tasks/00072-TASK.md`: planned installation runtime; not implementation evidence.
- `fight-cms/bin/up` and `fight-cms/bin/down`: Compose lifecycle wrapper pattern and project-specific database setup.
- `Omphalos/bin/up`, `Omphalos/bin/down`, and `Omphalos/bin/compose`: Compose lifecycle delegation and separate
  project-identity policy. Source checkout: `/Users/john/Ideaverse/AIOS/Omphalos`.

No runtime configuration, container, host mapping, certificate, secret, or shared resource is changed by this decision.
