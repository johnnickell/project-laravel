---
id: TICKET-00014
epic: EPIC-00001
title: Define Prospective Acceptance and Administrative Closeout
status: ready-for-agent
blocked_by:
---

# Define Prospective Acceptance and Administrative Closeout

## Problem and outcome

Future delivery needs a clear distinction between independently accepted implementation and subsequent
administrative closeout. Define a prospective contract that preserves applicable acceptance and delivery proof,
requires reassessment when implementation changes, and avoids unnecessary acceptance loops for permitted
administrative changes. Existing accepted TASK contracts and historical findings remain unchanged.

## Scope

- In scope: accepted candidate A and permitted administrative closeout B identities; classification of
  administrative versus implementation changes; evidence applicability and candidate bridges; preservation of
  independent review/QA findings; required hosted/public-contract proof; current handoff reconciliation;
  prospective applicability and explicit stop/owner rules for missing evidence or publication authority.
- Preserve the current local lifecycle, automatic eligible-parent completion, repository gate, live delivery
  checks and human merge boundary. Adopt no weaker proof requirement by implication.
- Out of scope: rewriting historical acceptance contracts or reports; waiving hosted/public-contract proof;
  automatic merge; package publication; provider/harness changes; product behavior; gate-policy reconciliation;
  or rebuilding TASK-00008's delivered routing/delivery synchronization.

## Use cases and contracts

| Use case | Commands | Queries | Events | Expected effects |
| --- | --- | --- | --- | --- |
| Record accepted implementation and administrative closeout | Existing authorized closeout operations; no business command | Candidate A/B identities, diff classification and applicable evidence | N/A: no business fact | Acceptance remains traceable to its subject and closeout is separately identified |
| Detect changes requiring reassessment | Existing review/QA handoff after material changes | Changed behavior, findings and evidence applicability | N/A | Implementation changes cannot inherit an unrelated or stale acceptance |
| Complete delivery under required proof | Existing authorized delivery workflow and owning verification commands | Hosted/public-contract results, current handoffs and publication authority | N/A | Required proof covers the candidate under the approved contract before successful delivery is claimed |
| Stop an uncertain closeout | No publish or successful-closeout assertion | Missing/contradictory proof, subject bridge or authority | N/A | A named evidence/requirement owner receives the exact unresolved input |

## Validation and permissions

Require explicit repository/TASK/candidate identity and an approved applicability bridge where evidence is
reused. A green local gate, `done` status, identical tree, historical report or OPEN PR alone does not establish
all delivery requirements. Preserve findings and history rather than rewriting reports to manufacture a pass.
Literal-final-head requirements cannot be bypassed by assuming an administrative exception; contradictory
requirements need their owner's amendment decision. Public evidence must remain secret-safe.

Business actor/target permissions and payload validation are N/A because no runtime entrypoint is added.
Administrative mutation, publication and merge authority remain distinct. A prospective contract neither
publishes work nor authorizes merge, enrollment, source disclosure or changes to upstream repositories.

## Acceptance and evidence

- [ ] The prospective contract identifies accepted implementation A, administrative closeout B, evidence
      subjects and the explicit authority/applicability boundary without retroactively changing accepted TASKs.
- [ ] Permitted administrative changes and changes requiring independent technical/affected QA reassessment
      are defined; unknown classifications stop for owner reconciliation rather than inheriting acceptance.
- [ ] Independent review/QA identities, verdicts and unresolved findings remain intact. Applicable evidence
      reuse requires the approved subject/bridge; administrative delivery work alone does not invent a new pass.
- [ ] Required hosted/public-contract verification remains explicit and separately evidenced from the local
      build. Fresh B proof uses the exact source head or a verified PR merge candidate with an identical complete
      Git tree and recorded head/base/tested-commit provenance. Stricter explicit source-head requirements win;
      neither metadata-only changes nor tree equality waive verification or establish independent acceptance.
- [ ] Authorized closeout reconciles affected authored and generated handoffs, preserves automatic parent
      completion and live delivery checks, and distinguishes implementation acceptance, publication, merge and
      deployment. No successful landing is claimed while required verification remains incomplete.
- [ ] Direct inspection of representative accepted-A/permitted-B, material-change, missing-proof,
      contradictory-subject and missing-authority scenarios demonstrates the intended continuation or stop.
      Validate through owning commands and review, not product-suite meta-tests or a new receipt/certification system.

## Decisions and dependencies

### Approved prospective closeout policy

The maintainer approved this requirements split and the concrete prospective policy below. Implementation must
make the contract discoverable in the target's planning/delivery guidance; recording it here does not claim that
implementation is complete or alter historical TASK acceptance.

1. **Applicability:** apply to future TASKs that explicitly adopt this contract. Existing TASK contracts,
   historical findings and accepted evidence remain unchanged; publication authority alone cannot amend them.
2. **Accepted candidate A:** require the canonical local gate, independent technical acceptance, applicable QA
   satisfied or justified overall N/A, and required hosted/public-contract acceptance proof. All applicable
   acceptance criteria must be accounted for before tracked completion records A's acceptance. The adopted
   contract retains hosted verification; it does not import an optional-CI default.
3. **Administrative closeout B:** allow only truthful completion/review/PR metadata, factual current-handoff
   updates and regenerated views. Requirements, executable instructions, code, dependencies and behavioral
   changes are not administrative. Record `done` for accepted A with required QA complete, not as a claim that
   B's publication or final delivery checks passed. Synchronize eligible parents and authored/generated current
   handoffs in the same closeout, preserving dependencies and historical evidence.
4. **Hosted proof:** require fresh proof attributable to B before successful landing or owned-resource cleanup.
   Accept an exact source-head run, or a verified PR merge candidate whose complete Git tree equals that source
   head. Record repository, run URL/event, source head/base, actual tested commit, tree equality where used,
   required job conclusions and warnings. A stricter explicit source-head requirement wins. A's run cannot
   stand in for B; a stale, wrong-subject or skipped required run is not proof. Tree equality alone does not
   replace independent acceptance or establish a mechanical-reconciliation bridge.
5. **Continuation and evidence:** Land verifies A-to-B scope and any mechanical-reconciliation bridge against
   the shared contract, preserving canonical independent Review/QA reports and findings. Record delivery results
   in ignored landing evidence and the actual PR body. No additional independent review or canonical report
   update is required solely for permitted administrative changes, changed commit IDs or newly available CI.
   Semantic changes, uncertain integration or unknown classifications stop for reassessment; demonstrated defects
   route to repair, fresh independent review and affected QA rather than a Land implementation fix.
6. **Missing/failed proof:** queued, unavailable or infrastructure-failed required delivery proof leaves the PR
   draft and resources retained, with the exact prerequisite/action. Do not toggle accepted status just to track
   external run state. An implementation defect invalidates applicable acceptance and requires reopening/repair
   under the authorized implementation workflow. Preserve original evidence and consumed revision allowance.
7. **Finite finish:** A to accepted A to permitted B to verified B to ownership-proven cleanup. No tracked
   "CI passed" commit is needed after B succeeds; tracked wording remains a truthful closeout checkpoint pointing
   to live delivery evidence. Any later commit moves the delivery candidate and needs its own applicable proof.
   Human review/merge remains separate; no automatic approval, merge, release, archive or deployment follows.

The shared `docs/engineering/LANDING.md`, `REVIEW.md` and `QA.md` contracts were inspected when settling this
policy. Use their provenance, independence and mechanical-reconciliation rules with the target substitutions;
do not treat existing TASK-00006's identical-tree clarification as a blanket retrospective exception.

Canonical evidence identity and resolution are accepted in [TICKET-00013](00013-TICKET.md), including its approved
Agent OS naming migration. Implement these coordinated requirements without introducing a dependency cycle. No hard
implementation ordering between these two requirements is approved by the split. Existing accepted contracts,
including TASK-00001 and TASK-00006, are provenance/examples, not automatic templates for future exemptions.
[TICKET-00007](00007-TICKET.md)/[TICKET-00011](00011-TICKET.md) retain the separate unresolved gate policy.

The explicit foundation slice leaves the broader [API/SPA map](../wayfinder/complete-access-control-api-and-spa-map.md)
Active with open decisions and WF-001 as its authored first frontier. No broader map decision or EPIC destination
is resolved by creating this requirement.

## TASKs

<!-- planning:children -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [TASK-00011](../tasks/00011-TASK.md) | Adopt Prospective Acceptance and Closeout Rules | ready-for-agent | [TICKET-00014](00014-TICKET.md) | — |
<!-- /planning:children -->

## Progress

The maintainer accepted the requirement, prospective policy and complete single-TASK plan:
[TASK-00011](../tasks/00011-TASK.md) owns the authoritative local contract, entrypoint/template references and
independent normal/failure walkthroughs. It has no TASK blockers; TICKET-00013's accepted report conventions do not
require its implementation first. Board order leaves TASK-00009 first without inventing a dependency.

Status remains `ready-for-agent`: implementation has not started. The single TASK covers every accepted
requirement criterion; no additional child decomposition is pending in this approved split. TASK-00011 explicitly
adopts this prospective contract for its own acceptance/delivery without amending historical TASKs. The selected
TICKET-00013/TICKET-00014 adoption slice now has complete accepted TASK plans; consult the TASK Board for execution.
The broader API/SPA map remains Active with unresolved decisions and an unfinished EPIC handoff.

No implemented closeout changes, independent implementation acceptance, historical-contract amendments,
waiver of proof or publication are claimed. Parent completion remains pending the child's verified acceptance.
