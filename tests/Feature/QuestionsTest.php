<?php

namespace Tests\Feature;

use App\Question;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test if a question can be created in the DB
     *
     * @return void
     */
    public function testQuestionsCanBeCreated()
    {
        // create user, without which testing question doesn't work
        $user = factory(User::class)->create();

        // create question
        $question = factory(Question::class)->create();

        // sanity checks
        $this->assertNotEmpty($user);
        $this->assertNotEmpty($question);

        // check that everything was saved in the DB
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'last_ip' => $user->last_ip,
            'last_login' => $user->last_login,
        ]);
        
        $this->assertDatabaseHas('questions', [
                'author_id' => $question->author_id,
                'body' => $question->body,
                'title' => $question->title,
            ]
        );
    }
}
