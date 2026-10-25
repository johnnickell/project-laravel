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

After record changes, run `./bin/planning-check --write` and `./bin/planning-check`. Before routing or publication,
use `./bin/planning-check --check-delivery` and the [delivery pre-submit rules](../CONVENTIONS.md#delivery-pre-submit-and-final-handoff).
Generated summaries own TASK selection; delivery markers are publication snapshots, not permanent OPEN claims.
At authorized Work/Land/substantive planning intake run `./bin/planning-check --reconcile-delivery` under
[current delivery handoffs](../CONVENTIONS.md#current-delivery-handoffs). Read-only routing resolves exact verified
merged/integrated done work without cleanup requests; closed-unmerged or uncertain evidence still blocks.
Reconcile affected authored Board/Roadmap/README/current record notes alongside views; preserve historical acceptance.
Do not create feature TASKs while requirements remain unaccepted or decision-incomplete. Standalone bug records
require accepted bounded repair scope. An empty implementation frontier is a valid outcome.

For executable new implementation or confirmed implementation/QA defects, recommend `/skill:build TASK-NNNNN`
with the actual ID; `/skill:work TASK-NNNNN` is for explicit implementation-alone requests. Follow
[implementation routing](../CONVENTIONS.md#implementation-routing) for configured-provider resolution,
evidence-specific Review/QA/Land continuations and authority limits. A recommendation does not invoke a skill.
