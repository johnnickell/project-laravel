# Project context

Fight Laravel Starter is a public-source, Laravel-native application consumer of Composer packages Fight Common
and Fight AccessControl. It is not their implementation home or a framework-support certification profile.
Laravel owns providers, routing, HTTP, security integration, persistence, queues, presentation, and operations.
Package Domain/Application behavior remains upstream-owned.

The lock selects Common `v1.2.0` at `a2cd615d9b5064c9c30e994655536176249cd73b` and AccessControl `v0.4.0` at
`380b134b35c722e6416787b13f5c20c64bd05388`, with constraints `^1.2` and `^0.4` and PHP `^8.5`. Both are published
Packagist releases; no development alias or candidate-warning exception remains. See the
[installed contract handoff](planning/wayfinder/fight-package-baseline.md) for inspected signatures and limits.

The application currently serves the HTML homepage. Retained Fight integration is deliberately bounded to the
Laravel default transaction connection and existing fail-closed JWT/HMAC credential selection. These primitives
are not a complete authentication or authorization system: there are no protected AccessControl API routes,
principal repositories, session/revocation integration, or persistent HMAC replay prevention. The future shared
permission boundary and Eloquent/MySQL use cases remain requirements under EPIC-00001.

Support receipts, lowest/latest certification lanes, complete-provider inventories, and upstream-only/meta-tests
are retired. Product tests cover the homepage, application credential rejection/key selection/time tolerance,
and transaction commit/rollback on the SQLite test connection. Exact statement coverage still includes all of
`app/`; integration coverage is not presented as unit coverage or MySQL/durable-delivery evidence.

`./bin/build` remains the existing self-provisioning local/hosted gate, minus certification. It still builds
images, installs locked dependencies, runs quality tools/application tests, compiles the frontend, and verifies
production boot. T-00007 owns the separate approved transition to a thin running-Compose wrapper and PHP
orchestrator. T-00007 and the migrated develop-side T-00011 must reconcile their coverage/CI requirements before
gate implementation. Historical receipts and prior success claims in migrated TASK records are historical only.
All live planning now uses EPIC → TICKET → TASK; `planning/MIGRATION.md` traces the converted identities.
