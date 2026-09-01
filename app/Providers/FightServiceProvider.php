<?php

declare(strict_types=1);

namespace App\Providers;

use Fight\Common\Adapter\Cache\Laravel\LaravelCache;
use Fight\Common\Adapter\ServiceContainer\Laravel\CacheServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\FilesystemServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\MessagingServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\PersistenceServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\RoutingServiceProvider;
use Fight\Common\Application\Cache\Cache;
use Fight\Common\Application\Cache\MutableCache;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class FightServiceProvider extends ServiceProvider
{
    /**
     * Framework-specific bindings for public Fight package contracts belong here.
     *
     * Only the receipt-selected Fight Common capabilities are installed here.
     */
    public function register(): void
    {
        foreach ([
            MessagingServiceProvider::class,
            PersistenceServiceProvider::class,
            RoutingServiceProvider::class,
            CacheServiceProvider::class,
            FilesystemServiceProvider::class,
        ] as $provider) {
            $this->app->register($provider);
        }

        // Laravel exposes its selected default store separately from the cache manager.
        $this->app->singleton(MutableCache::class, static function (Container $container): LaravelCache {
            $cache = $container->make('cache.store');
            assert($cache instanceof Repository);

            return new LaravelCache($cache);
        });
        $this->app->alias(MutableCache::class, Cache::class);
    }
}
