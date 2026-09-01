<?php

declare(strict_types=1);

namespace App\Providers;

use Fight\Common\Adapter\Cache\Laravel\LaravelCache;
use Fight\Common\Adapter\EventSourcing\InMemory\InMemoryEventStore;
use Fight\Common\Adapter\FileTransfer\Null\NullFileTransport;
use Fight\Common\Adapter\Observability\Audit\LoggingAuditLog;
use Fight\Common\Adapter\ServiceContainer\Laravel\BroadcastingServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\CacheServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\FileStorageServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\FilesystemServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\HttpClientServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\HttpServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\LoggingServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\MailServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\MessagingServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\MetricsServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\PersistenceServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\ProcessServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\RoutingServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\SecurityServiceProvider;
use Fight\Common\Adapter\ServiceContainer\Laravel\TemplatingServiceProvider;
use Fight\Common\Adapter\Sms\Null\NullSmsTransport;
use Fight\Common\Application\Cache\Cache;
use Fight\Common\Application\Cache\MutableCache;
use Fight\Common\Application\FileTransfer\Transport\FileTransport;
use Fight\Common\Application\Mail\MailService;
use Fight\Common\Application\Mail\Message\MailFactory;
use Fight\Common\Application\Mail\Transport\MailTransport;
use Fight\Common\Application\Observability\AuditLog;
use Fight\Common\Application\Process\ProcessRunner;
use Fight\Common\Application\Scheduler\Scheduler;
use Fight\Common\Application\Sms\Message\SmsFactory;
use Fight\Common\Application\Sms\SmsService;
use Fight\Common\Application\Sms\Transport\SmsTransport;
use Fight\Common\Application\Validation\ValidationService;
use Fight\Common\Domain\EventSourcing\EventMapper;
use Fight\Common\Domain\EventSourcing\EventStore;
use Fight\Common\Domain\Value\DateTime\Timezone;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

final class FightServiceProvider extends ServiceProvider
{
    /**
     * Framework-specific bindings for public Fight package contracts belong here.
     *
     * The complete platform profile installs each bounded Fight Common Laravel capability.
     */
    public function register(): void
    {
        $this->app->singleton(ClientInterface::class, Client::class);
        $this->app->instance('fight.templates_path', config('fight.templates_path'));

        foreach ([
            BroadcastingServiceProvider::class,
            MessagingServiceProvider::class,
            PersistenceServiceProvider::class,
            SecurityServiceProvider::class,
            RoutingServiceProvider::class,
            CacheServiceProvider::class,
            HttpServiceProvider::class,
            HttpClientServiceProvider::class,
            LoggingServiceProvider::class,
            MailServiceProvider::class,
            MetricsServiceProvider::class,
            ProcessServiceProvider::class,
            TemplatingServiceProvider::class,
            FileStorageServiceProvider::class,
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

        $this->app->singleton(ValidationService::class);
        $this->app->singleton(EventMapper::class, static fn (): EventMapper => new EventMapper([]));
        $this->app->singleton(EventStore::class, static fn (Container $app): InMemoryEventStore => new InMemoryEventStore($app->make(EventMapper::class)));
        $this->app->singleton(FileTransport::class, NullFileTransport::class);
        $this->app->singleton(AuditLog::class, static fn (Container $app): LoggingAuditLog => new LoggingAuditLog($app->make(LoggerInterface::class)));
        $this->app->singleton(SmsService::class, static fn (): SmsService => new SmsService(new NullSmsTransport));
        $this->app->alias(SmsService::class, SmsTransport::class);
        $this->app->alias(SmsService::class, SmsFactory::class);
        $this->app->singleton(MailService::class, static fn (Container $app): MailService => new MailService($app->make(MailTransport::class), $app->make(MailFactory::class)));
        $this->app->singleton(Scheduler::class, static function (Container $app): Scheduler {
            $config = $app->make('config');
            assert($config instanceof Config);

            return Scheduler::withProcessRunner(
                new Timezone((string) $config->get('fight.scheduler.timezone', 'UTC')),
                storage_path('framework/cache'),
                $app->make(ProcessRunner::class),
                $app->make(LoggerInterface::class),
                $app->make(MailService::class),
                (string) $config->get('fight.scheduler.from_email', '')
            );
        });
    }
}
