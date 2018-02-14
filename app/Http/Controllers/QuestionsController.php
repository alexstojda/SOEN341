<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    public function index()
    {
        $questions = Question::latest()->get();

        return view('questions', ['questions'=>$questions]);
    }

    public function show($id)
    {
        try {
            $question = Question::findOrFail($id);
        }
        catch (ModelNotFoundException $exception) {
            return redirect('questions');
        }

        try {
            $answers = Answer::whereQuestionId($id);
        } catch (ModelNotFoundException $exception) {
            $answers = null;
        }

        return view('questions.show', ['question'=>$question, 'answers'=>$answers]);
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store()
    {
        $this-> validate(request(),[
            'title' => 'required',
            'body' => 'required'
        ]);

        Question::create([
            'title' => request('title'),
            'body' => request('body'),
            'author_id' =>  Auth::id() //use this when sessions are created
        ]);

        return redirect('questions');
    }
}