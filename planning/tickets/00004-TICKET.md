---
id: T-00004
epic: EPIC-00003
title: Establish the Canonical Laravel Pre-Submit Quality Gate
status: done
blocked_by:
---

# Establish the Canonical Laravel Pre-Submit Quality Gate

## Problem and outcome

Establish the historical clean-clone canonical local/hosted gate and bounded non-root FPM runtime. The original
scope, all eleven detailed acceptance criteria, upstream provenance and exact verification are preserved in
[TASK-00004](../tasks/00004-TASK.md), which owns the delivered implementation.

## Scope

- Ordered Composer validation, Pint/PHPCS, PHPStan, Deptrac, Rector, Pest/Laravel coverage, frontend build,
  planning validation, cached configuration, dependency lanes/receipt and no-dev boot proof.
- Two-service Compose runtime, non-root FPM, bounded pool and FIFO stdout behavior.
- Exclude new business capabilities, package source copying, new receipt authorities and release publication.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Verify a clean clone | `./bin/build`; maintenance, not business execution | Quality and retained Laravel journey checks | N/A | One ordered local/hosted verdict and build/cache artifacts |
| Run the minimal runtime | Explicit Compose lifecycle | Runtime readiness | N/A | Non-root FPM and web server with bounded resources |

## Validation and permissions

Fail on quality/test errors rather than masking them with baselines. Preserve runtime file/user permissions and
keep credentials out of diagnostics. No business actor/target authorization or new API behavior is introduced.

## Acceptance and evidence

- [x] Clean-clone build provides the complete verdict with locked tools, exact configured coverage, and all
  retained checks; detailed historical checks and exclusions remain in TASK-00004.
- [x] Inward dependency enforcement and Laravel-owned Adapter/composition boundaries hold.
- [x] Planning runs once at the worktree-safe host boundary; no synthetic production capabilities or tool tests.
- [x] Minimal FPM runtime and hosted delegation match the agreed operational contract.
- [x] Local and exact-head hosted results are separately recorded.

## Decisions and dependencies

Migrated under [EPIC-00003](../epics/00003-EPIC.md), formerly PRD-00002. EPIC-00001 supersedes the future
self-provisioning/certification obligations, not this successful historical delivery. T-00007 and T-00011 retain
the successor-gate requirements and their unresolved policy reconciliation.

## TASKs

<!-- planning:children -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [TASK-00004](../tasks/00004-TASK.md) | Establish the Canonical Laravel Pre-Submit Quality Gate | done | [T-00004](00004-TICKET.md) | — |
<!-- /planning:children -->

## Progress

Complete through TASK-00004 / PR #7. The recorded hosted run for `575763d900f60f9a7b556c1f6431f8979a2760aa`
remains historical evidence; migration does not certify the replacement gate or fabricate a new review.
