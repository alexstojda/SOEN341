<?php

    namespace Tests\Unit;

    use App\Answer;
    use App\Question;
    use App\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Auth;
    use Tests\TestCase;

    /**
     * Class AnswersApiTest
     *
     * @package Tests\Unit
     */
    class AnswersApiTest extends TestCase {
        use RefreshDatabase;

        /**
         * Test GET answers via questions/id/answers endpoint
         */
        public function testGetAnswersOnQuestion(): void {
            factory(User::class, 5)->create();
            $q = factory(Question::class)->create();
            $a = factory(Answer::class, 10)->create(['question_id' => $q->id])->first();
            $this->get(url("/api/questions/$q->id/answers"))
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $a->body]);
        }

        /**
         * Test GET answer via the answers/id endpoint
         */
        public function testGetAnswer(): void {
            factory(User::class, 5)->create();
            $q = factory(Question::class)->create();
            $a = factory(Answer::class)->create(['question_id' => $q->id]);
            $this->get(url('/api/answers/'.$a->id))
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $a->body]);
        }

        /**
         * Test create an answer via POST questions/id/answer endpoint
         */
        public function testPostAnswer(): void {
            $user = factory(User::class)->create();
            Auth::login($user);
            $q = factory(Question::class)->create();
            $a = factory(Answer::class)->make();
            $this->post(url("/api/questions/$q->id/answer"),
                ['api_token' => $user->api_token, 'body' => $a->body])
                //    ->assertStatus(302);
                //$this->get(url("/api/questions/$q->id/answers"))
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $a->body]);
        }

        /**
         * Test accepting an answer via /answers/id/accept endpoint
         */
        public function testAcceptAnswer(): void {
            $user = factory(User::class)->create();

            $q = factory(Question::class)->create(['author_id' => $user->id]);
            $a = factory(Answer::class)->create(['author_id' => $user->id, 'question_id' => $q->id]);

            //Test Selected Answer
            $this->get(url("/api/answers/$a->id/"))
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $a->body, 'selected' => false]);
            $this->get(url("/api/answers/$a->id/accept?api_token=$user->api_token"))
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $a->body, 'selected' => true]);
            $this->get(url("/api/questions/$q->id/answers"))
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $a->body, 'selected' => true]);
            $this->get(url("/api/questions/$q->id"))
                ->assertStatus(200)
                ->assertJsonFragment(['status' => 'closed']);
        }
    }
