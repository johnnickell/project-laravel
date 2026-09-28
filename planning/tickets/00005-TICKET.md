---
id: T-00005
epic: EPIC-00003
title: Re-certify Rewritten Fight Common Candidate
status: done
blocked_by:
---

# Re-certify Rewritten Fight Common Candidate

## Problem and outcome

Historically re-certify the existing profile after Common's authorship-only history rewrite, without changing
its source tree or runtime behavior. [TASK-00005](../tasks/00005-TASK.md) preserves the former executable record,
exact old/new source mapping and completed verification.

## Scope

- Exact source identity mapping, consumer constraints/locks, lowest/latest verification, receipt digests and
  planning provenance.
- Exclude runtime/API changes, newer Common source, Common 2.0, releases, publication and backup cleanup.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Reconcile rewritten source identity | Maintenance dependency/verification operations | Compare immutable source trees | N/A | Replacement lock/receipt identity with unchanged certified source |

## Validation and permissions

Require equal old/new source trees and exact regenerated identities. There is no product actor/target,
permission, command/query/event, runtime failure-policy change or new external-delivery guarantee.

## Acceptance and evidence

- [x] The recorded old/new Common commits have the same tree.
- [x] Both dependency lanes resolve the rewritten candidate without changing its source.
- [x] Receipt reference and lock/content/receipt digests are regenerated.
- [x] Planning validation and the complete local build pass.

## Decisions and dependencies

The 2026-09-09 source rewrite superseded the identity from T-00002, not its historical acceptance. This record
now belongs to [EPIC-00003](../epics/00003-EPIC.md), formerly PRD-00002. TASK-00001 later retires certification.

## TASKs

<!-- planning:children -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [TASK-00005](../tasks/00005-TASK.md) | Re-certify Rewritten Fight Common Candidate | done | [T-00005](00005-TICKET.md) | — |
<!-- /planning:children -->

## Progress

Historically complete; exact evidence is retained in TASK-00005. The [migration](../MIGRATION.md) is a planning
conversion, not a new implementation, recertification, independent review or publication claim.
