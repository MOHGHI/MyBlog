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
        return view('adminIndex');
    else
        abort(403, 'Unauthorized action.');
});
Route::resource('/admin/posts','admin\PostsController');
Route::get('/admin/feedbacks', 'FeedbacksController@index');
Route::post('/admin/posts/published/{post}', 'admin\PostsController@publish');
Route::patch('/admin/posts/published/{post}', 'admin\PostsController@unpublish');

Route::get('/tags/{tag}', 'TagsController@index');
Route::resource('/posts','PostsController');

Route::resource('/admin/news','NewsController');
Route::get('/news/{news}','NewsController@show');
Route::get('/news','NewsController@showAllNews');
Route::post('/admin/news/published/{news}', 'NewsController@publish');
Route::patch('/admin/news/published/{news}', 'NewsController@unpublish');

Route::get('/feedbacks', 'FeedbacksController@index');
Route::get('/contacts', 'FeedbacksController@create');
Route::post('/feedbacks', 'FeedbacksController@store');
Route::get('/feedback/{feedback}', 'FeedbacksController@show');

Route::get('/service', 'PushServiceController@form');
Route::post('/service', 'PushServiceController@send');

Route::post('/posts/comments/{post}', 'PostsController@addComment');
Route::post('/news/comments/{news}', 'NewsController@addComment');

Route::get('/statistics', 'StatisticsController@index');

Auth::routes();
