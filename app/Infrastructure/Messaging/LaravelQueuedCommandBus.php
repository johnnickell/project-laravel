<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging;

use Fight\Common\Adapter\Messaging\Laravel\QueuedCommandMessage;
use Fight\Common\Application\Messaging\Command\AsynchronousCommandBus;
use Fight\Common\Domain\Messaging\Command\Command;
use Fight\Common\Domain\Messaging\Command\CommandMessage;
use Illuminate\Contracts\Bus\Dispatcher;

final readonly class LaravelQueuedCommandBus implements AsynchronousCommandBus
{
    public function __construct(private Dispatcher $dispatcher) {}

    public function execute(Command $command): void
    {
        $this->dispatch(CommandMessage::create($command));
    }

    public function dispatch(CommandMessage $commandMessage): void
    {
        $this->dispatcher->dispatch(new QueuedCommandMessage($commandMessage));
    }
}
