---
id: T-00003
epic: EPIC-00003
title: Prepare Fight Common 2.0 Migration
status: needs-info
blocked_by:
---

# Prepare Fight Common 2.0 Migration

## Problem and outcome

Keep the migration visible without defining or implementing speculative breaking changes. This is now a
requirements TICKET under EPIC-00003, migrated from its former PRD-00002 parent without changing its status.

## Scope

Inventory Laravel-local impacts only after upstream publishes the Common 2.0 contract, deprecation-removal
inventory, and migration guide. Exclude speculative breaking changes, implementation, copied source and releases.

## Use cases and contracts

This is a gated planning requirement: no product command, query, event or external effect is authorized yet.
The inventory must identify affected use cases once the upstream contract exists; migration alone supplies none.

## Validation and permissions

Verify the three owning upstream artifacts before requirements acceptance. Actor/target permissions and runtime
validation are not yet specified and must be identified from those artifacts, not invented to make work ready.

## Acceptance Criteria

- [ ] Wait for the Fight Common 2.0 contract, deprecation-removal inventory, and migration guide.
- [ ] Then inventory Laravel-local changes and create bounded executable slices.

## Verification

Confirm all three owning Fight Common artifacts exist before changing this ticket to `ready-for-agent`.

## Decisions and dependencies

The external package-authority gate is unchanged. No same-level blocker or executable TASK is fabricated for it.
See [EPIC-00003](../epics/00003-EPIC.md) and the [migration mapping](../MIGRATION.md).

## TASKs

<!-- planning:children -->
None.
<!-- /planning:children -->

## Progress

Still `needs-info`; neither upstream authority nor implementation completion is claimed. After accepting the
requirements, decompose into bounded TASKs. This record is visible in the planning frontier, not the execution Board.
