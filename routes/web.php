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

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/questions/create', 'QuestionsController@create');

    Route::post('/questions', 'QuestionsController@store');

    Route::get('/questions', 'QuestionsController@QuestionsList');

    Route::get('/questions/{id}', 'QuestionsController@QuestionView');

    Route::post('/answers', 'AnswersController@store');

    Route::get('/redirect', 'SocialAuthFacebookController@redirect');

    Route::get('/callback', 'SocialAuthFacebookController@callback');