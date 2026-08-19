<?php

declare(strict_types=1);

namespace Tests\Architecture;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class SourceBoundaryTest extends TestCase
{
    public function test_fight_libraries_are_consumed_only_through_composer(): void
    {
        $root = dirname(__DIR__, 2);
        $manifest = json_decode((string) file_get_contents($root.'/composer.json'), true, flags: JSON_THROW_ON_ERROR);

        self::assertSame('^1.1', $manifest['require']['johnnickell/fight-common']);
        self::assertSame('dev-develop', $manifest['require']['johnnickell/fight-access-control']);
        self::assertContains('https://github.com/johnnickell/fight-access-control', array_column($manifest['repositories'], 'url'));

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/app'));

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            if (! $file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $source = (string) file_get_contents($file->getPathname());

            self::assertStringNotContainsString('namespace Fight\\Common', $source, sprintf('Copied Fight Common source is forbidden: %s', $file->getPathname()));
            self::assertStringNotContainsString('namespace Fight\\AccessControl', $source, sprintf('Copied Fight AccessControl source is forbidden: %s', $file->getPathname()));
        }

        self::assertDirectoryDoesNotExist($root.'/app/Fight');
    }

    public function test_repository_owns_laravel_composition_and_authority(): void
    {
        $root = dirname(__DIR__, 2);

        foreach ([
            'AGENTS.md', 'CONTEXT.md', 'LICENSE', 'SECURITY.md', 'CONTRIBUTING.md',
            'bin/artisan', 'bin/build', 'bin/composer', 'bin/down', 'bin/exec', 'bin/phpunit', 'bin/up',
            'compose.yaml', 'bootstrap/app.php', 'bootstrap/providers.php',
            'etc/docker/fpm/Dockerfile', 'etc/docker/nginx/Dockerfile',
            'app/Providers/FightServiceProvider.php', 'routes/web.php', 'resources/views/home.blade.php',
            'planning/specs/00001-PRD.md', 'planning/tickets/00001-TICKET.md', 'planning/tickets/BOARD.md',
            'planning/agents/domain.md', 'planning/agents/issue-tracker.md', 'planning/agents/triage-labels.md',
            'scripts/artisan', 'scripts/planning-check.php', 'scripts/production-autoload-check.php',
            'client/package.json', 'client/.npmrc', 'client/vite.config.js',
        ] as $path) {
            self::assertFileExists($root.'/'.$path, sprintf('Missing foundation file: %s', $path));
        }

        self::assertStringContainsString('FightServiceProvider', (string) file_get_contents($root.'/bootstrap/providers.php'));
        self::assertStringContainsString('Ready Frontier', (string) file_get_contents($root.'/planning/tickets/BOARD.md'));
        self::assertFileDoesNotExist($root.'/artisan');
        self::assertFileDoesNotExist($root.'/bin/console');
        self::assertFileDoesNotExist($root.'/package.json');
        self::assertFileDoesNotExist($root.'/.npmrc');
        self::assertFileDoesNotExist($root.'/vite.config.js');
        self::assertFileDoesNotExist($root.'/Dockerfile');
    }

    public function test_cache_artifacts_are_routed_to_var_cache(): void
    {
        $root = dirname(__DIR__, 2);
        $environment = (string) file_get_contents($root.'/.env.example');

        self::assertStringContainsString('APP_CONFIG_CACHE=/app/var/cache/laravel/config.php', $environment);
        self::assertStringContainsString('VIEW_COMPILED_PATH=/app/var/cache/laravel/views', $environment);
        self::assertStringContainsString('CACHE_FILE_PATH=/app/var/cache/laravel/data', $environment);
        self::assertStringContainsString('SESSION_DRIVER=file', $environment);
        self::assertStringContainsString('QUEUE_CONNECTION=sync', $environment);
        self::assertStringContainsString('cacheDirectory="var/cache/phpunit"', (string) file_get_contents($root.'/phpunit.xml'));
        self::assertStringContainsString('/var/', (string) file_get_contents($root.'/.gitignore'));
    }
}
