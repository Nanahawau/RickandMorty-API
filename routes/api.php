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


Route::get('/episode' ,'EpisodeController@index');

Route::get('/episode/{episode_id}/comments', 'CommentsController@show');

Route::post('/episode/{episode_id}/comments', "CommentsController@create");

Route::put('/comment/update/{id}', 'CommentsController@update');

Route::delete('/comment/delete/{id}', 'CommentsController@destroy');

Route::get('/episode/character_list', 'EpisodeController@getCharacterList');
