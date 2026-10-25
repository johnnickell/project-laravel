# AGENTS.md

## Work routing

For “What's next?”, `next`, or an unqualified `/ask-matt`, go straight to the [Board](planning/tasks/BOARD.md)
before general project orientation. Read its current human decision and active work; otherwise select the first
executable ready TASK in Board order. Use the [Wayfinder index](planning/wayfinder/README.md) for map status and current frontier pointers.
Follow [lightweight work routing](planning/CONVENTIONS.md#lightweight-work-routing) for validation,
bounded evidence reads and planning handoffs. Run `./bin/planning-check --check-delivery` before selection;
an offline planning/build pass does not establish live delivery freshness. Recommend and stop; load execution
guidance when work is invoked.
This routing path does not require reading README, architecture, full project context, task history or receiving skills.

For new implementation and confirmed implementation/QA defects, recommend `/skill:build TASK-NNNNN` by default
with the actual TASK ID. Use `/skill:work TASK-NNNNN` only for explicit implementation-alone requests.
Follow [implementation routing](planning/CONVENTIONS.md#implementation-routing) for capability resolution,
evidence-specific routes and authority boundaries; recommending a workflow does not invoke it.

## Project guidance

For execution or substantive planning changes, load the applicable guidance below. The read-only routing
path above takes precedence over broad orientation reads; it does not waive engineering or delivery rules.

Read `CONTEXT.md`, `planning/CONVENTIONS.md`, and `planning/agents/` before changing behavior. Work in independently verifiable vertical slices. Use the repository-owned `./bin/build`, `./bin/phpunit`, `./bin/up`, `./bin/down`, `./bin/composer`, `./bin/artisan`, and `./bin/exec` commands; `./bin/build` is the single noninteractive local and hosted gate.

Fight Common and Fight AccessControl are consumed only as Composer packages. Do not copy their Domain or Application source, and do not add a Fight Laravel package or framework adapter. Laravel owns its providers, container, routing, middleware, handlers, HTTP, security, persistence, queues, realtime, presentation, and operational composition.

Use `var/cache/` for Laravel and developer-tool cache artifacts. `.runs/` is ignored scratch space and must not be staged. Create feature branches from `develop`; do not commit directly to `develop`.

## Run and Worktree Isolation

Coordinate-build scratch belongs in `.runs/<YYYY-MM-DD>-<slug>/`. It is gitignored and must never be staged.

## Branch Conventions

Create feature branches from `develop` as `feature/<description>`. Never commit directly to `develop` or `main`.

## Pre-Submit Gate

For a long non-interactive build, run `screen -dmS <task>-build /bin/zsh -lc './bin/build > /private/tmp/<task>-build.log 2>&1; print -r -- $? > /private/tmp/<task>-build.exit'`, then inspect the log and require an exit file containing `0`; never treat foreground timeout output as a build result.

Always run before committing or creating a PR:

```bash
./bin/build
```

## Planning

See `planning/CONVENTIONS.md` for the canonical EPIC → TICKET → TASK lifecycle, TASK Board execution frontier,
Wayfinder maps, optional supporting PRDs, complete-migration provenance, templates, and explicit-only archive operations. Never
archive planning records as a completion side effect; run `./bin/archive-planning` only on an explicit request,
review its dry run, and then apply it.

### Pre-PR Sync Checklist

Before final commit and PR for any feature or bug fix:

1. Record verified TASK acceptance, evidence, and actual review state; mark `done` only when its criteria are met
2. Apply automatic parent completion and reconcile parent progress in the same operation
3. Recalculate the Board's "What's Next?" contract and authored human-decision/Wayfinder pointers
4. Update affected supporting PRDs, `planning/ROADMAP.md`, README/context and current record handoffs when progress changed
5. Preserve dependency edges and derive which blockers remain unfinished
6. Refresh generated views with `./bin/planning-check --write`
7. Run `./bin/planning-check`; retain the canonical build requirement above
8. For Land/publication follow [delivery pre-submit](planning/CONVENTIONS.md#delivery-pre-submit-and-final-handoff):
   live delivery checks at intake, immediately before publication and after final metadata/view changes;
   reconcile affected authored handoffs as well as generated sections

When completing a TASK, apply [Automatic parent completion](planning/CONVENTIONS.md#automatic-parent-completion)
in the same operation; do not leave a separate parent assessment or closeout action for the user.

## Certification retirement

Test owned application behavior and meaningful package integrations. Do not create or restore framework-support
certification files, receipt readers/generators, dependency certification matrices, or tests of those mechanisms.
Validate build, configuration and planning tools directly with their owning commands, outside product suites.
Historical certification notes remain history, not current gates.
