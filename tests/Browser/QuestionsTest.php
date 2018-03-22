<?php

    namespace Tests\Browser;

    use App\Question;
    use App\User;
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\DuskTestCase;

    /**
     * Class QuestionsTest
     * Test designed to replicate the user question creation process and ensure everything occurs as expected
     *
     * @package Tests\Browser
     */
    class QuestionsTest extends DuskTestCase {
        use DatabaseMigrations;

        /**
         * Creates a question using dusk then checks the backend to ensure its existance
         *
         * @return void
         * @throws \Throwable
         */
        public function testCreateQuestion() {
            // create user
            $user = factory(User::class)->create();

            // create question for this user
            $question = factory(Question::class)->make(['author_id' => $user->id]);

            $this->browse(function($browser) use ($user, $question) {
                // login, create question using dusk
                $browser->loginAs($user)
                    ->visit('/questions/create')
                    ->resize(1920, 1080)
                    ->assertSee('Create Question')
                    ->keys('@title-q', $question->title)
                    ->driver->executeScript("simplemde.value(\"$question->body\")"); //TODO: is there a better way?

                // submit question using dusk
                $browser->screenshot('create-question-0')
                    ->click('@submit-q')
                    ->assertPathIs('/questions')
                    ->screenshot('create-question-1')
                    ->assertSee($question->title);
            });

            // checking the backend is a lot faster than using dusk to open the page and render the same dataset
            $this->assertEquals(1, Question::count());
            $this->assertDatabaseHas('questions',
                ['author_id' => $user->id, 'title' => $question->title, 'body' => $question->body]);
        }
    }
