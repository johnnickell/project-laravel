# Fight Laravel Starter

Public Laravel application composition for Fight Common and Fight AccessControl. Public source does not imply
a release, Packagist publication, template enablement, or create-project distribution.

## Local development

Prerequisites: Docker with Compose, Git, and host Python 3 for planning validation. The current gate prepares
its own PHP 8.5/Node build images and installs the committed Composer/npm locks; host PHP and Node are not
required for that gate. Image-building commands explicitly pull base images and require registry access even
with a warm cache; a failed pull stops the command.

```sh
./bin/build                 # Current setup plus canonical verification, including frontend assets
./bin/up                    # Start the local application
./bin/artisan about
./bin/phpunit               # Focused application test run through Pest
./bin/down                 # Stop the stack
```

The application is available at http://127.0.0.1:18084/ while Compose is running. The Compose APP_KEY is a
local-development placeholder, not a production secret. Run Laravel CLI commands through `./bin/artisan`.
Use `./bin/composer install` to restore the committed PHP lock; dependency updates are explicit maintenance,
not normal setup. Optional frontend development uses host Node and `npm --prefix client ci` followed by
`npm --prefix client run dev`.

`./bin/build` is the canonical noninteractive gate used by CI. It still builds images and installs dependencies;
the running-stack replacement belongs to T-00007 and is not implemented by the package-adoption change.

### Container security and worktree isolation

Reviewed baselines are PHP **8.5.12** (CLI and FPM), Node **24.22.1** (build tooling), and NGINX **1.30.6**.
Dockerfiles pin patch versions; `--pull` refreshes those tags but does not advance to future patch versions.
Future security releases require a deliberate Dockerfile update, rebuild, and replacement of affected workers.
This local workflow does not deploy or restart production.

For an isolated worktree, export a unique `COMPOSE_PROJECT_NAME` before running **all** `./bin/` commands.
Build/test/Composer image tags use that prefix too; the default remains `project-laravel`.
If another stack uses port 18084, supply a separate Compose override through `COMPOSE_FILE` that replaces the
server's port mapping with an unused loopback port. Use `./bin/down` with the same project and files; never stop
another checkout's stack. Source, dependencies and caches remain inside the selected checkout.

## Package integration and verification

Composer locks Fight Common **1.2.0** and Fight AccessControl **0.4.0** from published packages. Laravel owns
local composition; do not copy package Domain/Application code or introduce a Fight Laravel package.
The [installed contract handoff](planning/wayfinder/fight-package-baseline.md) describes current public contracts,
retained/removed integration, and downstream decisions. No complete-platform support certification is promised.

The existing credential boundary requires explicit `FIGHT_HMAC_PUBLIC`, hex-encoded `FIGHT_HMAC_PRIVATE`, and
hex-encoded `FIGHT_JWT_SECRET` when those services are used. Use independent secure keys of the required length
for the selected algorithm. Missing credentials fail closed; `.env.example` intentionally has no defaults.
The homepage needs none of them. These integrations do not constitute API authentication, authorization, token
lifecycle enforcement, or HMAC replay prevention; no new security endpoint is exposed.

Tests prove the homepage, retained credential/key/time-window behavior, and the default Laravel transaction
connection's commit/rollback outcomes. The gate enforces exact **100% statement coverage of `app/`**, without
coverage exclusions added for this cutover. That is combined integration/functional coverage, not a unit-suite
claim. Tools, wrappers, architecture rules, and documentation are verified through their owning commands and
inspection rather than product-suite meta-tests.

## Planning

[Planning](planning/README.md) names local authority; the [TASK Board](planning/tasks/BOARD.md) gives execution
order for **EPIC → TICKET → TASK**. After planning edits run `./bin/planning-check --write`, then
`./bin/planning-check`. Legacy certification records remain historical evidence, not current obligations.
