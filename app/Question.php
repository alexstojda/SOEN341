<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Jcc\LaravelVote\CanBeVoted;

    /**
     * App\Question
     *
     * @property int                                                          $id
     * @property int|null                                                     $author_id
     * @property string                                                       $title
     * @property string                                                       $body
     * @property int|null                                                     $answer_id
     * @property string                                                       $status
     * @property \Carbon\Carbon|null                                          $created_at
     * @property \Carbon\Carbon|null                                          $updated_at
     * @property string|null                                                  $deleted_at
     * @property-read \App\User|null                                          $user
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]    $voters
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Answer[]  $answers
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereAnswerId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereAuthorId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDeletedAt($value)
     * @mixin \Eloquent
     */
    class Question extends Model {
        use CanBeVoted;
        protected $vote = User::class;
        protected $fillable = ['title', 'body', 'author_id'];

        public function user() {
            return $this->belongsTo(User::class, 'author_id');
        }

        public function answers() {
            return $this->hasMany(Answer::class);
        }

        public function comments() {
            return $this->hasMany(Comment::class);
        }

        public function acceptedAnswer() {
            return $this->belongsTo(Answer::class, 'answer_id');
        }

    }