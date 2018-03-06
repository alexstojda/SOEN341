<?php

namespace Tests\Feature;

use App\Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $question = factory(Question::class)->create();

        $this->assertNotEmpty($user);
        $this->assertNotEmpty($question);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'last_ip' => $user->last_ip,
            'last_login' => $user->last_login
        ]);
        $this->assertDatabaseHas('questions', [
                'author_id' => $question->author_id,
                'body' => $question->body,
                'title' => $question->title
            ]
        );
    }
}
