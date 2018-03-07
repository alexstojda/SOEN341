<?php

namespace Tests\Feature;

use App\Answer;
use App\User;
use App\Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * test if an answer can be created and stored in the DB
     *
     * @return void
     */
    public function testAnswersCanBeCreated()
    {
        // create user, without which testing question doesn't work
        $user = factory(User::class)->create();
        // before creating an answer, we must have a question to answer
        $question = factory(Question::class)->create();
        $answer = factory(Answer::class)->create();

        $this->assertNotEmpty($user);
        $this->assertNotEmpty($question);
        $this->assertNotEmpty($answer);

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

        $this->assertDatabaseHas('answers', [
                'author_id' => $answer->author_id,
                'question_id' => $answer->question_id,
                'body' => $answer->body
            ]
        );
    }
}
