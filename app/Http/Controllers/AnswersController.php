<?php

    namespace App\Http\Controllers;

    use App\Answer;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Facades\Auth;

    class AnswersController extends Controller {
        public function __construct() {
            $this->middleware('auth');
        }

        public function store() {
            $this->validate(request(), [
                'body'        => 'required',
                'question_id' => 'required',
            ]);

            Answer::create([
                'question_id' => request('question_id'),
                'body'        => request('body'),
                'author_id'   => Auth::id() //use this when sessions are created
            ]);

            return redirect()->action('QuestionsController@show', ['id' => request('question_id')]);
        }

        public function show($question_id) {

        }

        public function upvote($id) {
            try {
                $question = Answer::findOrFail($id);
            } catch (ModelNotFoundException $exception) {
                return redirect()->back();
            }
            $user = Auth::user();

            if ($user->hasUpVoted($question)) {
                $user->cancelVote($question);
            } else {
                $user->upVote($question);
            }
            return redirect()->back();

        }

        public function downvote($id) {
            try {
                $answer = Answer::findOrFail($id);
            } catch (ModelNotFoundException $exception) {
                return redirect()->back();
            }
            $user = Auth::user();


            if ($user->hasDownVoted($answer)) {
                $user->cancelVote($answer);
            } else {
                $user->downVote($answer);
            }
            return redirect()->back();

        }
    }

