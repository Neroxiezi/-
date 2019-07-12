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
Route::get('comment_client', 'CommentClientController@index')->middleware('accrossDomain');
Route::post('comment_save', 'CommentClientController@comment_save')->middleware('accrossDomain');
Route::get('csrf_token',function (){
    return 'foo({"csrf_token": "'.csrf_token().'"});';
});
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
