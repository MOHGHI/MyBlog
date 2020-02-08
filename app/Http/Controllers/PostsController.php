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

    private $admin;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:update,post')->except(['index','store','create']);
        $this->admin = User::where('email',env('ADMIN_EMAIL')) -> first();
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
        $request_arr['owner_id'] = auth()->id();
        $post = Post::create($request_arr);

        $this->admin->notify(new PostCreated($post));
        return redirect('/posts');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post)
    {
        $attribute = request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

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

        $this->admin->notify(new PostUpdated($post));

        return redirect("/posts/{$post->slug}");
    }

    public function destroy(Post $post)
    {
        $deleted = $post->delete();
        if($deleted) {
            flash('post was deleted successfully.', 'danger');
            $this->admin->notify(new PostDeleted());
        } else {
            flash('something went wrong.', 'danger');
            $this->admin->notify(new PostDeleted($post));
        }

        return redirect('/posts');
    }
}
