<?php

    use Illuminate\Http\Request;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */

    Route::middleware('auth:api')->get('/user', function(Request $request) {
        return $request->user();
    });


    Route::get('questions', 'QuestionsController@index');

    Route::post('questions', 'QuestionsController@store');

    Route::get('questions/{id}', 'QuestionsController@show');

    Route::get('questions/{id}/answers', 'AnswersController@index');

    Route::post('questions/{id}/answer', 'AnswersController@store');

    Route::get('answers/{id}', 'AnswersController@show');

    Route::get('answers/{id}/accept', 'AnswersController@accept');

    Route::get('{model}/{id}/comments', 'CommentsController@index');

    Route::post('{model}/{id}/comment', 'CommentsController@store');

    Route::get('comments/{id}', 'CommentsController@show');

    Route::get('{model}/{id}/votes', 'VotesController@index');

    Route::post('{model}/{id}/upvote', 'VotesController@upvote');

    Route::post('{model}/{id}/downvote', 'VotesController@downvote');