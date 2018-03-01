<?php

namespace Tests\Browser;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class VoteTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testQuestionVote()
    {
        $user = factory(User::class)->create();
        $question = factory(Question::class)->create();

        $this->browse(function (Browser $browser) use ($question, $user) {
            $browser->loginAs($user)
                ->resize(1920, 1080);
            $browser->visit('/questions')
                ->click("@question-$question->id")
                ->click('@upvote-button');

            $this->assertEquals(1, $question->countTotalVotes());

            $browser->click('@upvote-button');
            $this->assertEquals(0, $question->countTotalVotes());

            $browser->click('@downvote-button');
            $this->assertEquals(-1, $question->countTotalVotes());

            $browser->click('@downvote-button');
            $this->assertEquals(0, $question->countTotalVotes());

            $browser->click('@downvote-button');
            $this->assertEquals(-1, $question->countTotalVotes());
            $browser->click('@upvote-button');
            $this->assertEquals(1, $question->countTotalVotes());
            $browser->click('@downvote-button');
            $this->assertEquals(-1, $question->countTotalVotes());

        });

    }

    /**
     * A basic browser test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testAnswerVote()
    {
        $user = factory(User::class)->create();

        $question = factory(Question::class)->create();
        $answer = factory(Answer::class)->create();

        $this->browse(function (Browser $browser) use ($question, $user, $answer) {
            $browser->loginAs($user)
                ->resize(1920, 1080);
            $browser->visit('/questions')
                ->click("@question-$question->id")
                ->click("@upvote-button-$answer->id");

            $this->assertEquals(1, $answer->countTotalVotes());

            $browser->click("@upvote-button-$answer->id");
            $this->assertEquals(0, $answer->countTotalVotes());

            $browser->click("@downvote-button-$answer->id");
            $this->assertEquals(-1, $answer->countTotalVotes());

            $browser->click("@downvote-button-$answer->id");
            $this->assertEquals(0, $answer->countTotalVotes());

            $browser->click("@downvote-button-$answer->id");
            $this->assertEquals(-1, $answer->countTotalVotes());
            $browser->click("@upvote-button-$answer->id");
            $this->assertEquals(1, $answer->countTotalVotes());
            $browser->click("@downvote-button-$answer->id");
            $this->assertEquals(-1, $answer->countTotalVotes());


        });
    }
}
