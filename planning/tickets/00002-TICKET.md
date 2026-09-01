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

- [x] The compatibility-only `1.2.0-dev` inline alias resolves the candidate as Composer `dev-develop` at `cfb951c368f9b40fe460e931011b092d8eef6509`.
- [x] Laravel registers all 15 Fight Common Laravel providers, including the Common-owned Laravel filesystem adapter using Laravel's `files` service, and safe defaults for validation, synchronous and queued messaging, event publication state, private publication, event mapping/store, scheduler, audit, file transfer, and SMS.
- [x] `evidence/framework-support/receipt-v1.json` records a passing complete platform inventory and regenerated lowest/latest lane evidence for the current candidate.
- [x] The canonical Composer validation step permits only the documented immutable Fight Common commit-reference warning and fails on validation errors or any additional warning; remove the allowlist when Fight Common 1.2 is tagged.
- [x] `./bin/planning-check` and `./bin/build` pass for the complete profile after the current candidate's HMAC request-signing defect is fixed.

## Verification

On 2026-09-01 the complete Laravel profile was verified with Fight Common candidate
`cfb951c368f9b40fe460e931011b092d8eef6509`. The disposable lowest lane passed with lock SHA-256
`8435609b31b6cf10c7d1f4b0eafeede1c8a3fca4d90a5c212ecae409985c1cfb`; the fresh latest lane passed with
root-lock SHA-256 `f358655de55b4191aacaac10cb7be458b3dee3a9160987935a42b3119107eba4`. Both booted the focused
profile suite (13 tests, 182 assertions), including database-queue worker, HMAC signer/authenticator, JWT, and
Laravel filesystem journeys.
