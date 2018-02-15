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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/questions/create', 'QuestionsController@create');

Route::post('/questions/', 'QuestionsController@store');

Route::post('/answers/{id}', 'AnswersController@store');

Route::get('/questions/', 'QuestionsController@index');

Route::get('/questions/{id}', 'QuestionsController@show');

Route::get('/questions/{id}/voters', 'QuestionsController@Voters');

Route::get('/questions/{id}/upvote', 'QuestionsController@upvote');

Route::get('/questions/{id}/downvote', 'QuestionsController@downvote');