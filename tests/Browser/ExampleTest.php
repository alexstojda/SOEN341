<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     * @return void
     */
    public function testBasicExample()
    {
        dump(env('DB_CONNECTION'));

        $user = factory(\App\User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                    ->visit('/home')
                    //->screenshot('example-test-0')
                    ->assertSee($user->name);
        });
    }
}
