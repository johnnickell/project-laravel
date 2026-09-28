---
id: T-00008
epic: EPIC-00001
title: Enforce Shared Application Permission Policy
status: needs-info
blocked_by: T-00006
---

# Enforce Shared Application Permission Policy

## Problem and outcome

HTTP-only permission checks would let future MCP or other application callers bypass policy. Establish one
application authorization boundary using current Fight AccessControl contracts, with Laravel Gates/Policies
as framework-facing integration rather than a second authority.

## Scope

- In scope: operation/access classification for every in-scope command and query; trusted actor and target
  context; authoritative permission and ownership evaluation; explicit public-entry/system classifications;
  default denial; protected non-HTTP invocation; request/job-scoped authority; application-level outcomes and
  meaningful tests; the contract reused by subsequent persistence and HTTP delivery.
- Out of scope: MCP server/tool implementation, a competing role/permission engine, role-name shortcuts,
  retiring package authorization interfaces, Domain invocation awareness, full authentication journeys,
  exhaustive AccessControl operations, and synthetic production routes for test convenience.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Invoke an explicitly permitted operation | Selected package command, unchanged | Selected package query, unchanged | Only the owning use case's actual facts | One authorized use case proceeds through its owning package/application boundary |
| Reject missing policy, permission, or target authority | Protected command must not execute | Protected data must not be returned | No protected success event | No protected state or external effect occurs |
| Invoke outside HTTP with trusted context | Same protected command path | Same protected query path | No renamed package events | Same permission outcome without relying on HTTP middleware |
| Handle public entry or system work | Only explicitly classified operations | Only explicitly classified operations | As required by the owning operation | No implicit bypass from absent user/session context |

## Validation and permissions

Resolve permission and target/ownership authority from supported package-backed state. Client-supplied role or
permission claims, UI visibility, and route reachability do not grant authority. Missing policies and required
identity fail closed. Actor/target context is validated at entry and bound to the operation; no transport can
substitute an arbitrary actor. Public entry operations, if introduced, need a deliberate access classification.

The Domain retains intrinsic business invariants; Application owns invocation authorization. Keep package
messages intact and introduce owned orchestration only for genuinely missing application policy. Application
must not depend on Laravel facades/concrete adapters. Scope cached principal authority to one invocation/request
or job so revocation and user context cannot leak across long-running processes.

## Acceptance and evidence

- [ ] A bounded operation matrix maps each selected command/query to actor, target, required permission,
      ownership constraints, explicit public/system classification where relevant, and observable denial.
- [ ] Missing mappings, missing authority, insufficient permission, and target mismatch reject before protected
      execution or disclosure. No route, MCP adapter, or other entrypoint can choose an unchecked protected path.
- [ ] Laravel Gates/Policies and non-HTTP callers use the same application rule, without copied package policy
      or independent transport-specific decisions.
- [ ] Tests prove allowed and denied outcomes, unclassified operations, target mismatch, and request/job authority
      isolation. Tests assert effects/results, not merely an authorization mock's call sequence.
- [ ] Authoritative-state and stale/revoked-authority requirements are explicit; T-00009 provides the real
      persistence evidence and T-00010 the HTTP interaction evidence. Unit tests alone do not establish either.
- [ ] Safe application denial/failure contracts can be mapped separately by HTTP and a future MCP adapter.
      No MCP server, fake HTTP route, or package message alias is required for this outcome.

## Decisions and dependencies

Depends on [T-00006](00006-TICKET.md)'s verified public contracts. Coordinate with
[WF-002](../wayfinder/tickets/WF-002-access-control-capability-inventory.md) and
[WF-005](../wayfinder/tickets/WF-005-http-and-security-conventions.md).

Before TASK decomposition, select the bounded real read/write journey also exercised by T-00009/T-00010 and
settle its permissions, target/ownership rules, trusted-context origin, revocation freshness, and public/system
exceptions. Select safe application failures and the supported principal API. The approved split is not approval
of unspecified permission names or authentication mechanics. These decisions may be settled jointly for the
three requirements without waiting for downstream implementation or creating a dependency cycle.

## TASKs

<!-- planning:children -->
None.
<!-- /planning:children -->

## Progress

Shared authorization direction approved. Exact operation/policy and public API facts remain unresolved;
no TASKs, permission framework, or authorization implementation exists yet.
