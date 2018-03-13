<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Jcc\LaravelVote\CanBeVoted;

    /**
     * App\Answer
     *
     * @property int $id
     * @property int $question_id
     * @property int|null $author_id
     * @property string $body
     * @property int $votes
     * @property \Carbon\Carbon|null $created_at
     * @property \Carbon\Carbon|null $updated_at
     * @property string|null $deleted_at *
     * @property-read \App\User|null $user
     * @property-read \App\Question $parent
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $voters
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereAuthorId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereQuestionId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereVotes($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereDeletedAt($value)
     * @mixin \Eloquent
     */
    class Answer extends Model {
        use CanBeVoted;
        protected $vote = User::class;
        protected $fillable = ['body', 'question_id', 'author_id'];

        public function addComment($content, $author_id) {
            Comment::create([
                'body'      => $content,
                'answer_id' => $this->id,
                'author_id' => $author_id,
            ]);
        }

        public function user() {
            return $this->belongsTo(User::class, 'author_id');
        }

        public function parent() {
            return $this->belongsTo(Question::class, 'question_id');
        }

        public function comments() {
            return $this->hasMany(Comment::class);
        }
    }
