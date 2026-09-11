<?php

declare(strict_types=1);

namespace Tests\Architecture;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class SourceBoundaryTest extends TestCase
{
    public function test_fight_library_source_is_not_copied_into_the_application(): void
    {
        $root = dirname(__DIR__, 2);
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

    public function test_common_owns_the_laravel_async_and_private_adapters(): void
    {
        $root = dirname(__DIR__, 2);
        $provider = (string) file_get_contents($root.'/app/Providers/FightServiceProvider.php');

        foreach ([
            'app/Infrastructure/Messaging/LaravelQueuedCommandBus.php',
            'app/Infrastructure/Messaging/LaravelQueuedEventDispatcher.php',
            'app/Infrastructure/Socket/LaravelPrivatePublisher.php',
        ] as $path) {
            self::assertFileDoesNotExist($root.'/'.$path);
        }

        self::assertStringNotContainsString('AsynchronousCommandBus::class', $provider);
        self::assertStringNotContainsString('AsynchronousEventDispatcher::class', $provider);
        self::assertStringNotContainsString('PrivatePublisher::class', $provider);
    }
}
