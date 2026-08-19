# AGENTS.md

Read `CONTEXT.md` before planning or changing application behavior. Durable work tracking is local to `planning/`: tickets are canonical for status and blocking edges, and `planning/tickets/BOARD.md` is canonical for recommended order. Use `./bin/build` as the noninteractive submit gate.

Fight Common and Fight AccessControl are consumed only as Composer packages. Do not copy their Domain or Application source, and do not add a Fight Laravel package or framework adapter. Laravel owns its providers, container, HTTP, security, persistence, queues, realtime, presentation, and operational composition.

Use `var/cache/` for Laravel and developer-tool cache artifacts. `.runs/` is ignored scratch space and must not be staged. Create feature branches from `develop`; do not commit directly to `develop`.
