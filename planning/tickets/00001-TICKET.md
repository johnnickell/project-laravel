---
id: T-00001
prd: PRD-00001
title: Establish the Canonical Full-Stack Laravel Starter Foundation
status: done
blocked_by: []
---

# Establish the Canonical Full-Stack Laravel Starter Foundation

## What to build

Establish the Laravel-native, public-source foundation: native composition through public Fight packages, canonical local planning, Docker-backed developer commands, a rendered home page, and a clean-clone build without a product journey.

## Acceptance criteria

- [x] `planning/specs/00001-PRD.md` and `planning/tickets/BOARD.md` are the local authorities.
- [x] Fight packages are Composer dependencies and no copied shared Domain/Application source exists.
- [x] `GET /` renders the Laravel foundation through PHP-FPM and Nginx at `http://127.0.0.1:18084/`.
- [x] Laravel and developer-tool cache artifacts use ignored `var/cache/` paths.
- [x] `./bin/build` verifies Composer, planning, architecture, tests, and a production installation.
- [x] Hosted CI delegates to `./bin/build`; a clean-clone receipt binds the successful build to a commit.

## Explicit exclusions

No login, application persistence, browser automation, release, tag, Packagist publication, template enablement, or create-project distribution is authorized.
