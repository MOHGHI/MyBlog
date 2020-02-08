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
    return view('index');
});

Route::get('/test', function(\Illuminate\Http\Request $request) {

//    dd($request->session()->all());
    session()->put('test','test');
    return session()->get('test');
});

Route::get('/about', function () {
    return view('about');
});

//Route::get('/contacts', function () {
//    return view('layout.contact');
//});

//Route::get('/', 'PostsController@index');
//Route::get('/posts', 'PostsController@index');
//Route::get('/post/create', 'PostsController@create');
//Route::post('/posts', 'PostsController@store');
//Route::get('/post/{post}', 'PostsController@show');

Route::get('/posts/tags/{tag}', 'TagsController@index');

Route::resource('/posts','PostsController');

Route::get('/admin/feedbacks', 'FeedbacksController@index');
Route::get('/feedbacks', 'FeedbacksController@index');
Route::get('/contacts', 'FeedbacksController@create');
Route::post('/feedbacks', 'FeedbacksController@store');
Route::get('/feedback/{feedback}', 'FeedbacksController@show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
