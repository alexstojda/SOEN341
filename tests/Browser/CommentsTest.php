<?php

    namespace Tests\Browser;

    use App\User;
    use App\Question;
    use App\Answer;
    use App\Comment;
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Laravel\Dusk\Browser;
    use Tests\DuskTestCase;

    class CommentsTest extends DuskTestCase {

        use DatabaseMigrations;

        /**
         * Test adding a comment on a question via dusk
         *
         * @throws \Throwable
         * @return void
         */
        public function testCommentOnQuestion() {
            $user = factory(User::class)->create();
            $q = factory(Question::class)->create();
            $c = factory(Comment::class)->make(['body' => 'Testing Writing to comment from dusk']);

            $this->browse(function(Browser $browser) use ($user, $q, $c) {
                $browser->loginAs($user)
                    ->resize(1920, 1080)
                    ->visit('/questions/'.$q->id)
                    ->waitForText($q->body, 5)
                    ->screenshot('comments-0')
                    ->press('Comment')//->click('div#question-container > div.row > div#comments-container > button')
                    //->waitFor("#q$q->id-comment-body", 5)
                    ->type("#q$q->id-comment-body", $c->body)
                    ->screenshot('comments-1')
                    ->press('Send')
                    ->waitForText($c->body)
                    ->screenshot('comments-2');

                $this->assertDatabaseHas('comments', ['body' => $c->body]);
            });
        }

        /**
         * Test adding a comment on an answer via dusk
         *
         * @throws \Throwable
         * @return void
         */
        public function testCommentOnAnswer() {
            $user = factory(User::class, 4)->create()->first();
            $q = factory(Question::class)->create(['author_id' => $user->id]);
            $a = factory(Answer::class)->create(['question_id' => $q->id]);
            $c = factory(Comment::class)->make(['answer_id' => $a->id]);

            $this->browse(function(Browser $browser) use ($user, $q, $a, $c) {
                $browser->loginAs($user)
                    ->resize(1920, 1080)
                    ->visit('/questions/'.$q->id)
                    ->waitForText($q->body, 5)
                    ->screenshot('comments-answer-0')
                    ->click("div#a-$a->id-comments.row > div#comments-container > button")
                    //->waitFor("#q$q->id-comment-body", 5)
                    ->type("#a$a->id-comment-body", $c->body)
                    ->screenshot('comments-answer-1')
                    ->press('Send')
                    ->waitForText($c->body)
                    ->screenshot('comments-answer-2');

                $this->assertDatabaseHas('comments', ['body' => $c->body]);
            });
        }

        /**
         * List Comments from API
         *
         * @throws \Throwable
         */
        public function testCommentsApi() {
            //CREATE NEEDED DB OBJECTS
            $user = factory(User::class, 4)->create()->first();
            $question = factory(Question::class)->create(['author_id' => $user->id]);
            $answer = factory(Answer::class)->create(['question_id' => $question->id]);
            $commentQ = factory(Comment::class)->create(['question_id' => $question->id]);
            $commentA = factory(Comment::class)->create(['answer_id' => $answer->id]);

            $this->browse(function($browser) use ($question, $answer, $commentQ, $commentA) {
                //TEST QUESTIONS
                $browser->visit("/api/questions/$question->id/comments")
                    ->assertSee($commentQ->body)
                    ->screenshot('comments-api-0')
                    ->visit('/api/comments/'.$commentQ->id)
                    ->assertSee($commentQ->body)
                    ->assertSee($commentQ->question_id)
                    ->screenshot('comments-api-1');
                //TEST with ANSWERS
                $browser->visit("/api/answers/$answer->id/comments")
                    ->assertSee($commentA->body)
                    ->screenshot('comments-api-2')
                    ->visit('/api/comments/'.$commentA->id)
                    ->assertSee($commentA->body)
                    ->assertSee($commentA->answer_id)
                    ->screenshot('comments-api-3');
            });
        }
    }