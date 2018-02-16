<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        dump(env('DB_CONNECTION'));
        dump(env('DEBUGBAR_ENABLED'));
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
