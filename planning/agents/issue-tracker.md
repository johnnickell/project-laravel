# Issue tracking

Use EPIC → TICKET → TASK as defined in [planning conventions](../CONVENTIONS.md). EPICs own destinations;
TICKETs own requirements; TASKs own implementation and normally one PR. Records own status and dependencies;
[the TASK Board](../tasks/BOARD.md) owns execution routing through generated views.

New TICKETs require an EPIC parent; feature TASKs require a requirements TICKET parent. Approved standalone
bugs use `kind: bug` and an explicit empty `ticket:` under the planning conventions. PRDs are optional supporting
specifications. All live records, including completed historical deliveries, use the same hierarchy. Consult
[the migration map](../MIGRATION.md) for renamed identities and historical evidence; do not reuse retired aliases
or present migrated TASK evidence as fresh review. Inspect live/archived records and the map before allocation.
Do not synchronize local planning details back into Fight Common.

After record changes, run `./bin/planning-check --write` and `./bin/planning-check`. Do not create feature TASKs while
requirements remain unaccepted or decision-incomplete. Standalone bug records require accepted bounded repair scope. An empty implementation frontier is a valid outcome.
