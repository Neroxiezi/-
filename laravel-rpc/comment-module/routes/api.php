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
Route::get('comment_client', 'Api\CommentClientController@index')->middleware('accross');
Route::middleware('accross')->post('comment_save', 'Api\CommentClientController@comment_save');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
