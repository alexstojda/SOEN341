<?php

namespace Tests\Browser;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Imgur\Client;
use SebastianBergmann\Environment\Console;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Throwable;

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
            $this->assertEquals(0, $question->countTotalVotes());

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

            $this->assertEquals(0, $answer->countTotalVotes());

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

    protected function onNotSuccessfulTest(Throwable $e)
    {
        if (env('USE_IMGUR') == "imgur") {
            $client = new Client();
            $client->setOption('client_id', '100fc6bc6dd8279');
            $client->setOption('client_secret', '61092279a8d645f46b3b24fdc3af8a7e9eeebc02');

            $path = "./screenshots/";
            fwrite(STDERR, "\n=== A test failed, generated screenshots are: ===\n");
            fwrite(STDERR, getcwd()."\n");
            if ($handle = opendir($path)) {
                while (false !== ($file = readdir($handle))) {
                    if ('.' === $file) continue;
                    if ('..' === $file) continue;
                    if ('.gitignore' === $file) continue;

                    $pathToFile = $path.$file;
                    $imageData = [
                        'image' => base64_encode(file_get_contents($pathToFile)),
                        'type'  => 'base64',
                    ];

                    $response = $client->api('image')->upload($imageData);

                    fwrite(STDERR, "Screenshot: ".$response['link']."\n");

                }
                closedir($handle);
            }
        }
        throw $e;
    }
}
