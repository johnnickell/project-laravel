# Queues, scheduling, and mail

**Labels:** `wayfinder:grilling`, `area:queues`, `area:mail`
**Mode:** HITL
**Status:** Open
**Gate:** —
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** [WF-001](WF-001-development-runtime-topology.md), [WF-004](WF-004-persistence-and-transaction-model.md), [WF-005](WF-005-http-and-security-conventions.md)

## Question

How are AccessControl's asynchronous delivery, retry, expiry, recovery, and security-email behaviors composed
with Redis, Horizon, Laravel scheduling, and Mailpit without violating transaction or audit guarantees?

## Must decide

- Queue/job boundaries for package events and operational commands, payload/version rules, serialization
  boundaries, idempotency keys, deduplication, timeout, retry, backoff, and terminal-failure handling.
- Redis queue names and version-controlled Horizon supervisors, process counts, balancing, memory/time limits,
  graceful termination, metrics, failure visibility, and local dashboard access.
- The outbox or after-commit mechanism that prevents workers, email, and realtime consumers from observing
  rolled-back state and prevents committed database work from being silently lost before Redis/Mercure publication.
- Scheduler ownership for session/token expiry, failed-delivery retry, recovery, cleanup, and lock/overlap
  policy using Cron-triggered `schedule:run` and Redis-backed scheduler locks.
- Security-email templates, localization boundary, recipient resolution, privacy-safe logging, retry behavior,
  Mailpit SMTP/UI defaults, and which delivery failures change command outcomes versus recover asynchronously.
- Recovery behavior after Redis, worker, scheduler, or mail outages, including poison jobs and operator-visible
  evidence.

## Required evidence

- Integration tests prove after-commit dispatch, job idempotency, bounded retries, failure capture, recovery,
  scheduler overlap protection, and no duplicate security effect.
- Horizon journeys show each supervisor consuming its intended queue and exposing meaningful failure metrics.
- Scheduled recovery tests prove due work resumes after interruption and does not run early or concurrently.
- Mailpit journeys prove the complete security-email delivery and retry path using meaningful rendered content,
  without tests that merely inspect queue, mail, or Compose configuration text.

## References

- [Laravel Horizon](https://laravel.com/framework/docs/13.x/horizon)
- [Laravel scheduling](https://laravel.com/framework/docs/13.x/scheduling)

## Resolution boundary

This ticket settles Laravel asynchronous processing, scheduled operations, and local email behavior. It does
not define production process orchestration, the external HTTP contract, or browser realtime state handling.

## Resolution

Open. Record queue topology, supervisor policy, schedules, recovery, and mail semantics here before closing.
