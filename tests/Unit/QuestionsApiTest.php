<?php

    namespace Tests\Unit;

    use App\Question;
    use App\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Auth;
    use Tests\TestCase;

    /**
     * Class QuestionsApiTest
     *
     * @package Tests\Unit
     */
    class QuestionsApiTest extends TestCase {
        use RefreshDatabase;

        /**
         * creates multiple questions and tests the questions endpoint
         */
        public function testGetAllQuestions(): void {
            factory(User::class, 5)->create();
            $question = factory(Question::class, 6)->create()->first();
            $this->get(url('/api/questions'))
                ->assertStatus(200)
                ->assertJsonFragment(['title' => $question->title]);
        }

        /**
         * Creates a question and attempts to check its individual endpoint
         */
        public function testGetQuestion(): void {
            factory(User::class, 10)->create();
            $question = factory(Question::class, 10)->create()->last();
            $this->get(url('/api/questions/'.$question->id))
                ->assertStatus(200)
                ->assertJsonFragment(['title' => $question->title]);
        }

        /**
         * Test creating a question via the questions POST endpoint
         */
        public function testPostQuestion(): void {
            $user = factory(User::class)->create();
            Auth::login($user);
            factory(Question::class)->create();
            $question = factory(Question::class)->make(['author_id' => $user->id]);
            $this->post(url('/api/questions/'),
                ['api_token' => $user->api_token, 'title' => $question->title, 'body' => $question->body])
            //    ->assertStatus(302);
            //$this->get(url('/api/questions'))
                ->assertStatus(200)
                ->assertJsonFragment(['title' => $question->title]);
        }
    }
