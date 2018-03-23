<?php

    namespace Tests\Unit;

    use App\Answer;
    use App\Question;
    use App\Comment;
    use App\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    /**
     * Class CommentsApiTest
     *
     * @package Tests\Unit
     */
    class CommentsApiTest extends TestCase {
        use RefreshDatabase;

        /**
         * Test GET comments via questions/id/comments endpoint
         */
        public function testGetCommentsOnQuestion(): void {
            factory(User::class, 5)->create();
            $q = factory(Question::class)->create();
            $c = factory(Comment::class, 10)->create(['question_id' => $q->id])->first();
            $this->get(url("/api/questions/$q->id/comments"))
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $c->body]);
        }
        /**
         * Test GET comments via answers/id/comments endpoint
         */
        public function testGetCommentsOnAnswer(): void {
            factory(User::class, 5)->create();
            $q = factory(Question::class)->create();
            $a = factory(Answer::class)->create(['question_id' => $q->id]);
            $c = factory(Comment::class, 10)->create(['answer_id' => $a->id])->first();
            $this->get(url("/api/answers/$a->id/comments"))
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $c->body]);
        }

        /**
         * Test GET comment via the comments/id endpoint
         */
        public function testGetComment(): void {
            factory(User::class)->create();
            $q = factory(Question::class)->create();
            $c = factory(Comment::class)->create(['question_id' => $q->id]);
            $this->get(url('/api/comments/'.$c->id))
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $c->body]);
        }

        /**
         * Test create an comment via POST questions/id/comment endpoint
         */
        public function testPostCommentOnQuestion(): void {
            $user = factory(User::class)->create();
            $q = factory(Question::class)->create();
            $c = factory(Comment::class)->make(['question_id' => $q->id]);
            $this->post(url("/api/questions/$q->id/comment"),
                ['api_token' => $user->api_token, 'body' => $c->body])
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $c->body]);
        }
        /**
         * Test create an comment via POST answers/id/comment endpoint
         */
        public function testPostCommentOnAnswer(): void {
            $user = factory(User::class)->create();
            $q = factory(Question::class)->create();
            $a = factory(Answer::class)->create(['question_id' => $q->id]);
            $c = factory(Comment::class)->make(['answer_id' => $a->id]);
            $this->post(url("/api/answers/$a->id/comment"),
                ['api_token' => $user->api_token, 'body' => $c->body])
                ->assertStatus(200)
                ->assertJsonFragment(['body' => $c->body]);
        }
    }
