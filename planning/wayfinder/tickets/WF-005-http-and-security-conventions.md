# HTTP and security conventions

**Labels:** `wayfinder:grilling`, `area:security`, `area:http`
**Mode:** HITL
**Status:** Open
**Gate:** Symfony authentication contract
**Map:** [Complete Laravel AccessControl API and SPA](../complete-access-control-api-and-spa-map.md)
**Depends on:** [WF-002](WF-002-access-control-capability-inventory.md), [WF-003](WF-003-openapi-and-release-handshake.md), [WF-004](WF-004-persistence-and-transaction-model.md)

## Question

What Laravel-native HTTP and security composition implements the approved AccessControl capabilities with
consistent authentication, authorization, validation, CQRS dispatch, and JSend responses?

## Must decide

- JWT issuer/audience/subject and authorization claims, signing and verification key configuration, access
  lifetime, clock skew, revocation checks, and the boundary between JWT identity and authoritative state.
- Refresh transport and rotation, cookie attributes where used, CSRF and Origin policy, logout/revocation, reuse
  response, and behavior when credentials expire or policy changes mid-session.
- Global and route middleware ordering for trusted proxies/hosts, CORS/Origin, content negotiation, request IDs,
  authentication, throttling, validation, authorization, transaction scope, and exception handling.
- Named `/api/v1/access/*` routes and container-resolved single-action handlers. Each operation pairs an
  invokable Action with its named Responder, including `InvitePendingUserAction` →
  `InvitePendingUserResponder`; Actions translate transport input into package commands/queries and Responders
  alone own HTTP presentation.
- Form Request or equivalent validation conventions, authorization policy/gate boundaries, resource lookup
  order that avoids information leaks, idempotency where required, and conflict semantics.
- Central exception-to-JSend mapping for validation, unauthenticated, forbidden, missing resource, conflict,
  throttling, unavailable dependency, and unexpected failure responses, including safe logging/correlation.
- Which browser requests use bearer credentials versus protected cookies, and how the choice composes with the
  SPA bootstrap and refresh flow.
- Short-lived access tokens remain in client memory; rotating refresh credentials remain in Secure, HttpOnly
  cookies; cookie-backed operations require CSRF/Origin defenses; reuse, revocation, expiry, and concurrent rotation
  fail closed; authentication is rate-limited and secret-bearing logs are forbidden.

## Required evidence

- HTTP tests cover every operation's success envelope plus validation, authentication, authorization, conflict,
  missing-resource, throttling where applicable, and sanitized unexpected-failure behavior.
- Security tests prove JWT claim enforcement, expiry, revocation, refresh rotation/reuse response, CSRF and
  Origin policy, route-level authorization, local dashboard/spec restrictions, and information-leak resistance.
- Structural or behavior-focused checks enforce one named Action/Responder pair per operation without testing
  route/configuration text as an end in itself.
- The design maps each operation to its CQRS command/query, persistence transaction, audit result, and
  post-commit side effects.

## References

- [Laravel controllers and single-action handlers](https://laravel.com/framework/docs/13.x/controllers)

## Resolution boundary

This ticket settles inbound HTTP and browser security composition. Inbound Agent HMAC authentication, MCP,
worker retry policy, realtime channel mechanics, and production dashboard authorization remain outside it.

## Resolution

Open. Record the complete middleware, auth, route, handler, and exception conventions here before closing.
