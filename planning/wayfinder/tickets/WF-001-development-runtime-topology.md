# Development runtime topology

**Labels:** `wayfinder:grilling`, `area:operations`
**Mode:** HITL
**Status:** Open
**Gate:** —
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** —

## Question

What exact Laravel-owned local runtime and wrapper contract makes the full AccessControl API and SPA
repeatable, observable, healthy, and isolated across ordinary checkouts and linked worktrees?

## Must decide

- The Compose topology for Nginx, PHP-FPM, MySQL, Redis, Mercure, Horizon-managed PHP-CLI workers,
  Cron-triggered `artisan schedule:run`, and Mailpit, including startup ordering and failure propagation.
- Health checks and readiness criteria for every service, plus the ports that expose the application, Horizon,
  Mercure, Swagger UI, Mailpit UI, and Mailpit SMTP locally without ambiguous collisions.
- Named-volume versus bind-mount ownership, database and Redis persistence defaults, container users,
  permissions, cache paths under `var/cache/`, and deterministic `public/dist/` availability.
- The `.env.example` contract for database, Redis, queues, cache, mail, Mercure, JWT, frontend, and local
  dashboard/spec URLs, including safe local defaults and explicit required secrets.
- Clean `./bin/up` and `./bin/down` lifecycle semantics, log behavior, exit behavior, orphan cleanup, and how
  repository-owned wrappers select project names and ports in concurrent worktrees.
- MySQL as the only relational database in this starter family; no PostgreSQL runtime or certification lane.
- Local-only access defaults for Horizon and Swagger UI, with fail-closed non-local behavior until separate
  authorization policy exists.

## Required evidence

- Rendered Compose configuration names every service, network, port, dependency, health check, and volume.
- A documented clean-start, health, log, and shutdown journey covers each service and leaves no task-owned
  containers or networks behind after `./bin/down`.
- Two concurrent worktree instances can derive non-conflicting project identities and externally mapped ports.
- MySQL is the application database; Redis backs cache, queues, Horizon, and scheduler locks; `artisan horizon`
  runs in a PHP-CLI worker, Cron invokes `artisan schedule:run`, and Mercure runs as the shared private SSE hub.

## References

- [Laravel scheduling](https://laravel.com/framework/docs/13.x/scheduling)

## Resolution boundary

This ticket settles the local developer topology, configuration surface, isolation rules, and wrapper behavior.
It does not design production deployment, literal production cron, application persistence mappings, queue job
semantics, API routes, or SPA behavior.

## Resolution

Open. Record the selected topology and exact verification contract here before closing this ticket.
