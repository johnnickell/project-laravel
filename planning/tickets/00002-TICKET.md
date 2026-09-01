---
id: T-00002
prd: PRD-00002
title: Adopt Fight Common 1.2
status: done
blocked_by:
---

# Adopt Fight Common 1.2

## Outcome

Resolve a 1.2 candidate through Laravel's Composer installation, activate only supported local capabilities, run
lowest/latest booted journeys, and commit the canonical support receipt.

## Acceptance Criteria

- [x] The pinned `1.2.0-dev` alias resolves candidate `4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16` through Composer.
- [x] Laravel composes only Messaging, Persistence, Routing, Cache, and Filesystem providers.
- [x] `evidence/framework-support/receipt-v1.json` records deterministic canonical lock and receipt digests.
- [x] `./bin/planning-check` and `./bin/build` passed on the final tree (8 tests, 80 assertions; production autoload boot passed).

## Verification

Verified on 2026-08-31: `./bin/planning-check` passed; canonical `./bin/build` passed with Composer validation,
Pint, 8 tests/80 assertions, and production autoload/Laravel boot.
