# Ticket Board

Ticket files are canonical for status and blockers; this board is canonical for recommended execution order.

## "What's Next?" Contract

When an unqualified "What's next?" is asked:

1. **Human decision:** return the item under **Now** when it still requires judgment.
2. **Implementation:** return the first ticket under **Ready Frontier**.
3. If the question is unqualified, return both targets. Never choose by ticket number alone.

## Now

Fight Common 2.0 remains `needs-info` until its contract, deprecation-removal inventory, and migration guide exist.

## Wayfinder Review

[Complete Laravel AccessControl API and SPA](../wayfinder/complete-access-control-api-and-spa-map.md) is active.
Its first review target is [WF-001 — Development runtime topology](../wayfinder/tickets/WF-001-development-runtime-topology.md),
which fixes the Compose, wrapper, environment, health, and worktree-isolation contract. WF-002 is independently
unblocked, but WF-001 remains the map's explicit environment-first frontier.

## Ready Frontier

| Suggested Order | Ticket | Parent PRD | Why now |
| --- | --- | --- | --- |
| 1 | [T-00006 — Establish the Lean Laravel Pre-Submit Quality Gate](00006-TICKET.md) | [PRD-00002](../specs/00002-PRD.md) | Direct successor to Fight Common T-00087; remove certification machinery while retaining Laravel behavior. |

## Waiting

No ticket is currently waiting on an unfinished local dependency.

## Needs Info

| Ticket | Parent PRD | Missing decision or evidence |
| --- | --- | --- |
| [T-00003 — Prepare Fight Common 2.0 Migration](00003-TICKET.md) | [PRD-00002](../specs/00002-PRD.md) | Fight Common 2.0 contract, deprecation-removal inventory, and migration guide. |

## Recently Done

| Ticket | Parent PRD | Outcome |
|--------|------------|---------|
| [T-00004 — Establish the Canonical Laravel Pre-Submit Quality Gate](00004-TICKET.md) | [PRD-00002](../specs/00002-PRD.md) | The lean canonical `./bin/build` gate passes locally and on its published implementation head without a Tooling meta-test suite. |
| [T-00005 — Re-certify Rewritten Fight Common Candidate](00005-TICKET.md) | [PRD-00002](../specs/00002-PRD.md) | Re-certified the tree-equivalent rewritten Fight Common candidate with fresh latest/lowest locks, receipt digests, and the canonical build. |
| [T-00001 — Establish the Canonical Full-Stack Laravel Starter Foundation](00001-TICKET.md) | [PRD-00001](../specs/00001-PRD.md) | Local and hosted `./bin/build` receipts are green. The governed bootstrap handoff is accepted. |
| [T-00002 — Adopt Fight Common 1.2](00002-TICKET.md) | [PRD-00002](../specs/00002-PRD.md) | Common-owned Laravel async/private adapters, canonical receipt, and fresh dependency/build evidence are verified at `ceae163`. |
