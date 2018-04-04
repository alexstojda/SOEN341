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

    Route::post('/questions', 'QuestionsController@newQuestion');

    Route::get('/questions', 'QuestionsController@listAll');

    Route::get('/questions/{id}', 'QuestionsController@show');

    Route::post('/answers', 'AnswersController@store');

    Route::get('/redirect', 'SocialAuthFacebookController@redirect');

    Route::get('/callback', 'SocialAuthFacebookController@callback');