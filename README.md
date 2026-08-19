# Fight Laravel Starter

Public Laravel application composition for Fight Common and Fight AccessControl. Public source does not imply a release, Packagist publication, template enablement, or create-project distribution.

## Local development

```sh
./bin/up
./bin/composer install
./bin/artisan about
./bin/phpunit
./bin/build
```

The application is available at http://127.0.0.1:18084/ while Compose is running. Run Laravel CLI commands through `./bin/artisan`. Frontend tooling and applications live in `client/`; for example, use `npm --prefix client install` and `npm --prefix client run dev`. `./bin/build` is the canonical noninteractive completion gate used by CI. `planning/README.md` names local planning authority and `planning/tickets/BOARD.md` gives the current execution order. Use `./bin/down` to stop the stack.
