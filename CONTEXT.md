# Project context

Fight Laravel Starter is a public-source, Laravel-native application consumer of Composer packages Fight Common
and Fight AccessControl. It is not their implementation home or a framework-support certification profile.
Laravel owns providers, routing, HTTP, security integration, persistence, queues, presentation, and operations.
Package Domain/Application behavior remains upstream-owned.

The lock selects Common `v1.4.0` at `87b9580c072f3149d574e09865daa79620c92118` and AccessControl `v0.8.0` at
`319738255e682d587642b67856039f882b9588d6`, with constraints `^1.4` and `^0.8` and PHP `^8.5`. Both are published
Packagist releases; lock and installed metadata agree. See the
[current installed contract handoff](planning/wayfinder/fight-package-baseline-1.4-0.8.md) for inspected signatures,
breaking pre-v1 migration boundaries and outstanding advisories in unchanged third-party dependencies.

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
production boot. TICKET-00007 owns the separate approved transition to a thin running-Compose wrapper and PHP
orchestrator. TICKET-00007 and the migrated develop-side TICKET-00011 must reconcile their coverage/CI requirements before
gate implementation. Historical receipts and prior success claims in migrated TASK records are historical only.
All live planning now uses EPIC → TICKET → TASK; `planning/MIGRATION.md` traces the converted identities.

EPIC-00001's 2026-10-24 amendment approves broad Agent OS adoption with narrow Laravel exceptions. TASK-00006's
current-package upgrade is delivered and merged through PR #13 at `3fa576d`; its owning completion notes retain
review/QA acceptance and hosted-delivery provenance. Integrated TASK-00007 supplies standalone-bug planning support
and patched container baselines, without implementing the successor gate.

Historical delivery-tooling checkpoint: the mechanism described in the next paragraph is retired under the
current [publication-closeout contract](planning/CONVENTIONS.md#publication-closeout). Preserve its acceptance/
publication evidence, not its former active queue or reconciliation duties. Land now closes accepted TASK/current
docs, validates the exact live own PR and retires eligible owned local resources during delivery; human merge
remains separate without recurring post-merge planning work.

TASK-00008 delivered bounded planning synchronization through PR #15, merged at `54a071d`:
generated Board/Roadmap current TASK summaries, explicit
`delivery: awaiting-merge` markers, and `./bin/planning-check --check-delivery` for read-only live handoff checks.
The build's fail-fast planning check remains offline. TASK-00012 implements Fight Common's corrected read-only
resolution of exact merged/integrated done publication snapshots and explicit, evidence-preserving
`--reconcile-delivery` at authorized Work/Land/substantive planning intake. Its implementation is independently
accepted with behavioral QA PASS; the TASK's completion checkpoint preserves candidate/report provenance.
Current publication state is tracked separately by the generated Board delivery section and actual PR body.
Normal human merge no longer requires a routine cleanup request. Closed-unmerged, uncertain or unintegrated
handoffs remain blocking. Local [delivery pre-submit](planning/CONVENTIONS.md#delivery-pre-submit-and-final-handoff)
requires Land to reconcile affected authored handoffs as well as generated views; human merge remains separate.
These safeguards do not complete broader workflow adoption or change acceptance/hosted-proof requirements.
The remaining adoption requirements split is approved in
[TICKET-00013](planning/tickets/00013-TICKET.md) (workflow/evidence binding) and
[TICKET-00014](planning/tickets/00014-TICKET.md) (prospective closeout). Their concrete conventions are accepted;
TICKET-00013's complete plan is approved in [TASK-00009](planning/tasks/00009-TASK.md) (naming migration) and
[TASK-00010](planning/tasks/00010-TASK.md) (workflow/report binding, dependent on TASK-00009). TICKET-00014's complete
single-TASK plan is approved as [TASK-00011](planning/tasks/00011-TASK.md), with no TASK blockers. The selected
adoption slice has complete accepted TASK plans; the Board owns execution. TASK-00009 delivered the
maintainer's coherent Agent OS naming migration: `TICKET-NNNNN` identities with unchanged numeric
`NNNNN-TICKET.md` filenames, relationships and classified historical provenance. It also delivered the approved
local default-Build recommendation for new implementation and confirmed defects, with Work reserved for explicit
implementation-alone requests. Independent Review accepted A, applicable QA passed, and required hosted proof
is recorded; PR #18 merged into develop at `8b372b3` and its published head/merge/local-integration evidence is
retained in TASK-00009's delivery reconciliation. Its ended marker is retired. TICKET-00013 stays in progress because
TASK-00010's full binding is unimplemented; TASK-00011's general closeout rollout also remains unimplemented.
The naming migration does not complete those requirements.
The existing lifecycle and gates remain authoritative until approved replacements land. No provider change, harness enrollment or
global installation is implied.
