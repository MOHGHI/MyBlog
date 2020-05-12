<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\ModelCreateUpdateRequest;
use App\News;
use App\Post;
use App\Service\AddComment;
use App\Service\AddTags;
use App\Service\FormValidation;
use App\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    protected $formValidator;
    protected $tagsAdder;

    public function __construct(FormValidation $formValidator, AddTags $tagsAdder)
    {
        $this->middleware('auth')->except('showAllNews','show');
        $this->formValidator = $formValidator;
        $this->tagsAdder = $tagsAdder;
    }

    public function index()
    {
        $news = News::latest()->get();
        return view('news.admin.news_list', compact('news'));
    }

    public function showAllNews()
    {
        $news = News::where('published', true)->latest()->get();
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(ModelCreateUpdateRequest $request)
    {
        $newsFormAttributes = $request->validated();
        $tags = $newsFormAttributes['tags'];
        $newsFormAttributes['published']  = $newsFormAttributes['published'] == 'on' ? 1 : 0;
        unset($newsFormAttributes['tags']);
        $news = News::create($newsFormAttributes['attributes']);
        $this->tagsAdder->addTags($news, $tags);
        flash('news was created successfully.');
        return redirect('/news');
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(ModelCreateUpdateRequest $request, News $news)
    {
        $newsFormAttributes = $request->validated();
        $newsFormAttributes['published']  = $newsFormAttributes['published'] == 'on' ? 1 : 0;
        $this->tagsAdder->addTags($news, $newsFormAttributes['tags']);
        unset($newsFormAttributes['tags']);
        $news->update($newsFormAttributes);
        flash('post was updated successfully.');
        User::admin()->notify(new PostUpdated($post));
        return redirect("/posts/{$post->slug}");
    }

    public function publish(News $news)
    {
        $news->update(['published' => true]);
        return back();
    }

    public function unpublish(News $news)
    {
        $news->update(['published' => false]);
        return back();
    }

    public function addComment(News $news)
    {
        $comment_attr = Comment::commentValidation();
        $addComment = new AddComment();
        $addComment->addComments($news, $comment_attr);
        return back();
    }

    public function destroy(News $news)
    {
        $deleted = $news->delete();
        if($deleted) {
            flash('news was deleted successfully.', 'danger');
        } else {
            flash('something went wrong.', 'danger');
        }

        return redirect('/news');
    }
}
