---
id: T-00006
prd: PRD-00002
title: Establish the Lean Laravel Pre-Submit Quality Gate
status: ready-for-agent
blocked_by:
---

# Establish the Lean Laravel Pre-Submit Quality Gate

## Outcome

Replace the historical certification-oriented gate with one Laravel-owned, lean `./bin/build` gate. This is the
local successor to Fight Common [T-00087](https://github.com/johnnickell/fight-common/blob/develop/planning/tickets/00087-TICKET.md)
and [ADR 0026](https://github.com/johnnickell/fight-common/blob/develop/planning/adr/0026-lean-pre-submit-and-release-qualification.md).

## Scope

- Require `johnnickell/fight-common:^1.2` and the installed `FightCommon` PHPCS standard; keep repository-owned
  scan paths and exclusions.
- Make `./bin/build` the sole local and hosted pre-submit gate. It runs each retained Unit, Integration,
  Functional, frontend, and browser suite exactly once, plus Composer validation, syntax/formatting, PHPCS,
  PHPStan, Deptrac, and Rector dry-run.
- Direct Unit tests alone prove exact 100% statement coverage of owned production code with `#[CoversClass]`.
  Retained framework boundaries and valuable application journeys use `#[CoversNothing]`.
- Keep framework-native boundary coverage and valuable Laravel journeys. Framework types remain in Adapter and
  composition code under Adapter -> Application -> Domain.

## Exclusions and Cleanup

- Remove receipt generation/authority, candidate validation, lowest/latest lanes, clean production-install
  inspection, auxiliary locks/digests, and Fight Common feature-certification journeys from ordinary builds.
- Remove broad Fight Common feature journeys that do not protect Laravel-owned behavior.
- Do not test build scripts, CI, configuration, coverage tooling, receipts, certification-only fixtures, or
  documentation. Hosted CI invokes `./bin/build` only; its status remains separate delivery evidence.

## Acceptance Criteria

- [ ] `./bin/build` is the sole ordered local and hosted pre-submit gate and executes every retained suite once.
- [ ] The installed package constraint and `FightCommon` standard, local paths/exclusions, Composer validation,
      formatting, PHPStan, Deptrac, Rector dry-run, and exact Unit-only coverage are enforced.
- [ ] Unit tests use `#[CoversClass]`; retained Integration/Functional/frontend/browser boundary and journey tests
      use `#[CoversNothing]` and do not hide missing direct Unit coverage.
- [ ] Laravel-owned boundary behavior and valuable product journeys remain; framework types stay out of Domain and
      Application.
- [ ] Historical receipts and completed tickets remain historical records, but ordinary builds contain none of
      their lanes, authorities, locks, digests, or candidate qualification.

## Verification

- Run focused retained suites while changing them, then `./bin/build` for the implementation verdict.
- Confirm hosted CI calls `./bin/build` only and record hosted status separately from local evidence.
