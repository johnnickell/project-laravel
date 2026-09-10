---
id: T-00004
prd: PRD-00002
title: Establish the Canonical Laravel Pre-Submit Quality Gate
status: done
blocked_by:
---

# Establish the Canonical Laravel Pre-Submit Quality Gate

## Outcome

Make `./bin/build` the permanent clean-clone completion gate for the Laravel starter while preserving its
framework-native boot, cached configuration, frontend, dependency-lane, receipt, and production-install evidence,
and align its minimal FPM runtime with the proven Fight CMS and Symfony starter pattern.

## Portfolio Provenance

- Fight Common [T-00087](https://github.com/johnnickell/fight-common/blob/develop/planning/tickets/00087-TICKET.md)
- Fight Common PRD-00018

## Scope

- In scope: ordinary Composer validation with only the temporary candidate-reference warning allowed; Pint plus
  the repository PHPCS/fixer policy; PHPStan; Deptrac; Rector dry-run; Pest with the Laravel plugin and exact 100%
  owned-production statement coverage; lowest/latest dependency lanes; booted Laravel HTTP, console, queue, cache, database, and production
  journeys; receipt authority under `etc/evidence/framework-support/`; clean `--no-dev` installation; frontend asset compilation; host-boundary planning
  validation; the existing two-service Compose runtime using a non-root FPM user, bounded pool configuration, and
  FIFO stdout workaround; and hosted CI delegation to `./bin/build`.
- Out of scope: a Fight Laravel package, copied Fight package source, aggregate production profiles or receipt
  authorities, new business capabilities, release publication, or a Fight Common-owned starter build.

## Acceptance Criteria

- [x] A clean clone can run only `./bin/build` and receive the complete ordered local verdict.
- [x] Pint/PHPCS, PHPStan, Deptrac, Rector dry-run, Pest, its Laravel plugin, and the compatible PHPUnit engine are
      locked development dependencies and execute
      inside the build image without baselines or suppressed failures.
- [x] Deptrac enforces Adapter to Application to Domain, rejects unclassified production code, and keeps Laravel
      types at Adapter and composition boundaries.
- [x] Pest is the canonical Laravel test runner and the existing framework-booted Feature journeys remain intact.
      `pest --coverage --exactly=100` applies to the owned production source configured in `phpunit.xml`.
- [x] Existing candidate validation, dependency lanes, receipt authority, Laravel boot, cached configuration,
      planning, frontend asset compilation, and production-autoload checks remain in the canonical gate.
- [x] Committed support receipts and dependency-lane evidence live under `etc/evidence/framework-support/`; no
      generic repository-root `evidence/` namespace is recreated.
- [x] `./bin/build` invokes planning validation once at the host boundary, where `git check-ignore` works in normal
      and linked worktrees, without adding Git-metadata mounts solely for that assertion.
- [x] The FPM Dockerfile and Compose configuration run non-root with bounded `ondemand` pool settings, clean FIFO
      stdout streaming, and only the Laravel starter's required `api` and `server` services.
- [x] Capability probes and fixtures remain test-only; no synthetic Domain events, global platform profile, or
      receipt-authority service is added to production for test convenience.
- [x] `.github/workflows/build.yml` invokes `./bin/build` without duplicating its ordered checks.
- [x] Local and exact-head hosted results are recorded separately.

## Verification

- Direct execution of the configured quality tools and real framework-booted journeys; no tests that parse tooling
  scripts or configuration.
- `./bin/planning-check`
- `./bin/build`
- Exact-head hosted build after publication.

## Completion Notes

Local implementation is complete: `./bin/planning-check`, the direct
standards and architecture tools, warning-free Pest with exact 100% owned-production statement coverage, both
read-only dependency lanes, the frontend build, and the disposable `--no-dev` production-autoload proof pass on
2026-09-09. The gate contains no `tests/Tooling` suite or synthetic fixtures added to certify its own scripts.

Hosted `./bin/build` passed for published implementation head
`575763d900f60f9a7b556c1f6431f8979a2760aa` in GitHub Actions run
[34439214106](https://github.com/johnnickell/project-laravel/actions/runs/34439214106).
