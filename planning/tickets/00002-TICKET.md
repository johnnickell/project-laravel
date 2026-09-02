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

- [x] The compatibility-only `1.2.0-dev` inline alias resolves the candidate as Composer `dev-develop` at `ceae16393fd15a2a20687b7533dc048ab1f6a1af`.
- [x] Laravel registers all 15 Fight Common Laravel providers, including the Common-owned Laravel filesystem, queued messaging, and private-publication adapters; application-owned synchronous composition, queue configuration/workers, channel authorization, fail-closed HMAC/JWT configuration, and safe defaults for validation, event publication state, event mapping/store, scheduler, audit, file transfer, and SMS remain local.
- [x] `evidence/framework-support/receipt-v1.json` records a passing complete platform inventory, canonical `1.2.0-dev` receipt identity, and regenerated lowest/latest lane evidence for the current candidate.
- [x] The canonical Composer validation step permits only the documented immutable Fight Common commit-reference warning and fails on validation errors or any additional warning; remove the allowlist when Fight Common 1.2 is tagged.
- [x] `./bin/planning-check` and `./bin/build` pass for the complete profile after the current candidate's HMAC request-signing defect is fixed.

## Verification

On 2026-09-01 the adapter-ownership correction reran fresh dependency lanes with Fight Common candidate
`ceae16393fd15a2a20687b7533dc048ab1f6a1af`. The disposable lowest lane passed with lock SHA-256
`25ab08ee1ed020d10598acf884af6578b18e3f749a263f7b58d493a9c89f304a`; the fresh latest lane passed with
root-lock SHA-256 `aaa784e6a6577f48ddd05d93c6338f1fb47bb001892a807a760f4d2464118487`. Both executed 19 booted
profile tests, including resolution from Common of the asynchronous command bus, asynchronous event dispatcher, and
private publisher; database-queue worker delivery; private publication; fail-closed HMAC/JWT configuration; native
transactional UnitOfWork; named routing; JSend response; and Laravel filesystem journeys. `./bin/planning-check`
passed with 5 records and 3 active; the final detached `./bin/build` passed with 24 tests, 299 assertions, production
autoload, and Laravel boot.
