<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\User;

class QuestionsController extends Controller
{
    public function index()
    {
        $question = Question::latest()->get();

        return view('questions.index', compact($question));
    }

    //public function show(Question $question)
    //{
    //    return view('question.show', compact('question'));
    //}

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
            //'author_id' =>  Auth::user->id(), //use this when sessions are created
        ]);

        return redirect('/questions/index');
    }


}
