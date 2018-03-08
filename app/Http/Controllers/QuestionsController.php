<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use cebe\markdown\GithubMarkdown;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $questions = Question::latest()->get();

        return view('questions', compact('questions'));
    }

    public function show($id)
    {
        try {
            $question = Question::find($id);
            $comments = $question->comments;

            $parser = new GithubMarkdown();
            $answers = $question->answers;

            $aComments = array();
            foreach($answers as $answer) {
                            $aComments[] = $answer->comments;
                        }
            $answerComments = collect($aComments);

        } catch (ModelNotFoundException $exception) {
            return redirect('questions');
        }

        $user = Auth::user();

        $canAcceptAnswer = ($question['author_id'] == $user['id']);
        $hasAcceptedAnswer = (isset($question['answer_id']) );

        return view('questions.show', compact('question', 'answers', 'comments', 'answerComments', 'parser', 'canAcceptAnswer', 'hasAcceptedAnswer'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required',
            'body' => 'required'
        ]);

        Question::create([
            'title' => request('title'),
            'body' => request('body'),
            'author_id' => Auth::id() //use this when sessions are created
        ]);

        return redirect('questions');
    }

    public function upvote($id)
    {
        try {
            $question = Question::whereId($id)->first();
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

    public function downvote($id)
    {
        try {
            $question = Question::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return redirect()->back();
        }
        $user = Auth::user();


        if ($user->hasDownVoted($question)) {
            $user->cancelVote($question);
        } else {
            $user->downVote($question);
        }
        return redirect()->back();

    }

    public function updateAcceptanceState() {

        $this-> validate(request(),[
            'question_id' => 'required',
            'answer_id' => 'required'
        ]);

        try {
            $answer = Answer::findOrFail(request('answer_id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 'fail', 'body' => ['message' => 'Answer - ModelNotFoundException']]);
        }

        try {
            $question = Question::findOrFail(request('question_id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 'fail', 'body' => ['message' => 'Question - ModelNotFoundException']]);
        }

        $user = Auth::user();

        if ($question['author_id'] != $user->id) {
            return response()->json(['status' => 'fail', 'body' => ['message' => 'User did not ask the question']]);
        } else if ($question['answer_id'] == request('answer_id')){
            $question->answer_id = null;
            $question->save();
            return response()->json(['status' => 'success', 'body' => ['answerUnset' => true]]);
        } else {
            $question->answer_id = $answer['id'];
            $question->save();
            return response()->json(['status' => 'success', 'body' => ['answerSet' => true]]);
        }
    }
}