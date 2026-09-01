<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Infrastructure\Socket\LaravelPrivatePublisher;
use Fight\Common\Adapter\Cache\Laravel\LaravelCache;
use Fight\Common\Adapter\Filesystem\Symfony\SymfonyFilesystem;
use Fight\Common\Adapter\Http\Laravel\JSendResponse;
use Fight\Common\Adapter\Persistence\Laravel\LaravelTransactionalUnitOfWork;
use Fight\Common\Adapter\Routing\Laravel\LaravelUrlGenerator;
use Fight\Common\Application\Auth\Security\PasswordHasher;
use Fight\Common\Application\Auth\Security\PasswordValidator;
use Fight\Common\Application\Cache\MutableCache;
use Fight\Common\Application\EventSourcing\ProjectionCheckpointStore;
use Fight\Common\Application\EventSourcing\PublicationCursorStore;
use Fight\Common\Application\EventSourcing\PublicationFailureRecorder;
use Fight\Common\Application\FileStorage\FileStorage;
use Fight\Common\Application\Filesystem\Filesystem;
use Fight\Common\Application\FileTransfer\Transport\FileTransport;
use Fight\Common\Application\HttpClient\Transport\HttpClient;
use Fight\Common\Application\Mail\MailService;
use Fight\Common\Application\Mail\Message\MailFactory;
use Fight\Common\Application\Mail\Transport\MailTransport;
use Fight\Common\Application\Messaging\Command\AsynchronousCommandBus;
use Fight\Common\Application\Messaging\Command\CommandBus;
use Fight\Common\Application\Messaging\Event\AsynchronousEventDispatcher;
use Fight\Common\Application\Messaging\Event\EventDispatcher;
use Fight\Common\Application\Messaging\Query\QueryBus;
use Fight\Common\Application\Observability\AuditLog;
use Fight\Common\Application\Observability\MetricsCollector;
use Fight\Common\Application\Process\ProcessRunner;
use Fight\Common\Application\Repository\TransactionalUnitOfWork;
use Fight\Common\Application\Routing\UrlGenerator;
use Fight\Common\Application\Scheduler\Scheduler;
use Fight\Common\Application\Sms\Message\SmsFactory;
use Fight\Common\Application\Sms\Transport\SmsTransport;
use Fight\Common\Application\Socket\PrivatePublisher;
use Fight\Common\Application\Socket\Publisher;
use Fight\Common\Application\Templating\TemplateEngine;
use Fight\Common\Application\Validation\ValidationService;
use Fight\Common\Domain\EventSourcing\EventStore;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

final class FightCommonCapabilityTest extends TestCase
{
    public function test_complete_platform_profile_composes_every_fight_service(): void
    {
        self::assertInstanceOf(LaravelCache::class, $this->app->make(MutableCache::class));
        self::assertInstanceOf(LaravelTransactionalUnitOfWork::class, $this->app->make(TransactionalUnitOfWork::class));
        self::assertInstanceOf(LaravelUrlGenerator::class, $this->app->make(UrlGenerator::class));
        self::assertInstanceOf(SymfonyFilesystem::class, $this->app->make(Filesystem::class));
        self::assertInstanceOf(LaravelPrivatePublisher::class, $this->app->make(PrivatePublisher::class));
        foreach ([
            PasswordHasher::class, PasswordValidator::class, FileStorage::class, HttpClient::class,
            JSendResponse::class, LoggerInterface::class, MailFactory::class, MailTransport::class,
            MailService::class, MetricsCollector::class, ProcessRunner::class, TemplateEngine::class,
            Publisher::class, PrivatePublisher::class, ValidationService::class, EventStore::class, FileTransport::class,
            AuditLog::class, SmsFactory::class, SmsTransport::class, Scheduler::class,
            CommandBus::class, QueryBus::class, EventDispatcher::class, AsynchronousCommandBus::class,
            AsynchronousEventDispatcher::class, ProjectionCheckpointStore::class, PublicationCursorStore::class,
            PublicationFailureRecorder::class,
        ] as $service) {
            self::assertTrue($this->app->bound($service), sprintf('%s must be registered.', $service));
            self::assertIsObject($this->app->make($service));
        }
    }
}
