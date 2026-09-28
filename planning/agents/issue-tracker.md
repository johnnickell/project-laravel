# Issue tracking

Use EPIC → TICKET → TASK as defined in [planning conventions](../CONVENTIONS.md). EPICs own destinations;
TICKETs own requirements; TASKs own implementation and normally one PR. Records own status and dependencies;
[the TASK Board](../tasks/BOARD.md) owns execution routing through generated views.

New TICKETs require an EPIC parent; TASKs require a requirements TICKET parent. PRDs are optional supporting
specifications. All live records, including completed historical deliveries, use the same hierarchy. Consult
[the migration map](../MIGRATION.md) for renamed identities and historical evidence; do not reuse retired aliases
or present migrated TASK evidence as fresh review. Inspect live/archived records and the map before allocation.
Do not synchronize local planning details back into Fight Common.

After record changes, run `./bin/planning-check --write` and `./bin/planning-check`. Do not create TASKs while
requirements remain unaccepted or decision-incomplete. An empty implementation frontier is a valid outcome.
