<?php

namespace App\Http\Controllers;


use App\Comment;
use App\Notifications\PostCreated;
use App\Notifications\PostDeleted;
use App\Notifications\PostUpdated;
use App\Post;
use App\Service\AddComment;
use App\Service\AddTags;
use App\Service\FormValidation;
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
        $formValidator = new FormValidation();
        $postFormAttributes = $formValidator->FormValidation();
        $postFormAttributes['attributes']['owner_id'] = auth()->id();
        $post = Post::create($postFormAttributes['attributes']);
        $tags = collect(explode(',', \request('tags')))->keyBy(function ($item) {
            return $item;
        });
        $tagsAdder = new AddTags();
        $tagsAdder->addTags($post,$postFormAttributes['tags']);
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

        $slug = request()->slug;
        $id = Post::where('slug', '=', $slug)->first();
        $formValidator = new FormValidation();
        $postFormAttributes = $formValidator->FormValidation($post, $id);
        $tagsAdder = new AddTags();
        $tagsAdder->addTags($post,$postFormAttributes['tags']);
        $post->update($postFormAttributes['attributes']);
        flash('post was updated successfully.');
        User::admin()->notify(new PostUpdated($post));
        return redirect("/posts/{$post->slug}");
    }

    public function addComment(Post $post)
    {
        $addComment = new AddComment();
        $addComment->addComments($post);
        return back();
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
