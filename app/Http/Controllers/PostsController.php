<?php

namespace App\Http\Controllers;


use App\Comment;
use App\Http\Requests\ModelCreateUpdateRequest;
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
use phpDocumentor\Reflection\Types\Array_;


class PostsController extends Controller
{

    protected $formValidator;
    protected $tagsAdder;

    public function __construct(FormValidation $formValidator, AddTags $tagsAdder)
    {
        $this->middleware('auth')->except('showAllPosts','show');
        $this->formValidator = $formValidator;
        $this->tagsAdder = $tagsAdder;
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

    public function store(ModelCreateUpdateRequest $request)
    {
        $postFormAttributes = $request->validated();
        $tags = $postFormAttributes['tags'];
        $postFormAttributes['published']  = $postFormAttributes['published'] == 'on' ? 1 : 0;
        $postFormAttributes['owner_id'] = auth()->id();
        unset($postFormAttributes['tags']);
        $post = Post::create($postFormAttributes['attributes']);
        $this->tagsAdder->addTags($post, $tags);
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

    public function update(ModelCreateUpdateRequest $request , Post $post)
    {
        $postFormAttributes = $request->validated();
        $postFormAttributes['published']  = $postFormAttributes['published'] == 'on' ? 1 : 0;
        $this->tagsAdder->addTags($post, $postFormAttributes['tags']);
        unset($postFormAttributes['tags']);
        $post->update($postFormAttributes);
        flash('post was updated successfully.');
        User::admin()->notify(new PostUpdated($post));
        return redirect("/posts/{$post->slug}");
    }

    public function addComment(Post $post)
    {
        $comment_attr = Comment::commentValidation();
        $addComment = new AddComment();
        $addComment->addComments($post, $comment_attr);
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
