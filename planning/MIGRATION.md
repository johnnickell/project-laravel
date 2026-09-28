# Complete planning migration — 2026-09-28

The maintainer explicitly requested conversion/renaming of **all non-archived planning records**, correcting the
initial partial migration that exempted live executable tickets. This document is an identity/provenance map,
not another planning hierarchy or execution frontier. [CONVENTIONS.md](CONVENTIONS.md) remains the authority.

## Source snapshots and authority

- Original portfolio plus initial partial migration: reviewed feature commit
  [`7bdd91a590f657eaa4906ddd5c98e3a26a193dd9`](https://github.com/johnnickell/project-laravel/tree/7bdd91a590f657eaa4906ddd5c98e3a26a193dd9/planning).
- Concurrent legacy-format lean-gate requirement: develop PR #9 / merge
  [`b1d540c0170e7aa686793b5047f768715aaa0079`](https://github.com/johnnickell/project-laravel/tree/b1d540c0170e7aa686793b5047f768715aaa0079/planning).
- Correction is published in [draft PR #10](https://github.com/johnnickell/project-laravel/pull/10), using a
  non-rewriting merge of develop. It does not change runtime code, dependencies, or the build/CI contract.
- No planning archive directories/records existed at intake; none is created by this migration. Completed live
  records are converted, not archived or deleted as obsolete history. Future archive operations remain explicit.

## Identity and ownership mapping

| Previous live record | Current authority | Preserved state / evidence |
| --- | --- | --- |
| PRD-00001 `specs/00001-PRD.md` | [EPIC-00002](epics/00002-EPIC.md) | Completed foundation destination/decisions; T-00001 remains its requirement |
| PRD-00002 `specs/00002-PRD.md` | [EPIC-00003](epics/00003-EPIC.md) | In-progress version adoption destination, historical evidence and unresolved Common 2.0 |
| Executable T-00001 | [T-00001](tickets/00001-TICKET.md) → [TASK-00002](tasks/00002-TASK.md) | Requirement remains done; original implementation body/evidence moved to done TASK |
| Executable T-00002 | [T-00002](tickets/00002-TICKET.md) → [TASK-00003](tasks/00003-TASK.md) | Original candidate identities, hashes, acceptance and test counts retained in done TASK |
| Gated T-00003 | [T-00003](tickets/00003-TICKET.md), parent EPIC-00003 | Still needs-info; no executable TASK invented before upstream authority exists |
| Executable T-00004 | [T-00004](tickets/00004-TICKET.md) → [TASK-00004](tasks/00004-TASK.md) | Original detailed acceptance, PR #7 provenance and hosted run retained in done TASK |
| Executable T-00005 | [T-00005](tickets/00005-TICKET.md) → [TASK-00005](tasks/00005-TASK.md) | Original tree-equivalence mapping and historical recertification retained in done TASK |
| Develop-side T-00006, lean gate (PR #9) | [T-00011](tickets/00011-TICKET.md), parent EPIC-00001 | Full scope/exclusions/unchecked acceptance retained; needs-info for conflict with T-00007 |
| Feature-side T-00006, package adoption | [T-00006](tickets/00006-TICKET.md) → [TASK-00001](tasks/00001-TASK.md) | Identities retained; in-progress parent / ready-for-human TASK, hosted/review acceptance still open |
| T-00007 successor gate | [T-00007](tickets/00007-TICKET.md) | Needs-info while reconciling the newly integrated T-00011 policy, not silently superseded |
| EPIC-00001, T-00008–T-00010 | Existing destinations/requirement records | Ownership, dependency edges and unresolved journey/policy decisions retained |
| `tickets/BOARD.md` | [tasks/BOARD.md](tasks/BOARD.md) | Old execution board removed; exactly one current execution frontier |

PRD-00001 and PRD-00002 are **retired aliases**, not reusable identifiers. The next optional PRD is PRD-00003.
Original text remains addressable at the immutable source snapshots above. T-00001–T-00005 retain their IDs as
requirements; their implementation evidence has explicit new TASK identities. The colliding develop-side T-00006
is disambiguated by source commit/title and mapped to T-00011, not mistaken for the feature-side package work.

## Whole-portfolio classification

- All EPIC/TICKET/TASK records now use the same parent/readiness rules. There is no live legacy exception in
  instructions, validation, indexes or archive traversal. All parent child-tables are generated normally.
- Old top-level destination PRDs became EPICs; `specs/` remains available for **optional supporting** PRDs, with
  its template/index but no remaining destination masquerading as an optional specification.
- Wayfinder's active map, nine open `WF-*` decisions and bounded package-contract handoff already occupy the
  separate investigation structure. Their identities, links, decision state and frontier remain unchanged;
  moving them into executable TASKs would falsely approve unresolved work.
- ADRs, focused agent guidance, templates, indexes, conventions and Roadmap remain in their defined support
  locations; they are not EPICs or executable records. Guidance and generated views are updated to remove the
  legacy exemption and route solely to the TASK Board.
- Archive traversal follows normal EPIC → TICKET → TASK descendants and optional PRD links. No archive apply is
  performed and no product test is added to certify planning tooling.

## Decisions preserved, not silently resolved

T-00011 requires exact Unit-only coverage, CoversClass/CoversNothing annotations and installed FightCommon PHPCS
rules, and removes clean production-install inspection. T-00007 calls for all-suite coverage with separately
reported unit evidence, compatible local PHP rules, and explicit CI setup/start/cleanup. Both requirement sets
remain visible. Their owner must settle the final proving/CI contract before gate TASK decomposition. This
migration neither lowers a quality threshold nor applies unapproved new criteria to TASK-00001.

Common 2.0 remains needs-info under T-00003; the API/SPA map remains Active with WF-001 as frontier. Existing
completed delivery evidence is inherited history, not fresh verification or a reconstructed independent review.
The original TASK-00001 review remains `revise` for its original head. The planning correction changes the
reviewed scope and therefore requires fresh independent review, even if hosted CI becomes green.
