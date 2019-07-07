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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/episodes' ,'EpisodeController@index');

Route::get('/episodes/{episode}/comments', 'CommentsController@show');

Route::get('/episodes/{episode}/characters', 'EpisodeController@getCharacterList');

Route::post('/episodes/{episode}/comments', "CommentsController@create");

Route::put('episodes/comments/{comment}', 'CommentsController@update');

Route::delete('episodes/comments/{comment}', 'CommentsController@destroy');


