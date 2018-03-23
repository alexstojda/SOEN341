<?php

    namespace Tests\Unit;

    use App\Question;
    use App\Answer;
    use App\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    /**
     * Class VotesApiTest
     *
     * @package Tests\Unit
     */
    class VotesApiTest extends TestCase {
        use RefreshDatabase;

        /**
         * Test voting on a question via all the voting endpoints
         */
        public function testPostVoteOnQuestion(): void {
            $user = factory(User::class)->create();
            $q = factory(Question::class)->create();
            $url = "/api/questions/$q->id";
            //up and cancel
            $this->get(url("$url/votes"))
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 0]);
            $this->post(url("$url/upvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 1, 'up' => 1]);
            $this->post(url("$url/upvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 0, 'up' => 0]);
            //down and cancel
            $this->post(url("$url/downvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => -1, 'down' => 1]);
            $this->post(url("$url/downvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 0, 'down' => 0]);
            // down up down
            $this->post(url("$url/downvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => -1, 'down' => 1]);
            $this->post(url("$url/upvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 1, 'up' => 1]);
            $this->post(url("$url/downvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => -1, 'down' => 1]);

            $this->get(url("$url/votes"))
                ->assertStatus(200)
                ->assertJsonFragment(['total' => -1]);
        }

        /**
         * Test voting on an answer via all the voting endpoints
         */
        public function testPostVoteOnAnswer(): void {
            $user = factory(User::class)->create();
            $q = factory(Question::class)->create();
            $a = factory(Answer::class)->create(['question_id' => $q->id]);
            $url = "/api/answers/$a->id";
            //up and cancel
            $this->get(url("$url/votes"))
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 0]);
            $this->post(url("$url/upvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 1, 'up' => 1]);
            $this->post(url("$url/upvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 0, 'up' => 0]);
            // down and cancel
            $this->post(url("$url/downvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => -1, 'down' => 1]);
            $this->post(url("$url/downvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 0, 'down' => 0]);
            //down up down
            $this->post(url("$url/downvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => -1, 'down' => 1]);
            $this->post(url("$url/upvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => 1, 'up' => 1]);
            $this->post(url("$url/downvote"), ['api_token' => $user->api_token])
                ->assertStatus(200)
                ->assertJsonFragment(['total' => -1, 'down' => 1]);

            $this->get(url("$url/votes"))
                ->assertStatus(200)
                ->assertJsonFragment(['total' => -1]);
        }
    }