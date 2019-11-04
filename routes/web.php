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
    return view('crud');
});
 
Route::get('{crud?}/{id?}', function () {
    return view('crud');
})->where(['crud' => '(list|create|edit|view)', 'id' => '[0-9]+']);
 
Route::get('posts/all', 'PostsController@getAll');
 
Route::post('posts/create', 'PostsController@store');
 
Route::get('posts/view/{id}', 'PostsController@view');
 
Route::post('posts/update', 'PostsController@update');
 
Route::delete('posts/delete', 'PostsController@delete');



Route::get('{page?}/{id?}', function () {
    return view('post');
})->where(['page' => '(list|create|edit|view)', 'id' => '[0-9]+']);