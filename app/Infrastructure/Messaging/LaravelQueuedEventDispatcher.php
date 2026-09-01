<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging;

use Fight\Common\Adapter\Messaging\Laravel\QueuedEventMessage;
use Fight\Common\Application\Messaging\Event\AsynchronousEventDispatcher;
use Fight\Common\Application\Messaging\Event\EventSubscriber;
use Fight\Common\Application\Messaging\Event\SynchronousEventDispatcher;
use Fight\Common\Domain\Messaging\Event\Event;
use Fight\Common\Domain\Messaging\Event\EventMessage;
use Illuminate\Contracts\Bus\Dispatcher;

final readonly class LaravelQueuedEventDispatcher implements AsynchronousEventDispatcher
{
    public function __construct(
        private Dispatcher $dispatcher,
        private SynchronousEventDispatcher $synchronous,
    ) {}

    public function trigger(Event $event): void
    {
        $this->dispatch(EventMessage::create($event));
    }

    public function dispatch(EventMessage $eventMessage): void
    {
        $this->dispatcher->dispatch(new QueuedEventMessage($eventMessage));
    }

    public function register(EventSubscriber $subscriber): void
    {
        $this->synchronous->register($subscriber);
    }

    public function unregister(EventSubscriber $subscriber): void
    {
        $this->synchronous->unregister($subscriber);
    }

    public function addHandler(string $eventType, callable $handler, int $priority = 0): void
    {
        $this->synchronous->addHandler($eventType, $handler, $priority);
    }

    public function getHandlers(?string $eventType = null): array
    {
        return $this->synchronous->getHandlers($eventType);
    }

    public function hasHandlers(?string $eventType = null): bool
    {
        return $this->synchronous->hasHandlers($eventType);
    }

    public function removeHandler(string $eventType, callable $handler): void
    {
        $this->synchronous->removeHandler($eventType, $handler);
    }
}
