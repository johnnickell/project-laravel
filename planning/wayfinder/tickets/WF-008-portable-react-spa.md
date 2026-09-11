# Portable React SPA

**Labels:** `wayfinder:prototype`, `area:frontend`
**Mode:** HITL
**Status:** Open
**Gate:** Immutable accepted Symfony client reference
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** [WF-003](WF-003-openapi-and-release-handshake.md), [WF-005](WF-005-http-and-security-conventions.md), [WF-007](WF-007-realtime-invalidation.md)

## Question

What portable TypeScript React architecture should `project-symfony` establish first, and what exact adoption
contract lets Laravel own and build the complete client under `client/` without importing Symfony
infrastructure?

## Must decide

- The portable baseline boundary: reusable feature/application UI code and generated contract artifacts versus
  framework-specific bootstrap, environment, routing integration, asset entrypoints, and delivery adapters.
- The immutable Symfony source reference, acceptance evidence, exact copy manifest, adoption mechanism, provenance
  hygiene, and drift policy; no Symfony backend infrastructure or private implementation detail enters Laravel.
- `client/` layout, TypeScript strictness, React composition, ESBuild entrypoints/chunks, Sass architecture,
  static asset handling, manifest/cache-busting, and deterministic output to `public/dist/`.
- OpenAPI-generated types/client boundary regenerated from Laravel's own one-pass spec, JSend decoding, runtime
  validation where needed, normalized errors,
  cancellation, retry rules, and generated-contract drift detection.
- Authentication bootstrap, protected routing, in-memory credential handling, single-flight refresh, pending
  request replay/termination, logout/revocation, CSRF/Origin behavior, and safe recovery from refresh reuse.
- Mercure client lifecycle, private-topic authorization, invalidation/refetch, reconnect, credential renewal,
  offline state, and duplicate/missed-message reconciliation.
- Complete responsive and accessible journeys for user self-service plus authorized administration of Users,
  Roles, Permissions, Sessions, Managed Policy, and Agents, including loading, empty, validation, forbidden,
  conflict, not-found, unexpected-error, and recovery states.
- Whether Laravel serves one SPA shell with client routing and how unknown API versus UI routes are separated.
- Limit source adaptations to environment/configuration and Laravel-facing integration; require a drift review for
  substantive UI/application changes against the immutable Symfony source reference.

## Required evidence

- Frontend lint, formatting, strict type checking, focused behavior-rich component tests, and browser journeys
  cover authentication and every required self-service/administrative capability.
- Contract generation from Laravel's own OpenAPI document is reproducible, generated drift fails the gate, and no
  hand-maintained transport types compete with the project-owned specification.
- Two-browser invalidation, reconnect, expired-credential, single-flight refresh, refresh-reuse, forbidden,
  conflict, and accessibility journeys are explicitly assigned to vertical slices.
- Repeated clean builds produce deterministic `public/dist/*`; verification tests production UI behavior and
  uses owning commands/inspection for build configuration rather than tooling meta-tests.

## Resolution boundary

This ticket settles portable client architecture, Symfony-to-Laravel adoption, and complete UX scope. It does
not publish a shared frontend package, copy Symfony server infrastructure, define other framework adoptions,
or implement the SPA during this planning map.

## Resolution

Open. Record the selected frontend baseline and exact Laravel adoption contract here before closing.
