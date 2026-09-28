# Issue tracking

Use EPIC → TICKET → TASK as defined in [planning conventions](../CONVENTIONS.md). EPICs own destinations;
TICKETs own requirements; TASKs own implementation and normally one PR. Records own status and dependencies;
[the TASK Board](../tasks/BOARD.md) owns execution routing through generated views.

New TICKETs require an EPIC parent; TASKs require a requirements TICKET parent. PRDs are optional supporting
specifications. T-00001 through T-00005 alone retain legacy PRD/executable-ticket semantics; do not renumber them
or fabricate retrospective TASKs. Inspect live and archived IDs before allocation. Do not synchronize local
planning details back into Fight Common.

After record changes, run `./bin/planning-check --write` and `./bin/planning-check`. Do not create TASKs while
requirements remain unaccepted or decision-incomplete. An empty implementation frontier is a valid outcome.
