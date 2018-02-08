<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\User;

class QuestionsController extends Controller
{
    public function index(){

        $question = Question::latest()->get();

        return view('question.index', compact(question));
    }

//    public function show(Question $question){
//
//        return view('question.show', compact('question'));
//    }

    public function create(){
        return view('question.create');
    }

    public function store(){

        $this-> validate(request(), [
            'q_head' => 'required',
            'q_body' => 'required'
        ]);

        Question::create([

        'q_head' => request('q_head'),
        'q_body' => request('q_body'),
//        'userid' =>  Auth::user->id() //use this when sessions are created

        ]);

        return redirect('/question/index');
    }


}
