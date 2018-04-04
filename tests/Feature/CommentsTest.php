<?php

    namespace Tests\Feature;

    use App\Answer;
    use App\Comment;
    use App\Question;
    use App\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    class CommentsTest extends TestCase {
        use RefreshDatabase;

        /**
         * test if an comment can be created and stored in the DB
         *
         * @return void
         */
        public function testCommentsCanBeCreated() {
            // create user, without which testing question doesn't work
            $user = factory(User::class)->create();
            // before creating an answer, we must have a question to answer
            $question = factory(Question::class)->create();
            //create an answer
            $answer = factory(Answer::class)->create();
            //comment on the question
            $commentQ = factory(Comment::class)->create(['question_id' => $question->id]);
            //comment on the answer
            $commentA = factory(Comment::class)->create(['answer_id' => $answer->id]);

            $this->assertNotEmpty($user);
            $this->assertNotEmpty($question);
            $this->assertNotEmpty($answer);
            $this->assertNotEmpty($commentQ);
            $this->assertNotEmpty($commentA);

            $this->assertDatabaseHas('users', [
                'name'       => $user->name,
                'email'      => $user->email,
                'password'   => $user->password,
                'last_ip'    => $user->last_ip,
                'last_login' => $user->last_login,
            ]);

            $this->assertDatabaseHas('questions', [
                    'author_id' => $question->author_id,
                    'body'      => $question->body,
                    'title'     => $question->title,
                ]
            );

            $this->assertDatabaseHas('answers', [
                    'author_id'   => $answer->author_id,
                    'question_id' => $answer->question_id,
                    'body'        => $answer->body,
                ]
            );

            $this->assertDatabaseHas('comments', [
                    'author_id'   => $commentQ->author_id,
                    'question_id' => $commentQ->question_id,
                    'body'        => $commentQ->body,
                ]
            );

            $this->assertDatabaseHas('comments', [
                    'author_id' => $commentA->author_id,
                    'answer_id' => $commentA->answer_id,
                    'body'      => $commentA->body,
                ]
            );
        }
    }
