<?php

declare(strict_types=1);

namespace Tests\Feature;

use Fight\Common\Adapter\Messaging\Command\Sync\Routing\InMemoryCommandRouter;
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

    public function test_queued_command_is_held_until_commit_and_delivered_by_laravel_sync_queue(): void
    {
        $handled = [];
        $this->app->make(InMemoryCommandRouter::class)->registerHandler(
            ProfileCommand::class,
            new ProfileCommandHandler($handled),
        );

        DB::transaction(function () use (&$handled): void {
            $this->app->make(AsynchronousCommandBus::class)->execute(new ProfileCommand('queued-command'));

            self::assertSame([], $handled);
        });

        self::assertSame(['queued-command'], $handled);
    }

    public function test_queued_event_is_held_until_commit_and_delivered_with_its_payload(): void
    {
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
        });

        self::assertSame([['reference' => 'queued-event']], $handled);
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
