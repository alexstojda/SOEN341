<?php

    namespace Tests\Browser;

    use App\Answer;
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
            // make test answer
            $answer = factory(Answer::class)->make(['question_id' => $question->id]);

            // sanity check
            $this->assertNotEmpty($user);
            $this->assertNotEmpty($question);

            // now use dusk to create answer
            $this->browse(function($browser) use ($user, $question, $answer) {
                $browser->loginAs($user)
                    ->visit("/questions/$question->id")
                    ->assertPathIs("/questions/$question->id")
                    ->resize(1920, 1080)
                    ->assertSee('Answer')
                    ->screenshot('create-answer-0')
                    ->driver->executeScript("Vue.simplemde.value(\"$answer->body\")"); //TODO: is there a better way?

                $browser->press('Answer')
                    ->waitForText($answer->body)
                    ->assertSee($answer->body)
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
                    'body'        => $answer->body,
                ]
            );
        }

        /**
         * List Answers from API //REPLACED BY API UNIT TESTS
         *
         * @throws \Throwable
         */
        /*public function testAnswersApi() {
            $user = factory(User::class)->create();
            $question = factory(Question::class)->create(['author_id' => $user->id]);
            $answer = factory(Answer::class)->create(['author_id' => $user->id, 'question_id' => $question->id]);

            $this->browse(function($browser) use ($user, $question, $answer) {
                $browser->visit("/api/questions/$question->id/answers")
                    ->assertSee($answer->body)
                    ->screenshot('answers-api-0')
                    ->visit('/api/answers/'.$answer->id)
                    ->assertSee($answer->body)
                    ->assertSee($answer->question_id)
                    ->screenshot('answers-api-1');
            });
        }*/
    }