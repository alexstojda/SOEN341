<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        include 'database/factories/UserFactory.php';
        factory(\App\User::class, 2)->create();
    }

    public function testBasicTest()
    {
        $this->assertEquals(1, User::count());

        $this->assertTrue(true);
    }
}
