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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('post')->name('post.')->group(function () {
    Route::get('/create', 'PostController@create')->name('create');
    Route::post('/store', 'PostController@store')->name('store');
});
