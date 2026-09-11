<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class HomePageTest extends TestCase
{
    public function test_the_home_page_renders_the_full_stack_foundation(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Hello, Fight Laravel Starter');
        $response->assertSee('<title>Fight Laravel Starter</title>', false);
    }
}
