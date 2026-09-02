<?php

declare(strict_types=1);

namespace App\Providers;

use Fight\Common\Adapter\Auth\Hmac\HmacAuthenticator;
use Fight\Common\Adapter\Auth\Hmac\HmacRequestService;
use Fight\Common\Adapter\Auth\Hmac\HmacWebhookDispatcher;
use Fight\Common\Adapter\Auth\Security\JwtDecoder;
use Fight\Common\Adapter\Auth\Security\JwtEncoder;
use Fight\Common\Adapter\Cache\Laravel\LaravelCache;
use Fight\Common\Adapter\EventSourcing\InMemory\InMemoryEventStore;
use Fight\Common\Adapter\EventSourcing\InMemory\InMemoryProjectionCheckpointStore;
use Fight\Common\Adapter\EventSourcing\InMemory\InMemoryPublicationCursorStore;
use Fight\Common\Adapter\EventSourcing\InMemory\InMemoryPublicationFailureRecorder;
use Fight\Common\Adapter\FileTransfer\Null\NullFileTransport;
use Fight\Common\Adapter\HttpClient\Guzzle\GuzzleMessageFactory;
use Fight\Common\Adapter\HttpClient\Guzzle\GuzzleStreamFactory;
use Fight\Common\Adapter\HttpClient\Guzzle\GuzzleUriFactory;
use Fight\Common\Adapter\HttpClient\Psr18\Psr18Client;
use Fight\Common\Adapter\Messaging\Command\Sync\Routing\InMemoryCommandRouter;
use Fight\Common\Adapter\Messaging\Command\Sync\RoutingCommandBus;
use Fight\Common\Adapter\Messaging\Event\Sync\SimpleEventDispatcher;
use Fight\Common\Adapter\Messaging\Query\Routing\InMemoryQueryRouter;
use Fight\Common\Adapter\Messaging\Query\RoutingQueryBus;
use Fight\Common\Adapter\Observability\Audit\LoggingAuditLog;
use Fight\Common\Adapter\Observability\Health\HealthReporter;
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
use Fight\Common\Application\Auth\Authenticator;
use Fight\Common\Application\Auth\RequestService;
use Fight\Common\Application\Auth\Security\TokenDecoder;
use Fight\Common\Application\Auth\Security\TokenEncoder;
use Fight\Common\Application\Auth\WebhookDispatcher;
use Fight\Common\Application\Cache\Cache;
use Fight\Common\Application\Cache\MutableCache;
use Fight\Common\Application\EventSourcing\ProjectionCheckpointStore;
use Fight\Common\Application\EventSourcing\PublicationCursorStore;
use Fight\Common\Application\EventSourcing\PublicationFailureRecorder;
use Fight\Common\Application\FileTransfer\Transport\FileTransport;
use Fight\Common\Application\HttpClient\Message\MessageFactory;
use Fight\Common\Application\HttpClient\Message\StreamFactory;
use Fight\Common\Application\HttpClient\Message\UriFactory;
use Fight\Common\Application\Mail\MailService;
use Fight\Common\Application\Mail\Message\MailFactory;
use Fight\Common\Application\Mail\Transport\MailTransport;
use Fight\Common\Application\Messaging\Command\CommandBus;
use Fight\Common\Application\Messaging\Command\SynchronousCommandBus;
use Fight\Common\Application\Messaging\Event\EventDispatcher;
use Fight\Common\Application\Messaging\Event\SynchronousEventDispatcher;
use Fight\Common\Application\Messaging\Query\QueryBus;
use Fight\Common\Application\Observability\AuditLog;
use Fight\Common\Application\Observability\HealthAggregator;
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
use Psr\Http\Client\ClientInterface as Psr18ClientInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;

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
        $this->app->singleton(Authenticator::class, static function (Container $app): HmacAuthenticator {
            $config = $app->make('config');
            assert($config instanceof Config);

            return new HmacAuthenticator(
                self::requiredSecurityValue($config, 'fight.security.hmac.public', 'FIGHT_HMAC_PUBLIC'),
                self::requiredSecurityValue($config, 'fight.security.hmac.private', 'FIGHT_HMAC_PRIVATE'),
                (int) $config->get('fight.security.hmac.time_tolerance', 300),
            );
        });
        $this->app->singleton(RequestService::class, static function (Container $app): HmacRequestService {
            $config = $app->make('config');
            assert($config instanceof Config);

            return new HmacRequestService(
                self::requiredSecurityValue($config, 'fight.security.hmac.public', 'FIGHT_HMAC_PUBLIC'),
                self::requiredSecurityValue($config, 'fight.security.hmac.private', 'FIGHT_HMAC_PRIVATE'),
            );
        });
        $this->app->singleton(TokenEncoder::class, static function (Container $app): JwtEncoder {
            $config = $app->make('config');
            assert($config instanceof Config);

            return new JwtEncoder(
                self::requiredSecurityValue($config, 'fight.security.jwt.secret', 'FIGHT_JWT_SECRET'),
                (string) $config->get('fight.security.jwt.algorithm', 'HS256'),
            );
        });
        $this->app->singleton(TokenDecoder::class, static function (Container $app): JwtDecoder {
            $config = $app->make('config');
            assert($config instanceof Config);

            return new JwtDecoder(
                self::requiredSecurityValue($config, 'fight.security.jwt.secret', 'FIGHT_JWT_SECRET'),
                (string) $config->get('fight.security.jwt.algorithm', 'HS256'),
            );
        });
        $this->app->singleton(MessageFactory::class, GuzzleMessageFactory::class);
        $this->app->singleton(StreamFactory::class, GuzzleStreamFactory::class);
        $this->app->singleton(UriFactory::class, GuzzleUriFactory::class);
        $this->app->singleton(Psr18ClientInterface::class, Psr18Client::class);
        $this->app->singleton(WebhookDispatcher::class, HmacWebhookDispatcher::class);
        $this->app->singleton(HealthAggregator::class, HealthReporter::class);
        $this->app->singleton(InMemoryCommandRouter::class);
        $this->app->singleton(SynchronousCommandBus::class, static fn (Container $app): RoutingCommandBus => new RoutingCommandBus($app->make(InMemoryCommandRouter::class)));
        $this->app->alias(SynchronousCommandBus::class, CommandBus::class);
        $this->app->singleton(InMemoryQueryRouter::class);
        $this->app->singleton(QueryBus::class, static fn (Container $app): RoutingQueryBus => new RoutingQueryBus($app->make(InMemoryQueryRouter::class)));
        $this->app->singleton(SynchronousEventDispatcher::class, SimpleEventDispatcher::class);
        $this->app->alias(SynchronousEventDispatcher::class, EventDispatcher::class);
        $this->app->singleton(EventMapper::class, static fn (): EventMapper => new EventMapper([]));
        $this->app->singleton(EventStore::class, static fn (Container $app): InMemoryEventStore => new InMemoryEventStore($app->make(EventMapper::class)));
        $this->app->singleton(ProjectionCheckpointStore::class, InMemoryProjectionCheckpointStore::class);
        $this->app->singleton(PublicationCursorStore::class, InMemoryPublicationCursorStore::class);
        $this->app->singleton(PublicationFailureRecorder::class, InMemoryPublicationFailureRecorder::class);
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

    private static function requiredSecurityValue(Config $config, string $key, string $environmentVariable): string
    {
        $value = $config->get($key);

        if (! is_string($value) || trim($value) === '') {
            throw new RuntimeException(sprintf('%s must be configured before resolving Fight security services.', $environmentVariable));
        }

        return $value;
    }
}
