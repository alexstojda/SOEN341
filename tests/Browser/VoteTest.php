<?php

    namespace Tests\Browser;

    use App\Answer;
    use App\Question;
    use App\User;
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Laravel\Dusk\Browser;
    use Tests\DuskTestCase;

    class VoteTest extends DuskTestCase {
        use DatabaseMigrations;

        /**
         * A basic browser test example.
         *
         * @return void
         * @throws \Throwable
         */
        public function testQuestionVote() {
            $user = factory(User::class)->create();
            $question = factory(Question::class)->create();

            $this->browse(function(Browser $browser) use ($question, $user) {
                $wait = 500; //wait time in ms, might need to fiddle with it to ensure travis pass

                $browser->loginAs($user)
                    ->visit('/questions')
                    ->resize(1920, 1080)
                    ->click('@question');

                $browser->waitFor("@upvote-q$question->id",10);

                $browser->click("@upvote-q$question->id")->pause($wait);
                $this->assertEquals(1, $question->countTotalVotes());
                $browser->click("@upvote-q$question->id")->pause($wait);
                $this->assertEquals(0, $question->countTotalVotes());

                $browser->click("@downvote-q$question->id")->pause($wait);
                $this->assertEquals(-1, $question->countTotalVotes());
                $browser->click("@downvote-q$question->id")->pause($wait);
                $this->assertEquals(0, $question->countTotalVotes());

                $browser->click("@downvote-q$question->id")->pause($wait);
                $this->assertEquals(-1, $question->countTotalVotes());
                $browser->click("@upvote-q$question->id")->pause($wait);
                $this->assertEquals(1, $question->countTotalVotes());
                $browser->click("@downvote-q$question->id")->pause($wait);
                $this->assertEquals(-1, $question->countTotalVotes());
            });
        }

        /**
         * A basic browser test example.
         *
         * @return void
         * @throws \Throwable
         */
        public function testAnswerVote() {
            $user = factory(User::class)->create();
            $question = factory(Question::class)->create();
            $answer = factory(Answer::class)->create();

            $this->browse(function(Browser $browser) use ($question, $user, $answer) {
                $wait = 500; //wait time in ms, might need to fiddle with it to ensure travis pass

                $browser->loginAs($user)
                    ->visit('/questions')
                    ->resize(1920, 1080)
                    ->click('@question');

                $browser->waitFor("@upvote-a$answer->id",10);

                $browser->click("@upvote-a$answer->id")->pause($wait);
                $this->assertEquals(1, $answer->countTotalVotes());
                $browser->click("@upvote-a$answer->id")->pause($wait);
                $this->assertEquals(0, $answer->countTotalVotes());

                $browser->click("@downvote-a$answer->id")->pause($wait);
                $this->assertEquals(-1, $answer->countTotalVotes());
                $browser->click("@downvote-a$answer->id")->pause($wait);
                $this->assertEquals(0, $answer->countTotalVotes());

                $browser->click("@downvote-a$answer->id")->pause($wait);
                $this->assertEquals(-1, $answer->countTotalVotes());
                $browser->click("@upvote-a$answer->id")->pause($wait);
                $this->assertEquals(1, $answer->countTotalVotes());
                $browser->click("@downvote-a$answer->id")->pause($wait);
                $this->assertEquals(-1, $answer->countTotalVotes());
            });
        }
    }
