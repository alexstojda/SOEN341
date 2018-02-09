<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Http\Controllers\Auth;

class QuestionsController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->get();

        return view('questions.index', ['questions'=>$questions]);
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);

        return view('questions.show', ['question'=>$question]);
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
            'author_id' =>  auth()->id() //use this when sessions are created
        ]);

        return redirect('questions/index');
    }


}
