<?php

declare(strict_types=1);

namespace Tests\Feature;

use Fight\Common\Adapter\Socket\Laravel\LaravelPrivatePublisher;
use Fight\Common\Application\Socket\Publisher;
use Tests\TestCase;

final class FightCommonPrivatePublicationTest extends TestCase
{
    public function test_private_publication_uses_the_laravel_profile_private_topic_convention(): void
    {
        $publisher = new RecordingPublisher;

        new LaravelPrivatePublisher($publisher)->pushPrivate('orders.42', '{"status":"ready"}');

        self::assertSame([['private-orders.42', '{"status":"ready"}']], $publisher->published);
    }
}

final class RecordingPublisher implements Publisher
{
    /** @var list<array{string, string}> */
    public array $published = [];

    public function push(string $topic, string $message): void
    {
        $this->published[] = [$topic, $message];
    }
}
