<?php


namespace App\Http\Controllers\admin;


use App\Post;
use App\User;

class PostsController extends \App\Http\Controllers\PostsController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.admin.posts_list', compact('posts'));
    }

    public function publish(Post $post)
    {
        $post->update(['published' => true]);
        return back();
    }

    public function unpublish(Post $post)
    {
        $post->update(['published' => false]);
        return back();
    }
}