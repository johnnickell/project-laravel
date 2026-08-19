<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_home_page_renders_the_full_stack_foundation(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Hello, Fight Laravel Starter');
        $response->assertSee('<title>Fight Laravel Starter</title>', false);
    }
}
