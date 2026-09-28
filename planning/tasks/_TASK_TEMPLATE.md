---
id: TASK-NNNNN
ticket: T-NNNNN
title: Brief independently reviewable outcome
status: needs-triage
order:
blocked_by:
pr:
---

# Brief independently reviewable outcome

## Outcome

State the bounded observable slice and the parent acceptance criteria it satisfies. A TASK normally owns one PR.

## Scope

- In scope:
- Out of scope:

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Describe the interaction | Contract or justified N/A | Contract or justified N/A | Contract or justified N/A | Observable changes |

## Validation and permissions

State the trusted actor/target, validation, authorization, rejection, and failure contracts. Explain N/A concerns.

## Acceptance criteria

- [ ] Independently verifiable outcome tied to the parent requirement.

## Verification and evidence

Name focused checks and the canonical `./bin/build` gate. For bugs, reproduce the failure with a regression test
before repair where possible; record why not when impossible. Test actual behavior; inspect tooling and guidance
through their owning commands without adding product-suite meta-tests.

## Decisions and coordination

Record settled decisions and prerequisite TASK IDs. Missing decisions keep this TASK out of execution readiness.
Ignored `.runs/` notes may coordinate work but do not replace durable acceptance or expand scope.

## Completion notes

Record actual evidence, independent review state, and the PR if known. `done` is not merge, release, or deployment.
Reconcile parent progress and refresh generated views after updating this record.
