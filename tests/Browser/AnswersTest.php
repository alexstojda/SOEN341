<?php

namespace Tests\Browser;

use App\Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

/**
 * Class AnswersTest
 * Test designed to replicate the user answer creation process and ensure everything occurs as expected
 *
 * @package Tests\Browser
 */
class AnswersTest extends DuskTestCase {
    use DatabaseMigrations;

    /**
     * Creates a question using factory,
     * then creates an answer using dusk and checks the backend to ensure its existance
     *
     * @return void
     * @throws \Throwable
     */
    public function testCreateAnswer() {
        // create user
        $user = factory(User::class)->create();
        // create question for user
        $question = factory(Question::class)->create(['author_id' => $user->id]);

        // sanity check
        $this->assertNotEmpty($user);
        $this->assertNotEmpty($question);

        // now use dusk to create answer
        $this->browse(function($browser) use ($user, $question) {
            $answerPlaceHolder = 'Type here...';

            $browser->loginAs($user)
                ->visit("/questions/$question->id")
                ->assertPathIs("/questions/$question->id")
                ->resize(1920, 1080)
                ->assertSee('Answer');

            $browser->screenshot('create-answer-0')
                ->press('Answer')
                ->waitForText($answerPlaceHolder)
                ->assertSee($answerPlaceHolder)
                ->screenshot('create-answer-1');
        });

        // make sure everything is in DB
        $this->assertDatabaseHas('users', [
            'name'       => $user->name,
            'email'      => $user->email,
            'password'   => $user->password,
            'last_ip'    => $user->last_ip,
            'last_login' => $user->last_login,
        ]);

        $this->assertDatabaseHas('questions', [
                'author_id' => $question->author_id,
                'body'      => $question->body,
                'title'     => $question->title,
            ]
        );

        $this->assertDatabaseHas('answers', [
                'author_id'   => $question->author_id,
                'question_id' => $question->id,
                'body'        => 'Type here...',
            ]
        );
    }
}