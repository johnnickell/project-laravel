<?php

declare(strict_types=1);

namespace Tests\Feature;

use Fight\Common\Adapter\Messaging\Command\Sync\Routing\InMemoryCommandRouter;
use Fight\Common\Adapter\Messaging\Laravel\LaravelCommandBus;
use Fight\Common\Adapter\Messaging\Laravel\LaravelEventDispatcher;
use Fight\Common\Application\Messaging\Command\AsynchronousCommandBus;
use Fight\Common\Application\Messaging\Command\CommandBus;
use Fight\Common\Application\Messaging\Command\CommandHandler;
use Fight\Common\Application\Messaging\Event\AsynchronousEventDispatcher;
use Fight\Common\Application\Messaging\Event\EventDispatcher;
use Fight\Common\Domain\Messaging\Command\Command;
use Fight\Common\Domain\Messaging\Command\CommandMessage;
use Fight\Common\Domain\Messaging\Event\Event;
use Fight\Common\Domain\Messaging\Event\EventMessage;
use Fight\Common\Domain\Utility\ClassName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

final class FightCommonMessagingJourneyTest extends TestCase
{
    public function test_synchronous_command_bus_routes_a_command_to_its_registered_handler(): void
    {
        $handled = [];
        $this->app->make(InMemoryCommandRouter::class)->registerHandler(
            ProfileCommand::class,
            new ProfileCommandHandler($handled),
        );

        $this->app->make(CommandBus::class)->execute(new ProfileCommand('sync-command'));

        self::assertSame(['sync-command'], $handled);
    }

    public function test_queued_command_is_persisted_after_commit_then_delivered_by_a_laravel_database_worker(): void
    {
        $this->prepareDatabaseQueue();
        self::assertInstanceOf(LaravelCommandBus::class, $this->app->make(AsynchronousCommandBus::class));
        $handled = [];
        $this->app->make(InMemoryCommandRouter::class)->registerHandler(
            ProfileCommand::class,
            new ProfileCommandHandler($handled),
        );

        DB::transaction(function () use (&$handled): void {
            $this->app->make(AsynchronousCommandBus::class)->execute(new ProfileCommand('queued-command'));

            self::assertSame([], $handled);
            self::assertSame(0, DB::table('jobs')->count());
        });

        self::assertSame(1, DB::table('jobs')->count());
        $this->artisan('queue:work', ['connection' => 'database', '--once' => true, '--tries' => 1])->assertExitCode(0);
        self::assertSame(0, DB::table('jobs')->count());
        self::assertSame(['queued-command'], $handled);
    }

    public function test_queued_event_is_persisted_after_commit_then_delivered_by_a_laravel_database_worker(): void
    {
        $this->prepareDatabaseQueue();
        self::assertInstanceOf(LaravelEventDispatcher::class, $this->app->make(AsynchronousEventDispatcher::class));
        $handled = [];
        $this->app->make(EventDispatcher::class)->addHandler(
            ClassName::underscore(ProfileEvent::class),
            static function (EventMessage $message) use (&$handled): void {
                $handled[] = $message->payload()->toArray();
            },
        );

        DB::transaction(function () use (&$handled): void {
            $this->app->make(AsynchronousEventDispatcher::class)->trigger(new ProfileEvent('queued-event'));

            self::assertSame([], $handled);
            self::assertSame(0, DB::table('jobs')->count());
        });

        self::assertSame(1, DB::table('jobs')->count());
        $this->artisan('queue:work', ['connection' => 'database', '--once' => true, '--tries' => 1])->assertExitCode(0);
        self::assertSame(0, DB::table('jobs')->count());
        self::assertSame([['reference' => 'queued-event']], $handled);
    }

    private function prepareDatabaseQueue(): void
    {
        config(['queue.default' => 'database']);
        Schema::dropIfExists('jobs');
        Schema::create('jobs', static function ($table): void {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });
    }
}

final readonly class ProfileCommand implements Command
{
    public function __construct(private string $reference) {}

    public static function fromArray(array $data): static
    {
        return new self($data['reference']);
    }

    public function toArray(): array
    {
        return ['reference' => $this->reference];
    }
}

final class ProfileCommandHandler implements CommandHandler
{
    /** @var list<string> */
    private array $handled;

    /** @param list<string> $handled */
    public function __construct(array &$handled)
    {
        $this->handled = &$handled;
    }

    public static function commandRegistration(): string
    {
        return ProfileCommand::class;
    }

    public function handle(CommandMessage $commandMessage): void
    {
        $this->handled[] = $commandMessage->payload()->toArray()['reference'];
    }
}

final readonly class ProfileEvent implements Event
{
    public function __construct(private string $reference) {}

    public static function fromArray(array $data): static
    {
        return new self($data['reference']);
    }

    public function toArray(): array
    {
        return ['reference' => $this->reference];
    }
}
