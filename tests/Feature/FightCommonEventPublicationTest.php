<?php

declare(strict_types=1);

namespace Tests\Feature;

use Fight\Common\Application\EventSourcing\ProjectionCheckpointStore;
use Fight\Common\Application\EventSourcing\PublicationCursorStore;
use Fight\Common\Application\EventSourcing\PublicationFailureRecorder;
use Tests\TestCase;

final class FightCommonEventPublicationTest extends TestCase
{
    public function test_event_publication_runner_state_stores_are_composed_by_default(): void
    {
        $checkpoints = $this->app->make(ProjectionCheckpointStore::class);
        self::assertSame(0, $checkpoints->load('profile-projector'));
        $checkpoints->save('profile-projector', 7);
        self::assertSame(7, $checkpoints->load('profile-projector'));

        $cursors = $this->app->make(PublicationCursorStore::class);
        self::assertSame(0, $cursors->load('profile-publication'));
        $cursors->save('profile-publication', 11);
        self::assertSame(11, $cursors->load('profile-publication'));

        self::assertSame([], $this->app->make(PublicationFailureRecorder::class)->failures());
    }
}
