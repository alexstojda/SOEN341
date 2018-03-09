<?php

    namespace Tests\Feature;

    use App\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    class UserTest extends TestCase {
        use RefreshDatabase;

        public function setUp() {
            parent::setUp();
        }

        public function testCreateUser() {
            factory(User::class, 2)->create();
            $this->assertEquals(2, User::count());

            $this->assertTrue(true);
        }
    }
