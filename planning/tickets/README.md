# Requirements TICKETs

Every live TICKET owns cohesive requirements under an EPIC. Implementation and historical delivery evidence
belong to child TASKs. [The TASK Board](../tasks/BOARD.md) is the only execution frontier.

The [complete migration map](../MIGRATION.md) records original identities and where historical evidence moved.
T-00003 remains needs-info; T-00007 and T-00011 require reconciliation of the successor-gate policy. None becomes
executable merely because its old record used the word ticket. Use [_TICKET_TEMPLATE.md](_TICKET_TEMPLATE.md).

<!-- planning:index -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [T-00001](00001-TICKET.md) | Establish the Canonical Full-Stack Laravel Starter Foundation | done | [EPIC-00002](../epics/00002-EPIC.md) | — |
| [T-00002](00002-TICKET.md) | Adopt Fight Common 1.2 | done | [EPIC-00003](../epics/00003-EPIC.md) | — |
| [T-00003](00003-TICKET.md) | Prepare Fight Common 2.0 Migration | needs-info | [EPIC-00003](../epics/00003-EPIC.md) | — |
| [T-00004](00004-TICKET.md) | Establish the Canonical Laravel Pre-Submit Quality Gate | done | [EPIC-00003](../epics/00003-EPIC.md) | — |
| [T-00005](00005-TICKET.md) | Re-certify Rewritten Fight Common Candidate | done | [EPIC-00003](../epics/00003-EPIC.md) | — |
| [T-00006](00006-TICKET.md) | Adopt Current Fight Packages as an Application Consumer | in-progress | [EPIC-00001](../epics/00001-EPIC.md) | — |
| [T-00007](00007-TICKET.md) | Verify the Application Through a Running Compose Stack | needs-info | [EPIC-00001](../epics/00001-EPIC.md) | [T-00006](00006-TICKET.md) |
| [T-00008](00008-TICKET.md) | Enforce Shared Application Permission Policy | needs-info | [EPIC-00001](../epics/00001-EPIC.md) | [T-00006](00006-TICKET.md) |
| [T-00009](00009-TICKET.md) | Persist Authoritative AccessControl State and Required Effects | needs-info | [EPIC-00001](../epics/00001-EPIC.md) | [T-00006](00006-TICKET.md), [T-00008](00008-TICKET.md) |
| [T-00010](00010-TICKET.md) | Deliver a Real Permission-Protected API Slice | needs-info | [EPIC-00001](../epics/00001-EPIC.md) | [T-00007](00007-TICKET.md), [T-00008](00008-TICKET.md), [T-00009](00009-TICKET.md) |
| [T-00011](00011-TICKET.md) | Establish the Lean Laravel Pre-Submit Quality Gate | needs-info | [EPIC-00001](../epics/00001-EPIC.md) | [T-00006](00006-TICKET.md) |
<!-- /planning:index -->
