<?php

declare(strict_types=1);

namespace App\Infrastructure\Socket;

use Fight\Common\Application\Socket\PrivatePublisher;
use Fight\Common\Application\Socket\Publisher;

final readonly class LaravelPrivatePublisher implements PrivatePublisher
{
    public function __construct(private Publisher $publisher) {}

    public function pushPrivate(string $topic, string $message): void
    {
        $this->publisher->push('private-'.$topic, $message);
    }
}
