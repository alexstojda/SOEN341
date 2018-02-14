<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 * @property string|null $deleted_at
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
class Answer extends Model
{
    protected $fillable = ['body', 'question_id', 'author_id'];
}
