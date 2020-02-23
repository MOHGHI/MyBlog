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


Route::get('/','PostsController@showAllPosts');


Route::get('/about', function () {
    return view('about');
});

//Admin routes
Route::get('/admin', function () {
    if((auth()->user() && auth()->user()->isAdmin()))
        return view('posts.admin.index');
    else
        abort(403, 'Unauthorized action.');
});
Route::resource('/admin/posts','admin\PostsController');
Route::get('/admin/feedbacks', 'FeedbacksController@index');
Route::post('/admin/published/{post}', 'admin\PostsController@publish');
Route::patch('/admin/published/{post}', 'admin\PostsController@unpublish');

Route::get('/posts/tags/{tag}', 'TagsController@index');
Route::resource('/posts','PostsController');
Route::get('/feedbacks', 'FeedbacksController@index');
Route::get('/contacts', 'FeedbacksController@create');
Route::post('/feedbacks', 'FeedbacksController@store');
Route::get('/feedback/{feedback}', 'FeedbacksController@show');

Route::get('/service', 'PushServiceController@form');
Route::post('/service', 'PushServiceController@send');

Auth::routes();
