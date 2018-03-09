<?php

    namespace App\Http\Controllers;

    use App\Comment;
    use Illuminate\Support\Facades\Auth;

    class CommentController extends Controller {
        public function store() {
            $this->validate(request(), [
                'body'        => 'required',
                'question_id' => 'required',
                'answer_id'   => 'required',
                'i_am_a'      => 'required',
            ]);

            if (request('i_am_a') == 'commentQ') {
                Comment::create([
                    'body'        => request('body'),
                    'question_id' => request('question_id'),
                    'author_id'   => Auth::id(),
                ]);
            } else {
                if (request('i_am_a') == 'commentA') {
                    Comment::create([
                        'body'      => request('body'),
                        'answer_id' => request('answer_id'),
                        'author_id' => Auth::id(),
                    ]);
                }
            }
            return redirect()->action('QuestionsController@show', ['id' => request('question_id')]);
        }
    }
