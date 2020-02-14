<?php

namespace App\Http\Controllers;


use App\Notifications\PostCreated;
use App\Notifications\PostDeleted;
use App\Notifications\PostUpdated;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;


class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:update,post')->except(['index','store','create','show']);
    }

    public function index()
    {
        $posts = auth()->user()->posts()->with('tags')->latest()->get();
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

        $request_arr['published']  = \request('published') == 'on' ? 1 : 0;
        $request_arr['owner_id'] = auth()->id();
        $tags = collect(explode(',', \request('tags')))->keyBy(function ($item) {
            return $item;
        });
        $syncIds = [];
        foreach ($tags as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $syncIds[] = $tag->id;
        }

        $post = Post::create($request_arr);
        $post->tags()->sync($syncIds);
        User::admin()->notify(new PostCreated($post));
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

        /** @var Collection $postTag */
        $postTag = $post->tags->keyBy('name');
        $tags = collect(explode(',', \request('tags')))->keyBy(function ($item) {
            return $item;
        });
        $syncIds = $postTag->intersectByKeys($tags)->pluck('id')->toArray();
        $tagsToAttach = $tags->diffKeys($postTag);
        foreach ($tagsToAttach as $tag)
        {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $syncIds[] = $tag->id;
        }

        $post->tags()->sync($syncIds);
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
