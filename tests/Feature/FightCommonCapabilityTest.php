<?php

declare(strict_types=1);

namespace Tests\Feature;

use Fight\Common\Adapter\Cache\Laravel\LaravelCache;
use Fight\Common\Adapter\Filesystem\Symfony\SymfonyFilesystem;
use Fight\Common\Adapter\Persistence\Laravel\LaravelTransactionalUnitOfWork;
use Fight\Common\Adapter\Routing\Laravel\LaravelUrlGenerator;
use Fight\Common\Application\Cache\MutableCache;
use Fight\Common\Application\Filesystem\Filesystem;
use Fight\Common\Application\Repository\TransactionalUnitOfWork;
use Fight\Common\Application\Routing\UrlGenerator;
use Tests\TestCase;

final class FightCommonCapabilityTest extends TestCase
{
    public function test_selected_laravel_capabilities_are_composed_without_optional_adapters(): void
    {
        self::assertInstanceOf(LaravelCache::class, $this->app->make(MutableCache::class));
        self::assertInstanceOf(LaravelTransactionalUnitOfWork::class, $this->app->make(TransactionalUnitOfWork::class));
        self::assertInstanceOf(LaravelUrlGenerator::class, $this->app->make(UrlGenerator::class));
        self::assertInstanceOf(SymfonyFilesystem::class, $this->app->make(Filesystem::class));
        self::assertFalse($this->app->bound('Fight\\Common\\Application\\Mail\\Transport\\MailTransport'));
        self::assertFalse($this->app->bound('Fight\\Common\\Application\\HttpClient\\Transport\\HttpClient'));
    }
}
