<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;

require dirname(__DIR__).'/vendor/autoload.php';

/** @var array{versions: array<string, array<string, mixed>>} $installed */
$installed = require dirname(__DIR__).'/vendor/composer/installed.php';

foreach (['johnnickell/fight-common', 'johnnickell/fight-access-control'] as $package) {
    if (! isset($installed['versions'][$package])) {
        throw new RuntimeException(sprintf('Production dependency %s is not installed.', $package));
    }
}

$app = require dirname(__DIR__).'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

fwrite(STDOUT, "Production autoload and Laravel boot passed.\n");
