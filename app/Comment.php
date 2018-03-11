<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    /**
     * App\Comment
     *
     * @property int                                 $id
     * @property int|null                            $question_id
     * @property int|null                            $answer_id
     * @property int|null                            $author_id
     * @property string                              $body
     * @property \Carbon\Carbon|null                 $created_at
     * @property \Carbon\Carbon|null                 $updated_at
     * @property string|null                         $deleted_at
     * @property-read \App\User|null                 $user
     * @property-read \App\Question|\App\Answer|null $parent
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereAuthorId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereAnswerId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereQuestionId($value)
     * @mixin \Eloquent
     */
    class Comment extends Model {
        protected $fillable = ['body', 'question_id', 'answer_id', 'author_id', 'i_am_a'];

        public function user() {
            return $this->belongsTo(User::class, 'author_id');
        }

        public function parent() {
            if (isset($this->question_id)) {
                return $this->belongsTo(Question::class, 'question_id');
            } elseif (isset($this->answer_id)) {
                return $this->belongsTo(Answer::class, 'answer_id');
            } else {
                return false;
            }
        }
    }