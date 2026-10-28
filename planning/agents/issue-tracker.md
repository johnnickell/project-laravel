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

After record changes, run offline `./bin/planning-check --write` and `./bin/planning-check`. Land owns
[publication closeout](../CONVENTIONS.md#publication-closeout), exact live own-PR validation and eligible local
retirement. No persistent delivery queue or recurring post-merge planning chore. Generated summaries own TASK
selection; historical publication checkpoints are not live state or independent acceptance.
Reconcile affected authored Board/Roadmap/README/current record notes alongside views; preserve historical acceptance.
Do not create feature TASKs while requirements remain unaccepted or decision-incomplete. Standalone bug records
require accepted bounded repair scope. An empty implementation frontier is a valid outcome.

For executable new implementation or confirmed implementation/QA defects, recommend `/skill:build TASK-NNNNN`
with the actual ID; `/skill:work TASK-NNNNN` is for explicit implementation-alone requests. Follow
[implementation routing](../CONVENTIONS.md#implementation-routing) for configured-provider resolution,
evidence-specific Review/QA/Land continuations and authority limits. A recommendation does not invoke a skill.
