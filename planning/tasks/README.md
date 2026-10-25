# TASKs

TASKs are approved implementation slices under accepted requirements TICKETs, normally one PR each.
Approved standalone bugs may use `kind: bug` with an empty `ticket:`; see the same readiness rules below.
Use `_TASK_TEMPLATE.md` and the readiness rules in [planning conventions](../CONVENTIONS.md).
[BOARD.md](BOARD.md) is the canonical execution frontier; its generated summary owns current TASK selection.
Before routing run `./bin/planning-check --check-delivery` from the repository root. Explicit delivery markers
own current merge handoffs; historical PR links and terminal status do not imply pending publication. Creating a TASK alone does
not start execution or select an implementation worktree.

<!-- planning:index -->
| ID | Title | Status | Parent | Blocked by |
| --- | --- | --- | --- | --- |
| [TASK-00001](00001-TASK.md) | Adopt Released Fight Packages and Retire Certification | done | [T-00006](../tickets/00006-TICKET.md) | — |
| [TASK-00002](00002-TASK.md) | Establish the Canonical Full-Stack Laravel Starter Foundation | done | [T-00001](../tickets/00001-TICKET.md) | — |
| [TASK-00003](00003-TASK.md) | Adopt Fight Common 1.2 | done | [T-00002](../tickets/00002-TICKET.md) | — |
| [TASK-00004](00004-TASK.md) | Establish the Canonical Laravel Pre-Submit Quality Gate | done | [T-00004](../tickets/00004-TICKET.md) | — |
| [TASK-00005](00005-TASK.md) | Re-certify Rewritten Fight Common Candidate | done | [T-00005](../tickets/00005-TICKET.md) | — |
| [TASK-00006](00006-TASK.md) | Upgrade Fight Common to 1.4 and AccessControl to 0.8 | done | [T-00012](../tickets/00012-TICKET.md) | [TASK-00001](00001-TASK.md) |
| [TASK-00007](00007-TASK.md) | Refresh vulnerable PHP, Node and NGINX container baselines | done | — | — |
| [TASK-00008](00008-TASK.md) | Keep planning routing and delivery handoffs synchronized | done | — | — |
| [TASK-00009](00009-TASK.md) | Adopt Agent OS Planning Identities | ready-for-agent | [T-00013](../tickets/00013-TICKET.md) | — |
| [TASK-00010](00010-TASK.md) | Bind Laravel Workflows and Canonical Evidence | ready-for-agent | [T-00013](../tickets/00013-TICKET.md) | [TASK-00009](00009-TASK.md) |
| [TASK-00011](00011-TASK.md) | Adopt Prospective Acceptance and Closeout Rules | ready-for-agent | [T-00014](../tickets/00014-TICKET.md) | — |
<!-- /planning:index -->
