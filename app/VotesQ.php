<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\VotesQ
 *
 * @property int $question_id
 * @property int $author_id
 * @property boolean $votes
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereVotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereDeletedAt($value)
 * @mixin \Eloquent
 */

class VotesQ extends Model
{
    protected $fillable = ['votes', 'question_id', 'author_id'];
}
