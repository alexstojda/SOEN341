<?php

namespace Tests\Browser;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

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
                ->visit('/questions')
                ->resize(1920, 1080)
                ->click('@question');

            $browser->click("@upvote-q$question->id");
            $this->assertEquals(1, $question->countTotalVotes());
            $browser->click("@upvote-q$question->id");
            $this->assertEquals(0, $question->countTotalVotes());

            $browser->click("@downvote-q$question->id");
            $this->assertEquals(-1, $question->countTotalVotes());
            $browser->click("@downvote-q$question->id");
            $this->assertEquals(0, $question->countTotalVotes());

            $browser->click("@downvote-q$question->id");
            $this->assertEquals(-1, $question->countTotalVotes());
            $browser->click("@upvote-q$question->id");
            $this->assertEquals(1, $question->countTotalVotes());
            $browser->click("@downvote-q$question->id");
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
                ->visit('/questions')
                ->resize(1920, 1080)
                ->click('@question');

            $browser->click("@upvote-a$answer->id");
            $this->assertEquals(1, $answer->countTotalVotes());
            $browser->click("@upvote-a$answer->id");
            $this->assertEquals(0, $answer->countTotalVotes());

            $browser->click("@downvote-a$answer->id");
            $this->assertEquals(-1, $answer->countTotalVotes());
            $browser->click("@downvote-a$answer->id");
            $this->assertEquals(0, $answer->countTotalVotes());

            $browser->click("@downvote-a$answer->id");
            $this->assertEquals(-1, $answer->countTotalVotes());
            $browser->click("@upvote-a$answer->id");
            $this->assertEquals(1, $answer->countTotalVotes());
            $browser->click("@downvote-a$answer->id");
            $this->assertEquals(-1, $answer->countTotalVotes());
        });
    }
}
