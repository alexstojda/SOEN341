<?php

    namespace Tests\Browser;

    use App\Answer;
    use App\Question;
    use App\User;
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Laravel\Dusk\Browser;
    use Tests\DuskTestCase;

    /**
     * Class VoteTest
     * Creates votable models and follows the user process for voting on these models to ensure its functionality
     *
     * @package Tests\Browser
     */
    class VoteTest extends DuskTestCase {
        use DatabaseMigrations;

        private const wait = 500; //wait time in ms, 500ms works on travis but for local you might need to up it temporarily

        /**
         * Creates a question and uses dusk to test the vote actions on questions
         *
         * @return void
         * @throws \Throwable
         */
        public function testQuestionVote() {
            $user = factory(User::class)->create();
            $question = factory(Question::class)->create();

            $this->browse(function(Browser $browser) use ($question, $user) {
                $browser->loginAs($user)
                    ->visit('/questions')
                    ->resize(1920, 1080)
                    ->click('@question');

                $browser->waitFor("@upvote-q$question->id",5);

                $browser->click("@upvote-q$question->id")->pause(self::wait);
                $this->assertEquals(1, $question->countTotalVotes());
                $browser->click("@upvote-q$question->id")->pause(self::wait);
                $this->assertEquals(0, $question->countTotalVotes());

                $browser->click("@downvote-q$question->id")->pause(self::wait);
                $this->assertEquals(-1, $question->countTotalVotes());
                $browser->click("@downvote-q$question->id")->pause(self::wait);
                $this->assertEquals(0, $question->countTotalVotes());

                $browser->click("@downvote-q$question->id")->pause(self::wait);
                $this->assertEquals(-1, $question->countTotalVotes());
                $browser->click("@upvote-q$question->id")->pause(self::wait);
                $this->assertEquals(1, $question->countTotalVotes());
                $browser->click("@downvote-q$question->id")->pause(self::wait);
                $this->assertEquals(-1, $question->countTotalVotes());
            });
        }

        /**
         * Creates an answer and uses dusk to test the vote actions on it
         *
         * @return void
         * @throws \Throwable
         */
        public function testAnswerVote() {
            $user = factory(User::class)->create();
            $question = factory(Question::class)->create();
            $answer = factory(Answer::class)->create();

            $this->browse(function(Browser $browser) use ($question, $user, $answer) {
                $browser->loginAs($user)
                    ->visit('/questions')
                    ->resize(1920, 1080)
                    ->click('@question');

                $browser->waitFor("@upvote-a$answer->id",5);

                $browser->click("@upvote-a$answer->id")->pause(self::wait);
                $this->assertEquals(1, $answer->countTotalVotes());
                $browser->click("@upvote-a$answer->id")->pause(self::wait);
                $this->assertEquals(0, $answer->countTotalVotes());

                $browser->click("@downvote-a$answer->id")->pause(self::wait);
                $this->assertEquals(-1, $answer->countTotalVotes());
                $browser->click("@downvote-a$answer->id")->pause(self::wait);
                $this->assertEquals(0, $answer->countTotalVotes());

                $browser->click("@downvote-a$answer->id")->pause(self::wait);
                $this->assertEquals(-1, $answer->countTotalVotes());
                $browser->click("@upvote-a$answer->id")->pause(self::wait);
                $this->assertEquals(1, $answer->countTotalVotes());
                $browser->click("@downvote-a$answer->id")->pause(self::wait);
                $this->assertEquals(-1, $answer->countTotalVotes());
            });
        }
    }
