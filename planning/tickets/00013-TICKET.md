---
id: TICKET-00013
epic: EPIC-00001
title: Bind Shared Engineering Workflows to Laravel
status: in-progress
blocked_by:
---

# Bind Shared Engineering Workflows to Laravel

## Problem and outcome

Shared engineering workflows need an explicit repository-local contract so maintainers and agents can resolve
Laravel's planning identities, supported operations, engineering exceptions and canonical evidence without
guessing paths or importing another application's implementation. This requirement covers the remaining
workflow-binding portion of EPIC-00001's approved broad-adoption amendment, not its already delivered slices.

## Scope

- In scope: adoption of Agent OS's `EPIC-NNNNN`, `TICKET-NNNNN` and `TASK-NNNNN` identities with numeric
  `NNNNN-EPIC.md`, `NNNNN-TICKET.md` and `NNNNN-TASK.md` filenames; coherent migration of current `T-` ticket
  identities, references, templates and planning/archive tooling; Board and Wayfinder entrypoints; supported
  implementation/review/QA/delivery capabilities; Laravel/Eloquent/Pint and `App\` mapped to `app/` exceptions;
  repository-owned commands; canonical report locations and repository/TASK/candidate identity; representative
  workflow handoffs and current local instructions.
- Preserve package Domain/Application ownership, exact owned-production coverage, required hosted/public-contract
  proof, the current lifecycle and existing verification gate until an approved replacement lands.
- Out of scope: copying shared skills or private source; provider/harness changes; changing numeric record
  suffixes or reusing identities; enrollment/source disclosure; global installation; successor-gate implementation; product
  endpoints; and reimplementing standalone-bug support or routing/delivery synchronization already delivered by
  TASK-00007 and TASK-00008.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Adopt shared planning names | Owning planning/archive commands; no business command | Live/archived identities, links, templates and generated views | N/A: planning maintenance | TICKET-prefixed identities resolve consistently without losing numeric identity, dependencies or history |
| Resolve the local work and next stage | Existing supported workflow invocations; no new business command | Board/Wayfinder and record metadata | N/A: no business fact | A handoff uses adopted identities and an available capability without implying execution authority |
| Apply shared engineering guidance locally | Repository-owned verification and lifecycle commands | Local exceptions and owning guidance | N/A: operational guidance | Laravel-native boundaries and the authoritative gate are preserved |
| Locate and validate a report handoff | Existing review/QA/delivery workflows | Canonical report identity, assessed candidate, verdict and continuation | N/A: evidence lookup | Evidence matches the repository, TASK and applicable subject; ambiguity stops the route |

## Validation and permissions

Validate identities and capability availability rather than assuming provider defaults match this repository.
Specify canonical evidence resolution across the main checkout and worktrees without scanning unrelated private
runs. Missing reports, stale subjects, contradictory findings and unsupported invocations need an explicit owner
handoff, not an inferred pass. Do not expose secrets or private evidence in public planning or logs.

Business actors, target permissions and payload validation are N/A: no product entrypoint is introduced.
Repository mutation and publication still require the selected workflow's authority; a binding or recommendation
grants neither. Keep shared skills with their provider and consume Fight packages through public contracts.

## Acceptance and evidence

- [ ] A maintained binding at `planning/agents/workflow-binding.md`, explicitly linked from root AGENTS.md,
      identifies planning paths, EPIC/TICKET/TASK semantics, routing sources, supported capabilities and shared
      guidance without duplicating provider skills or hardcoding a private provider installation.
- [ ] Ticket identities adopt `TICKET-NNNNN` throughout authoritative live/archived metadata, parent/blocker
      edges, templates, current references, generated views and planning/archive tooling in a coherent migration.
      Existing numeric filenames already match Agent OS and stay unchanged. Preserve suffixes, gaps, historical
      evidence and old-to-new identity provenance; distinguish historical quotations from current instructions.
- [ ] Laravel/Eloquent/Pint, native entrypoints, `app/`, package boundaries, repository-owned commands, cache
      placement, coverage and hosted-proof requirements are explicit; unresolved successor-gate policy is not
      silently decided by adopting provider defaults.
- [ ] Canonical review/QA paths, shared Review v3 and QA v1 formats, repository/TASK/requirements/candidate
      identity, worktree resolution, independent ownership and applicable subject/bridge rules implement the
      approved conventions below. Missing, stale or contradictory evidence stops safely; no report is rewritten
      by the builder or Land to manufacture acceptance.
- [ ] Representative implementation-to-review, review-to-QA and QA-to-delivery handoffs resolve correctly under
      the binding, including unavailable capability and stale/mismatched evidence cases. Check directly through
      owning commands and inspection, not product-suite tests of planning, reports or configuration.
- [ ] Current local entrypoints and handoffs consistently reference the binding, preserve already delivered
      safeguards and distinguish availability, recommendation, workflow authority and actual acceptance.

## Decisions and dependencies

### Approved naming, binding and report conventions

The maintainer approved the concrete conventions below in the decomposition conversation, with one explicit
correction: adopt Agent OS's file/identity naming conventions rather than preserving local `T-` identities.
These are accepted implementation requirements, not a claim that migration or binding implementation exists.

- **Naming:** adopt `TICKET-NNNNN` with `planning/tickets/NNNNN-TICKET.md`, alongside the already matching
  EPIC/TASK names. Preserve each numeric suffix and identity history; do not allocate replacement numbers.
  Migrate authoritative records, references and tooling together, including any archived records. Record the
  mapping from `T-NNNNN` to `TICKET-NNNNN` and classify retained historical text rather than rewriting evidence.
  This supersedes the earlier preserve-`T-` direction. TASK-00009 now implements the coherent migration;
  independent acceptance and required hosted proof remain pending. Do not introduce old-prefix aliases into
  authoritative metadata.
- **Binding owner/location:** the project planning owner maintains `planning/agents/workflow-binding.md`;
  root AGENTS.md explicitly links it. Shared workflow/report rules stay with the provider. Resolve exact provider
  resources from harness/operator-supplied skill metadata, not guessed paths, copied catalogs or global changes.
- **Capabilities:** bind routing/planning and Work, Review, QA and Land to their provider-owned skills; use
  `TASK-NNNNN` inputs for Build coordination. Check actual availability at invocation. A missing capability
  causes a named prerequisite hold, not silent fallback, a new installation or an expanded authority grant.
- **Laravel substitutions:** retain Laravel/Eloquent/Pint, native entrypoints, `App\` mapped to `app/`, MySQL
  direction, repository commands, `var/cache/`, exact owned-production coverage and existing hosted/public-contract
  requirements. TICKET-00007/TICKET-00011 still own disputed successor-gate policy; provider defaults cannot settle it.
- **Canonical base:** resolve the main/base worktree using Git's common directory and registered worktrees,
  not the selected disposable checkout or a matching TASK number in another repository. Ambiguous/unwritable
  base or unsafe symlink resolution is an incomplete handoff, not permission to choose another canonical path.
- **Report paths/formats:** use `<base>/.runs/reviews/<TASK-ID>/review.md` with shared Review v3 and
  `<base>/.runs/qa/<TASK-ID>/qa.md` with shared QA v1. Identify repository, TASK, requirements revision, full
  base/head OIDs, working-tree state, independence and findings. Match the report and any provenance bridge to
  the claimed subject; only the current canonical report owns the latest verdict. Legacy valid reports remain
  evidence under shared compatibility rules; no forced historical schema conversion is authorized.
- **Storage/ownership:** keep canonical evidence outside disposable worktrees. Review and QA own their respective
  independent reports; preserve history, coordinate one canonical writer, publish atomically and verify read-back.
  QA keeps per-run evidence under its TASK directory according to the shared contract. Land does not edit those
  reports. Document `.runs/reviews/`, `.runs/qa/` and provider-owned `.runs/build/` coordination as explicit
  exceptions to dated scratch; keep all ignored and preserve the existing Build ledger/revision allowance.

Applicable shared contracts were inspected at provider resources `docs/engineering/PROJECT_CONTEXT.md`,
`REVIEW.md`, `QA.md`, `QA_REPORT_TEMPLATE.md` and `.pi/skills/build/SKILL.md`; provider planning conventions
confirm numeric filenames and `TICKET-NNNNN` identities. Resolve these from the actual supplied provider when
implementing; resource names here do not select a target checkout.

Coordinate evidence identity with [TICKET-00014](00014-TICKET.md). Neither requirement needs the other's
implementation merely to settle its requirements, so no new execution dependency is imposed here.
[TICKET-00012](00012-TICKET.md)'s package upgrade and standalone TASK-00007/TASK-00008 are delivered context,
not unfinished blockers. [TICKET-00007](00007-TICKET.md)/[TICKET-00011](00011-TICKET.md) retain gate-policy ownership.

This is an explicitly selected foundation slice under [EPIC-00001](../epics/00001-EPIC.md), not approval of the
complete [API/SPA map](../wayfinder/complete-access-control-api-and-spa-map.md). That map remains Active with
open decisions and WF-001 as its authored first frontier; its broader decisions and EPIC handoff are not closed
or bypassed by this decomposition.

## TASKs

<!-- planning:children -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [TASK-00009](../tasks/00009-TASK.md) | Adopt Agent OS Planning Identities | done | [TICKET-00013](00013-TICKET.md) | — |
| [TASK-00010](../tasks/00010-TASK.md) | Bind Laravel Workflows and Canonical Evidence | ready-for-agent | [TICKET-00013](00013-TICKET.md) | [TASK-00009](../tasks/00009-TASK.md) |
<!-- /planning:children -->

## Progress

Requirements and the complete two-TASK decomposition are accepted by the maintainer. Status remains
`in-progress`: TASK-00009's coherent identity/tooling migration and approved default-Build routing clarification
are independently accepted, with QA PASS and required A hosted proof; its separate PR delivery is tracked at
[PR #18](https://github.com/johnnickell/project-laravel/pull/18). Numeric filenames and relationships are
preserved. This completion does not claim TASK-00010's binding or TICKET-00014's general rollout.

- [TASK-00009](../tasks/00009-TASK.md) delivered the complete identity/reference/tooling migration and its naming,
  provenance, hierarchy and routing evidence; its current `delivery: awaiting-merge` marker identifies PR #18.
- [TASK-00010](../tasks/00010-TASK.md) owns the remaining binding, Laravel substitutions, canonical reports,
  evidence storage and handoff walkthroughs; it is now unblocked and remains unfinished.

Together these cover all accepted requirement criteria; no additional child slice is pending in this approved
split. Both explicitly adopt TICKET-00014's prospective contract for their own acceptance/delivery without implementing
its repository-wide rollout. TICKET-00014's complete single-TASK plan is now approved as TASK-00011. The selected
adoption slice has complete accepted TASK plans; consult the TASK Board for execution. The broader API/SPA map
remains Active and its earlier unfinished decisions/EPIC handoff are not completed by this foundation slice.
TASK-00010's binding and TASK-00011's general closeout rollout remain unimplemented. No provider changes are
claimed. Parent completion remains pending TASK-00010's verified acceptance; its former TASK-00009 blocker is
preserved as delivered provenance, not a current readiness hold.
