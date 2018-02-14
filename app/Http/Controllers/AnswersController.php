<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($id)
    {
        $this-> validate(request(),[
            'body' => 'required',
            'question_id' => 'required'
        ]);

        Answer::create([
            'question_id' => $id,
            'body' => request('body'),
            'author_id' =>  Auth::id() //use this when sessions are created
        ]);

        return redirect('questions/'.$id);
    }

    public function show($question_id){

    }
}

