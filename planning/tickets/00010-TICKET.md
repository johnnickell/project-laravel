---
id: T-00010
epic: EPIC-00001
title: Deliver a Real Permission-Protected API Slice
status: needs-info
blocked_by: T-00007, T-00008, T-00009
---

# Deliver a Real Permission-Protected API Slice

## Problem and outcome

Prove the aligned foundation through a real bounded HTTP read/write journey using package contracts, shared
application authorization, and authoritative persistence. Container-resolution inventories or synthetic routes
cannot establish this outcome.

## Scope

- In scope: the jointly selected production read/write journey; thin single-interaction Actions and named
  Responders; trusted authentication context; transport validation; shared permissions; safe package Views;
  JSend/status/header mapping; real persistence and applicable effects; safe failure presentation; non-HTTP
  evidence for the same authorization boundary; preserved HTML homepage.
- Out of scope: complete AccessControl API, SPA, MCP server/tool catalog, arbitrary new authentication journeys,
  test-only production routes, package-message aliases, duplicate policy wrappers, and new business behavior
  invented solely to exercise the foundation.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Read an authorized resource | N/A: query does not mutate business state | Exact selected package query | N/A unless a real independently justified fact exists | Explicit safe View mapped to the endpoint response |
| Perform the selected authorized mutation | Exact selected package command | Required authoritative application lookups only | Preserve owning package events | Agreed state/audit/delivery effects, no extra transport policy |
| Reject invalid input or insufficient authority | Command does not perform protected work | No protected disclosure | No success fact | Safe validation/authentication/authorization response |
| Handle conflict, missing resource, or unexpected failure | Actual command/query failure contract | Actual operation context | Only legitimate failure/audit behavior | Context-specific status/envelope with secret-safe diagnostics |
| Invoke the protected use case outside HTTP | Same package/owned application entry path | Same protected query boundary | Same owning event contract | Equivalent authorization outcome without HTTP middleware |

## Validation and permissions

Authentication establishes trusted actor context using approved package and application contracts. Client actor,
target, role, or permission input must not become authority by assertion. Every exposed operation has an explicit
access classification and permission/ownership rule from T-00008; Actions/Gates/Policies must not bypass or
reimplement that rule. Include stale/revoked-authority and target-information-leak behavior where applicable.

Validate transport shape without duplicating Domain invariants. Responders own status, headers, JSend, and safe
mapping; they neither fetch missing business data nor decide policy. An arbitrary lookup failure is not a public
404 without operation context. Never expose entities, credentials, hashes, grants, SQL, or arbitrary exception
messages. Keep the existing homepage HTML and map transport fields explicitly.

## Acceptance and evidence

- [ ] The approved journey has an explicit route/method, command/query, input/result, permission/target rule,
      expected effects, and success/failure contract. Every in-scope API operation is accounted for.
- [ ] Actual HTTP interactions reach the shared authorization and Eloquent-backed package use case through
      a named Action/Responder pair, with safe Views and explicit API presentation.
- [ ] Functional tests cover success, invalid input, missing/invalid authentication, insufficient permission,
      stale/revoked authority, and target-ownership outcomes. Conflict, missing-resource, throttling, and other
      categories are tested when applicable or explicitly justified as N/A for the chosen interaction.
- [ ] Unexpected failures produce sanitized responses and diagnostics. Denials prevent protected effects and
      disclosure; success cannot be inferred from a mapper-only or mock-call-sequence test.
- [ ] Non-HTTP application execution proves the same permission boundary. Future MCP can reuse that contract
      without a second permission engine; no MCP transport is implemented for this ticket.
- [ ] The homepage remains intact; the complete application gate passes with exact owned-production coverage
      and separately recorded local/hosted evidence. No certification subsystem or synthetic endpoint is added.
- [ ] Current instructions, affected Wayfinder decisions, and parent progress describe the delivered bounded
      slice without claiming the complete API/SPA capability map is finished.

## Decisions and dependencies

Depends on [T-00007](00007-TICKET.md), [T-00008](00008-TICKET.md), and [T-00009](00009-TICKET.md).
Coordinate [WF-005](../wayfinder/tickets/WF-005-http-and-security-conventions.md) and the existing
[API/SPA map](../wayfinder/complete-access-control-api-and-spa-map.md); do not bypass unresolved authentication
or wire-contract authority by introducing an incompatible endpoint.

The precise real journey, public route/representation, trusted authentication context, and exception mapping
remain undecided. Select the journey jointly with T-00008/T-00009 before their implementation plans, rather than
waiting for this downstream implementation to choose it. Requirements split approval does not authorize an
invented user journey or a test-only production route.

## TASKs

<!-- planning:children -->
None.
<!-- /planning:children -->

## Progress

Bounded HTTP proof requirement approved in principle; missing journey and transport decisions keep it
`needs-info`. No endpoints, TASKs, MCP transport, or complete API/SPA implementation have been created.
