---
id: T-00002
prd: PRD-00002
title: Adopt Fight Common 1.2
status: ready-for-agent
blocked_by:
---

# Adopt Fight Common 1.2

## Outcome

Resolve a 1.2 candidate through Laravel's Composer installation, activate only supported local capabilities, run
lowest/latest booted journeys, and commit the canonical support receipt.

## Acceptance Criteria

- [ ] The existing `^1.1` constraint resolves an installed 1.2 candidate recorded with its exact reference.
- [ ] Lowest/latest journeys boot selected Laravel providers, queued messages, transactions, response/routing, and selected adapters.
- [ ] `evidence/framework-support/receipt-v1.json` records canonical lock and evidence digests.
- [ ] `./bin/planning-check` and `./bin/build` pass before receipt commit.

## Verification

Run documented lowest/latest Composer and booted journeys, receipt canonicalization, `./bin/planning-check`, and `./bin/build`.
