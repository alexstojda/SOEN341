<?php

namespace Tests\Browser;

use App\Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Route;

class QuestionsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testCreateQuestion()
    {
        $user = factory(User::class)->create();

        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/questions')
                ->click('@create-q')
                ->resize(1920, 1080)
                ->screenshot('create-question-0')
                ->assertPathIs('//questions/create')
                ->assertSee('Create Question')
                ->keys('@title-q', 'How to write a browser test?')
                ->screenshot('create-question-1');

            $browser->driver->executeScript('simplemde.value("using Dusk")');

//            echo(Question::count());
//            $URL = $browser->driver->getCurrentURL();
//            echo($URL);

            $browser->screenshot('create-question-2')
                ->click('@submit-q')
                ->screenshot('create-question-3')
                ->assertSee('How to write a browser test?')
                ->assertPathIs('/questions')
                ->click('@question')
                ->screenshot('create-question-4')
                ->assertSee('How to write a browser test?')
                ->assertSee('using Dusk');

            $this->assertRegExp("/http:\/\/soen341\.oo\/questions\/\d+/", $browser->driver->getCurrentURL());
        });
    }
}
