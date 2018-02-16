<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function store($id)
    {

        $this->validate(request(), [
            'body' => 'required',
            'question_id' => 'required',
            'answer_id' => 'required',
            'i_am_a' => 'required'
        ]);

        if (request('i_am_a') == 'commentQ') {
            Comment::create([

                'body' => request('body'),
                'question_id' => request('question_id'),
                'author_id' => auth()->id()
            ]);
        } else if (request('i_am_a') == 'commentA') {
            Comment::create([

                'body' => request('body'),
                'answer_id' => request('answer_id'),
                'author_id' => auth()->id()
            ]);
        }


        return redirect()->action('QuestionsController@show', ['id' => $id]);
    }
}
