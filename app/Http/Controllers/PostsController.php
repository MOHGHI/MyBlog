<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PostsController extends Controller
{
    //
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $request_arr = $this->validate(request(), [
            'slug' =>
                array(
                    'required',
                    'unique:posts,slug',
                    'regex:/(^([a-zA-Z0-9-_]+)(\d+)?$)/u'
                ),
            'title' => 'required |min:5 |max:100',
            'short_body' => 'required |max:255',
            'body' => 'required',
        ]);
        Post::create($request_arr);
        return redirect('/posts');
    }
}
