---
id: T-00001
epic: EPIC-00002
title: Establish the Canonical Full-Stack Laravel Starter Foundation
status: done
blocked_by:
---

# Establish the Canonical Full-Stack Laravel Starter Foundation

## Problem and outcome

Provide a governed Laravel-native starter, package-only Fight dependencies, a rendered homepage, and one local
and hosted verification entrypoint. This record now owns requirements; its former implementation/evidence body
is preserved in [TASK-00002](../tasks/00002-TASK.md), not archived or reverified by the migration.

## Scope

- Local planning/architecture/triage and public-source policies; Docker-backed Composer, PHPUnit, lifecycle and
  build wrappers; Laravel-owned package composition and HTML homepage through Nginx/PHP-FPM.
- Exclude login, persistence, browser UAT, client, realtime, release, tags, Packagist publication, template
  enablement, and create-project distribution.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Bootstrap and verify the starter | Repository setup/build operations, not business commands | Package boundary and Laravel boot inspection | N/A: maintenance | Reproducible tooling and local/hosted verdict |
| View the homepage | None | HTML homepage GET | None | Render the walking slice |

## Validation and permissions

Validate the public Composer boundary and real Laravel homepage. No login, authenticated actor/target, business
permission, write operation, or delivery guarantee is introduced. Keep package source upstream-owned.

## Acceptance and evidence

- [x] Repository-local planning, architecture, triage, and public-source guidance are canonical.
- [x] Docker-backed Composer, PHPUnit, lifecycle, and build wrappers exist.
- [x] The canonical build verifies the public Composer boundary and Laravel hello-world seam; hosted CI uses it.
- [x] MIT, contribution, and security policies are present.

## Decisions and dependencies

Completed foundation under former PRD-00001, now [EPIC-00002](../epics/00002-EPIC.md). No blockers were recorded.
The [migration](../MIGRATION.md) changes ownership/placement, not the historical acceptance decision.

## TASKs

<!-- planning:children -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [TASK-00002](../tasks/00002-TASK.md) | Establish the Canonical Full-Stack Laravel Starter Foundation | done | [T-00001](00001-TICKET.md) | — |
<!-- /planning:children -->

## Progress

Historical foundation acceptance and local/hosted green receipts remain recorded in TASK-00002. All requirement
criteria and the migrated child were already complete; no new verification, release, or deployment is claimed.
