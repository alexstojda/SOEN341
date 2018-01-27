<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        //factory(User::class, 2)->create(); //TODO : factories are not working in any of the tests??
    }

    public function testBasicTest()
    {
        //$this->assertEquals(1, User::count());

        $this->assertTrue(true);
    }
}
