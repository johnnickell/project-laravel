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

## Agent OS ticket identity migration

TASK-00009 implements the maintainer-approved prefix migration from `T-NNNNN` to `TICKET-NNNNN`.
The preceding September migration narrative and tables are preserved verbatim as a historical checkpoint,
including their then-current statuses and names; they are not today's identity or review authority.
The table below resolves the adopted identities. [The Board](tasks/BOARD.md) owns current execution and
owning records retain acceptance evidence. Implementation awaits independent Review, applicable QA and
required hosted proof; no new acceptance is inferred from a renamed identity.

### Identity map

| Former requirement ID | Adopted requirement ID | Unchanged numeric filename |
| --- | --- | --- |
| T-00001 | [TICKET-00001](tickets/00001-TICKET.md) | `00001-TICKET.md` |
| T-00002 | [TICKET-00002](tickets/00002-TICKET.md) | `00002-TICKET.md` |
| T-00003 | [TICKET-00003](tickets/00003-TICKET.md) | `00003-TICKET.md` |
| T-00004 | [TICKET-00004](tickets/00004-TICKET.md) | `00004-TICKET.md` |
| T-00005 | [TICKET-00005](tickets/00005-TICKET.md) | `00005-TICKET.md` |
| T-00006 | [TICKET-00006](tickets/00006-TICKET.md) | `00006-TICKET.md` |
| T-00007 | [TICKET-00007](tickets/00007-TICKET.md) | `00007-TICKET.md` |
| T-00008 | [TICKET-00008](tickets/00008-TICKET.md) | `00008-TICKET.md` |
| T-00009 | [TICKET-00009](tickets/00009-TICKET.md) | `00009-TICKET.md` |
| T-00010 | [TICKET-00010](tickets/00010-TICKET.md) | `00010-TICKET.md` |
| T-00011 | [TICKET-00011](tickets/00011-TICKET.md) | `00011-TICKET.md` |
| T-00012 | [TICKET-00012](tickets/00012-TICKET.md) | `00012-TICKET.md` |
| T-00013 | [TICKET-00013](tickets/00013-TICKET.md) | `00013-TICKET.md` |
| T-00014 | [TICKET-00014](tickets/00014-TICKET.md) | `00014-TICKET.md` |

All 28 EPIC/TICKET/TASK records remain live; no archive records existed at TASK-00009 intake. The 14 ticket
suffixes, all 11 TASKs, three EPICs, dependency edges, numeric filenames and optional-PRD behavior are preserved.
Only TASK-00009 and its unfinished parent TICKET-00013 move to `in-progress` for this implementation.
The older develop-side lean-gate `T-00006` collision still resolves by source commit/title to TICKET-00011,
not TICKET-00006. Retired PRD aliases and all allocation gaps remain reserved. Old ticket spellings are not
validator aliases and must not be used in new metadata, blockers, templates or archive selections.

### Occurrence and reference classification

| Class | Locations / treatment |
| --- | --- |
| Authoritative current identities | All ticket frontmatter, TASK parents, requirement blockers, templates, indexes, generated child/frontier/Board/Roadmap views and owning planning parser use `TICKET-`. Archive selection already reads metadata IDs and parent fields; its implementation and numeric file selection remain unchanged. |
| Current authored references | Root README/CONTEXT, planning entrypoints/conventions, current record requirements/progress, the active Wayfinder map, current package handoff and WF-002 use adopted IDs. Local references in older evidence resolve through this map, not a second identity scheme. |
| Immutable historical acceptance and results | TASK-00001 and TASK-00006 completion sections; TASK-00002–TASK-00005 original Outcome-through-completion bodies; TASK-00007/TASK-00008 delivered bodies; EPIC-00001's accepted TASK-00001/package-delivery checkpoints; EPIC-00003's historical delivery paragraphs; and the original Common 1.2/AccessControl 0.4 handoff body retain old spellings and original hashes/counts/commands. No historical `done`, report or hosted result becomes a fresh pass. |
| Migration/source provenance | The September narrative above; TASK-00002–TASK-00005 “Migrated from” source names; TICKET-00011/EPIC-00003 collision descriptions; EPIC-00001's develop-PR-9 collision checkpoint; naming-policy explanations in conventions/TICKET-00013/TASK-00009 retain former IDs explicitly as former names. Current locators beside them use adopted IDs. |
| External repository identities | Fight Common's `T-00087` citations in TASK-00004, TICKET-00011 and EPIC-00003 remain unchanged: they name upstream records, not this repository's requirements. External URLs, immutable source snapshots, independent-report identities and historical machine paths are not rewritten. |

The ignored TASK-owned implementation evidence contains before/after line-level occurrence and relationship
inventories, byte-preservation checks for historical blocks, direct owning-command results and disposable
parent/readiness/archive probes. These are implementation evidence, not independent QA or a product-suite
certification mechanism. No real archive operation is performed. Current parser/consumer checks reject the old
metadata prefix; refresh is idempotent and live delivery behavior remains separate from offline validation.
