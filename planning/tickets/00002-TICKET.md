---
id: T-00002
prd: PRD-00002
title: Adopt Fight Common 1.2
status: done
blocked_by:
---

# Adopt Fight Common 1.2

## Outcome

Provide the complete Laravel platform profile: every Fight Common Laravel provider and each documented shared
fallback is registered by default, while application routes, templates, secrets, event mappings, and policy remain local.

## Acceptance Criteria

- [x] The compatibility-only `1.2.0-dev` inline alias resolves the candidate as Composer `dev-develop` at `4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16`.
- [x] Laravel registers all 15 Fight Common Laravel providers and complete safe defaults for validation, synchronous and queued messaging, event publication state, private publication, event mapping/store, scheduler, audit, file transfer, and SMS.
- [x] `evidence/framework-support/receipt-v1.json` records the complete platform inventory, actual Composer version and reference, the checked-in lowest-resolution lock digest, and deterministic receipt digests.
- [x] The canonical Composer validation step permits only the documented immutable Fight Common commit-reference warning and fails on validation errors or any additional warning; remove the allowlist when Fight Common 1.2 is tagged.
- [x] `./bin/planning-check` and `./bin/build` pass for the expanded profile (13 tests, 185 assertions; production autoload boot passed).

## Verification

Verified on 2026-09-01: `./bin/planning-check` passed; canonical `./bin/build` passed with the exact one-warning
Composer allowlist, Pint, 13 tests/185 assertions, and production autoload/Laravel boot.
