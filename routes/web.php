<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::get('/', function() {
        return view('welcome');
    });

//Route::get('/', 'QuestionsController@index');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/questions/create', 'QuestionsController@create');

    Route::post('/questions/', 'QuestionsController@store');

    Route::get('/questions/', 'QuestionsController@index');

    Route::get('/questions/{id}', 'QuestionsController@show');


    Route::post('/answers/', 'AnswersController@store');

    Route::post('/comments/', 'CommentController@store');

//TODO: Why does POST break all the voting routes but not answer store or comments store..
    Route::any('/answers/{id}/upvote', 'AnswersController@upvote');

    Route::any('/answers/{id}/downvote', 'AnswersController@downvote');

    Route::any('/questions/{id}/upvote', 'QuestionsController@upvote');

    Route::any('/questions/{id}/downvote', 'QuestionsController@downvote');

    Route::any('/questions/{id}/voters', 'QuestionsController@Voters');

    Route::post('/api/question/acceptAnswer', 'QuestionsController@updateAcceptanceState');

    //Comment routes