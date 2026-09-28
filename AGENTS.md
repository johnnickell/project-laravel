# AGENTS.md

Read `CONTEXT.md`, `planning/CONVENTIONS.md`, and `planning/agents/` before changing behavior. Work in independently verifiable vertical slices. Use the repository-owned `./bin/build`, `./bin/phpunit`, `./bin/up`, `./bin/down`, `./bin/composer`, `./bin/artisan`, and `./bin/exec` commands; `./bin/build` is the single noninteractive local and hosted gate.

Fight Common and Fight AccessControl are consumed only as Composer packages. Do not copy their Domain or Application source, and do not add a Fight Laravel package or framework adapter. Laravel owns its providers, container, routing, middleware, handlers, HTTP, security, persistence, queues, realtime, presentation, and operational composition.

Use `var/cache/` for Laravel and developer-tool cache artifacts. `.runs/` is ignored scratch space and must not be staged. Create feature branches from `develop`; do not commit directly to `develop`.

## Work Routing

When asked "What's next?" or invoked without a task, read `planning/tasks/BOARD.md` and return the current human decision under **Now** and the active TASK, or otherwise the first executable TASK under **Ready Frontier**. Say when none exists; never substitute a requirements TICKET. Use `planning/CONVENTIONS.md` for EPIC → TICKET → TASK readiness and ordering.

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
Wayfinder maps, optional supporting PRDs, legacy-record boundaries, templates, and explicit-only archive operations. Never
archive planning records as a completion side effect; run `./bin/archive-planning` only on an explicit request,
review its dry run, and then apply it.

### Pre-PR Sync Checklist

Before final commit and PR for any feature or bug fix:

1. Record verified TASK acceptance, evidence, and actual review state; mark `done` only when its criteria are met
2. Reconcile parent TICKET and EPIC progress; do not close a parent solely because one TASK finished
3. Recalculate the Board's "What's Next?" contract and authored human-decision/Wayfinder pointers
4. Update affected supporting PRDs and `planning/ROADMAP.md` when progress changed
5. Preserve dependency edges and derive which blockers remain unfinished
6. Refresh generated views with `./bin/planning-check --write`
7. Run `./bin/planning-check`; retain the canonical build requirement above
