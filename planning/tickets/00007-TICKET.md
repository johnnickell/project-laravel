---
id: T-00007
epic: EPIC-00001
title: Verify the Application Through a Running Compose Stack
status: needs-info
blocked_by: T-00006
---

# Verify the Application Through a Running Compose Stack

## Problem and outcome

The existing build provisions images, installs dependencies, and runs package certification. Developers and CI
need explicit setup followed by one predictable, read-only-in-intent application quality verdict inside an
already running Compose stack. This direction was accepted, but TASK decomposition now waits on reconciliation
with the concurrent develop-side lean-gate requirement preserved as T-00011.

## Scope

- In scope: thin `./bin/build` Compose exec wrapper; `scripts/build.php` named fail-fast phases; consistent
  repository-owned setup/lifecycle/focused-check commands; Pint-compatible standards and inward-dependency
  enforcement; one all-suite Pest/coverage execution; actual frontend checks; explicit CI setup/cleanup;
  `var/cache/` artifacts; direct operational verification and developer documentation.
- Out of scope: package certification, tooling/configuration/meta-tests, synthetic invalid fixtures, automatic
  provisioning inside `build`, a new package, speculative frontend harnesses, and the complete future
  MySQL/Redis/Horizon/Mercure runtime topology.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Prepare a development or CI stack explicitly | Repository lifecycle/setup commands; no business commands | Service readiness inspection; no business query | N/A: no business facts | Dependencies and a running service suitable for verification |
| Verify application changes | One canonical build command | Quality tools inspect owned artifacts | N/A: no business facts | Fail-fast named verdict, coverage report, permitted caches/build artifacts |
| Run verification without a required service | Same build entrypoint | Readiness precondition | N/A | Clear failure without starting services, installing dependencies, or building images |

## Validation and permissions

Preserve container/user permissions and worktree-safe ownership of runtime and cache artifacts. Do not expose
setup credentials in logs or require agent access beyond the repository-owned runtime contract. Business
permissions and payload validation are N/A: this is an operational gate, not a new business entrypoint.

Setup/install/update/audit operations remain explicit and separate. The canonical gate may produce ordinary
coverage/cache/frontend artifacts, but must not rewrite source, planning, locks, or dependencies. Its planning
phase uses the read-only check, not `--write`.

## Acceptance and evidence

- [ ] `./bin/build` is a thin noninteractive Docker Compose exec wrapper for `scripts/build.php` in the running
      application stack and fails clearly when required service/setup prerequisites are unavailable.
- [ ] PHP syntax, Pint, compatible PHPCS, PHPStan, Deptrac, Rector dry-run, and appropriate frontend checks run
      as named, fail-fast phases. Additional PHP rules agree with Pint; no competing formatter policy is imported.
- [ ] Every configured application suite executes once through Pest; exact 100% owned-production statement
      coverage is enforced from the same execution, with unit evidence distinguished from combined coverage.
- [ ] No image builds, dependency installs/updates/audits, implicit stack startup, support lanes, or certification
      receipts remain in the pre-submit gate. No wrappers/tools/configuration tests are added to the product suite.
- [ ] The gate retains planning validation and the homepage/application smoke contract. Cache artifacts remain
      under `var/cache/`; source and locks do not change as a build side effect.
- [ ] CI performs explicit setup/startup, invokes the same gate, and cleans its resources on success or failure.
      Direct local and exact-head hosted results are recorded separately.
- [ ] Setup, focused verification, full verification, failure, and shutdown instructions match observed behavior.
      Verify them directly rather than constructing a test suite for the wrappers or orchestrator.

## Decisions and dependencies

**Newly integrated decision:** [T-00011](00011-TICKET.md) preserves PR #9's non-archived lean-gate requirements,
including direct Unit-only exact coverage/Covers attributes and installed FightCommon PHPCS rules. Its CI and
production-install boundaries also differ from this record. Human reconciliation must settle those criteria
before either ticket is decision-complete. Both scopes remain intact; migration does not select a winner or
silently weaken coverage. Status is `needs-info`, not a claim that the earlier direction was never approved.

The build direction is approved in [EPIC-00001](../epics/00001-EPIC.md). Deliver after
[T-00006](00006-TICKET.md) removes package-certification obligations. Coordinate the bounded running-service,
setup, and cache contract with [WF-001](../wayfinder/tickets/WF-001-development-runtime-topology.md); do not
silently settle or implement the map's entire expanded runtime. If that coordination exposes an unresolved
scope decision, return this record to `needs-info` before creating an executable TASK.

This replaces the self-provisioning design in [T-00004](00004-TICKET.md), not its historical successful results.
The current gate remains authoritative until the replacement lands.

## TASKs

<!-- planning:children -->
None.
<!-- /planning:children -->

## Progress

Earlier requirement direction accepted; now waiting on T-00006 and the T-00011 policy reconciliation above.
No TASKs, build rewrite, CI changes, or runtime changes have been implemented. The migration correction changes
planning readiness only, not the current canonical gate.
