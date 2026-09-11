# OpenAPI and release handshake

**Labels:** `wayfinder:grilling`, `area:api`
**Mode:** HITL
**Status:** Open
**Gate:** Symfony canonical wire contract
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** [WF-002](WF-002-access-control-capability-inventory.md)

## Question

What OpenAPI 3.1 and package-release contract lets Laravel expose every external AccessControl capability with
stable JSend schemas while keeping reusable components in Fight AccessControl and the complete document owned by
Laravel?

## Must decide

- The Fight AccessControl `0.2.0` installed `resources/openapi/` component path, manifest, version compatibility,
  dependency constraint, and clean-install verification before Laravel implementation begins.
- A Laravel-native Artisan generator that builds exactly one OpenAPI 3.1 document in one pass from the package
  schemas plus Laravel-owned Actions, request/response DTOs, routes, security declarations, and local components.
- Operation IDs, resource paths beneath `/api/v1/access/*`, parameters, request bodies, response codes, and
  reusable JSend success, fail, and error envelopes for every external capability from WF-002.
- Shared identifiers, timestamps, pagination, filtering, sorting, optimistic-concurrency fields, validation
  details, error codes, and security schemes needed by generated TypeScript types and HTTP tests.
- How Swagger UI renders Laravel's checked-in generated artifact locally, and how
  non-local access fails closed pending an explicit authorization policy.
- The generated-client/type workflow and drift check that fail when installed OpenAPI, Laravel routes, or
  committed generated artifacts disagree.

## Required evidence

- Bidirectional contract coverage proves every external WF-002 capability has one OpenAPI operation and every
  operation maps back to an approved capability.
- Every intentionally internal command is present in the classification evidence and absent from the public
  contract by design.
- OpenAPI 3.1 validation, example parsing, TypeScript generation, and local Swagger UI rendering are specified
  through their owning tools, without duplicative configuration-text tests.
- The handoff names the immutable AccessControl release input and Symfony normalized wire authority Laravel must
  consume.

## Resolution boundary

This ticket settles the transport contract and cross-repository release handshake. Fight AccessControl owns only
reusable schema components; Laravel owns and verifies the complete specification while matching Symfony's paths,
methods, operation IDs, payloads, safe errors, and authentication behavior. Release publication is out of scope.

## Resolution

Open. Record the agreed upstream artifact and version handshake here before closing this ticket.
