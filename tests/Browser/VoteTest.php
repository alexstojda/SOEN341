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
            $browser->loginAs($user);
            $browser->visit('/questions')
                ->resize(1920, 1080)
                ->click("@question-".$question->id);
            $browser->click('@upvote-button-'.$question->id);
            $this->assertEquals(1, $question->countTotalVotes());

            $browser->click('@upvote-button-'.$question->id);
            $this->assertEquals(0, $question->countTotalVotes());

            $browser->click('@downvote-button-'.$question->id);
            $this->assertEquals(-1, $question->countTotalVotes());

            $browser->click('@downvote-button-'.$question->id);
            $this->assertEquals(0, $question->countTotalVotes());

            $browser->click('@downvote-button-'.$question->id);
            $this->assertEquals(-1, $question->countTotalVotes());
            $browser->click('@upvote-button-'.$question->id);
            $this->assertEquals(1, $question->countTotalVotes());
            $browser->click('@downvote-button-'.$question->id);
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
            $browser->loginAs($user);
            $browser->visit('/questions')
                ->resize(1920, 1080)
                ->click("@question-".$question->id)
                ->screenshot("before-button")
                ->click("@upvote-button-a".$answer->id)
                ->screenshot("after-button");

            $this->assertEquals(1, $answer->countTotalVotes());

            $browser->click("@upvote-button-a".$answer->id);
            $this->assertEquals(0, $answer->countTotalVotes());

            $browser->click("@downvote-button-a".$answer->id);
            $this->assertEquals(-1, $answer->countTotalVotes());

            $browser->click("@downvote-button-a".$answer->id);
            $this->assertEquals(0, $answer->countTotalVotes());

            $browser->click("@downvote-button-a".$answer->id);
            $this->assertEquals(-1, $answer->countTotalVotes());
            $browser->click("@upvote-button-a".$answer->id);
            $this->assertEquals(1, $answer->countTotalVotes());
            $browser->click("@downvote-button-a".$answer->id);
            $this->assertEquals(-1, $answer->countTotalVotes());


        });
    }
}
