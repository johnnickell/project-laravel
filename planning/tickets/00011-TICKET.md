---
id: T-00011
epic: EPIC-00001
title: Establish the Lean Laravel Pre-Submit Quality Gate
status: needs-info
blocked_by: T-00006
---

# Establish the Lean Laravel Pre-Submit Quality Gate

## Migration and decision gate

This is the complete non-archived lean-gate requirement merged into develop by PR #9 at
`b1d540c0170e7aa686793b5047f768715aaa0079`, formerly T-00006 under PRD-00002. The reviewed feature branch
already used T-00006 for package adoption. Under the maintainer's complete migration/collision-correction
request, this requirement receives the next unused identity T-00011 and belongs to EPIC-00001. Its original
scope, exclusions and unchecked criteria are preserved below; none is silently discarded or implemented.
See the [migration mapping](../MIGRATION.md) for immutable provenance.

The source was `ready-for-agent` under the old executable-ticket lifecycle. It is now `needs-info` because it
collides semantically with [T-00007](00007-TICKET.md): direct Unit-only exact coverage and Covers attributes versus
all-suite statement coverage with separately reported unit evidence; removal of clean production-install
inspection; installed `FightCommon` PHPCS rules versus the existing compatible local rules; and CI-only gate
invocation versus explicit CI setup/startup/cleanup. The human must reconcile these requirements before either
successor-gate TICKET is accepted for TASK decomposition. No lean-gate implementation TASK is invented.
Package adoption remains a prerequisite; this policy decision does not retroactively alter TASK-00001's scope.

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

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Verify owned Laravel behavior | Canonical build; no business command | Quality tools and real application boundaries | N/A: operational maintenance | Fail-fast local verdict with separate hosted delivery evidence |

## Validation and permissions

Preserve native framework boundaries, credentials and runtime/cache ownership. No new business actor/target,
permission or API entrypoint is introduced. Do not manufacture tests to satisfy a coverage denominator. Resolve
the proving seams with T-00007 before implementation; no source or gate changes are authorized by this migration.

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

## TASKs

<!-- planning:children -->
None.
<!-- /planning:children -->

## Progress

Requirements migrated, not delivered or rejected. No checkboxes are newly completed. Human reconciliation with
T-00007 is next; requirement blockers and missing decisions remain visible. Publication of this planning
correction does not approve a gate rewrite or substitute integration coverage for the requested Unit-only result.
