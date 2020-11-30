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


Auth::routes();

Route::get('/popular', 'PostController@popular')->name('popular');
Route::get('/getPopular', 'PostController@getPopular')->name('getPopular');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'PostController@index')->name('home');

    Route::prefix('user')->name('user.')->group(function () {
        Route::post('/update', 'UserController@update')->name('update');
        Route::get('/update', 'UserController@edit')->name('edit');
    });

    Route::prefix('post')->name('post.')->group(function () {
        Route::get('/create', 'PostController@create')->name('create');
        Route::post('/store', 'PostController@store')->name('store');
        Route::get('/delete/{id}', 'PostController@delete')->name('delete');
        Route::get('/edit/{id}', 'PostController@edit')->name('edit');
        Route::post('/update', 'PostController@update')->name('update');
        Route::get('/my', 'PostController@MyPost')->name('my_post');

        Route::post('/comments', 'PostController@saveComment')->name('save_comment');
        Route::get('/delete_comment/{id}', 'PostController@deleteComment')->name('delete_comment');
    });

    Route::prefix('vote')->name('vote.')->group(function () {
        Route::post('/update', 'VoteController@update')->name('update');
    });

    Route::prefix('threads')->name('threads.')->group(function () {
        Route::get('/c/{category_id?}', 'ThreadController@index')->name('index');
        Route::get('/create', 'ThreadController@create')->name('create');
        Route::post('/store', 'ThreadController@store')->name('store');
        Route::get('/delete/{id}', 'ThreadController@delete')->name('delete');
        Route::post('search', 'ThreadController@search')->name('search');
        Route::post('join', 'ThreadController@join')->name('join');
        Route::get('my/{category_id?}', 'ThreadController@getMyThread')->name('my');
        Route::get('manage', 'ThreadController@manage')->name('manage');
    });
});


Route::get('post/getPost', 'PostController@getPost')->name('post.getPost'); // ajax
Route::get('post/getMyPost', 'PostController@getMyPost')->name('post.getMyPost'); // ajax
Route::get('/comments/{id}', 'PostController@comment')->name('post.comment');
Route::get('post/{id}', 'PostController@userPost')->name('post.user_post');
Route::get('threads/post/{id}', 'ThreadController@getPost')->name('threads.post');
Route::get('threads/postAjax/{id}', 'ThreadController@getPostAjax')->name('threads.postAjax');


