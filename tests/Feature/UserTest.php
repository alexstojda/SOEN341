<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    public function testCreateUser()
    {
        factory(User::class, 2)->create();
        $this->assertEquals(2, User::count());

        $this->assertTrue(true);
    }
}
