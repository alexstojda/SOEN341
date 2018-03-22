<?php

namespace Tests\Feature;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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

        // create answer
        $answer = factory(Answer::class)->create();

        // sanity checks
        $this->assertNotEmpty($user);
        $this->assertNotEmpty($question);
        $this->assertNotEmpty($answer);

        // check if everything was saved in the DB
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

        $this->assertDatabaseHas('answers', [
                'author_id' => $answer->author_id,
                'question_id' => $answer->question_id,
                'body' => $answer->body,
            ]
        );
    }

    public function testAnswersCanBeAccepted() {
        // create user
        $user = factory(User::class)->create();

        // create question by user
        $question = factory(Question::class)->create(['author_id' => $user->id, 'status' => 'open']);

        // create answer by user to be accepted by user
        $goodAnswer = factory(Answer::class)->create(['author_id' => $user->id, 'question_id' => $question->id]);

        // create answer by user not to be accepted
        $badAnswer = factory(Answer::class)->create(['author_id' => $user->id, 'question_id' => $question->id]);

        // accept the good answer
        $question->acceptAnswer($user->id, $goodAnswer->id);

        // check if good answer is accepted
        $this->assertTrue($goodAnswer->id === $question->answer_id);

        // check if bad answer is not accepted
        $this->assertNotTrue($badAnswer->id === $question->answer_id);
    }
}
