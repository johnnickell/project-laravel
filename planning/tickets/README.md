# TICKETs

New TICKETs group related use cases, requirements, permissions, and observable acceptance evidence under an
EPIC. They are not implementation assignments or normally single PRs. Accepted, decision-complete requirements
are decomposed into [TASKs](../tasks/README.md). Use the [TASK Board](../tasks/BOARD.md) for execution order.

The five-ticket split under EPIC-00001 is approved. T-00006's release baseline and single-TASK plan are now
accepted. Remaining policy, persistence, and journey choices stay visible as `needs-info`; the original split
approval alone does not establish TASK readiness.

## Requirements

<!-- planning:requirements -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [T-00006](00006-TICKET.md) | Adopt Current Fight Packages as an Application Consumer | in-progress | [EPIC-00001](../epics/00001-EPIC.md) | — |
| [T-00007](00007-TICKET.md) | Verify the Application Through a Running Compose Stack | ready-for-agent | [EPIC-00001](../epics/00001-EPIC.md) | [T-00006](00006-TICKET.md) |
| [T-00008](00008-TICKET.md) | Enforce Shared Application Permission Policy | needs-info | [EPIC-00001](../epics/00001-EPIC.md) | [T-00006](00006-TICKET.md) |
| [T-00009](00009-TICKET.md) | Persist Authoritative AccessControl State and Required Effects | needs-info | [EPIC-00001](../epics/00001-EPIC.md) | [T-00006](00006-TICKET.md), [T-00008](00008-TICKET.md) |
| [T-00010](00010-TICKET.md) | Deliver a Real Permission-Protected API Slice | needs-info | [EPIC-00001](../epics/00001-EPIC.md) | [T-00007](00007-TICKET.md), [T-00008](00008-TICKET.md), [T-00009](00009-TICKET.md) |
<!-- /planning:requirements -->

## Legacy executable tickets

Only T-00001 through T-00005 retain their PRD-linked executable-ticket meaning. IDs, statuses, bodies, and
historical verification are preserved, with no retrospective TASKs. [BOARD.md](BOARD.md) is their retained legacy
snapshot, not a current execution frontier. Resume unfinished legacy scope only through an explicit new
EPIC-linked requirement, as described in [planning conventions](../CONVENTIONS.md#legacy-records-and-migration).

<!-- planning:legacy -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [T-00001](00001-TICKET.md) | Establish the Canonical Full-Stack Laravel Starter Foundation | done | [PRD-00001](../specs/00001-PRD.md) | — |
| [T-00002](00002-TICKET.md) | Adopt Fight Common 1.2 | done | [PRD-00002](../specs/00002-PRD.md) | — |
| [T-00003](00003-TICKET.md) | Prepare Fight Common 2.0 Migration | needs-info | [PRD-00002](../specs/00002-PRD.md) | — |
| [T-00004](00004-TICKET.md) | Establish the Canonical Laravel Pre-Submit Quality Gate | done | [PRD-00002](../specs/00002-PRD.md) | — |
| [T-00005](00005-TICKET.md) | Re-certify Rewritten Fight Common Candidate | done | [PRD-00002](../specs/00002-PRD.md) | — |
<!-- /planning:legacy -->

Archive only on an explicit request using the repository-owned command, after all selected records and their
descendants are terminal. Never renumber or archive records as part of ordinary completion.
