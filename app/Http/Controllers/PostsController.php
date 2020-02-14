<?php

namespace App\Http\Controllers;


use App\Notifications\PostCreated;
use App\Notifications\PostDeleted;
use App\Notifications\PostUpdated;
use App\Post;
use App\Service\Pushall;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;


class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('showAllPosts','show');
    }

    public function index()
    {
        $posts = auth()->user()->posts()->with('tags')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function showAllPosts()
    {
        $posts = Post::where('published', true)->latest()->get();
        return view('index', compact('posts'));
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

        $request_arr['published']  = \request('published') == 'on' ? 1 : 0;
        $request_arr['owner_id'] = auth()->id();
        $post = Post::create($request_arr);
        $post->addTags($new = true);
        User::admin()->notify(new PostCreated($post));

        $pushall = new Pushall(config('mohghi.pushall.api.key'), config('mohghi.pushall.api.id'));
        $pushall->send('Post created', 'New post was created');

        flash('post was created successfully.');
        return redirect('/posts');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post)
    {
        $attribute = request()->validate([
            'title' => 'required |min:5 |max:100',
            'short_body' => 'required |max:255',
            'body' => 'required',
        ]);

        $attribute['published']  = \request('published') == 'on' ? 1 : 0;
        $post->addTags();
        $post->update($attribute);
        flash('post was updated successfully.');
        User::admin()->notify(new PostUpdated($post));
        return redirect("/posts/{$post->slug}");
    }

    public function destroy(Post $post)
    {
        $deleted = $post->delete();
        if($deleted) {
            flash('post was deleted successfully.', 'danger');
            User::admin()->notify(new PostDeleted($post));
        } else {
            flash('something went wrong.', 'danger');
            User::admin()->notify(new PostDeleted($post));
        }

        return redirect('/posts');
    }
}
