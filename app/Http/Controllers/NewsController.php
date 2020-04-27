<?php

namespace App\Http\Controllers;

use App\News;
use App\Post;
use App\Service\AddComment;
use App\Service\AddTags;
use App\Service\FormValidation;
use App\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('showAllNews','show');
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

    public function store()
    {
        $formValidator = new FormValidation();
        $newsFormAttributes = $formValidator->FormValidation();
        $news = News::create($newsFormAttributes['attributes']);
        $tagsAdder = new AddTags();
        $tagsAdder->addTags($news,$newsFormAttributes['tags']);
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

    public function update(News $news)
    {
        $slug = request()->slug;
        $id = News::where('slug', '=', $slug)->first();
        $formValidator = new FormValidation();
        $newsFormAttributes = $formValidator->FormValidation($news, $id);
        $tagsAdder = new AddTags();
        $tagsAdder->addTags($news,$newsFormAttributes['tags']);
        $news->update($newsFormAttributes['attributes']);
        flash('news was updated successfully.');
        return redirect("/news/{$news->slug}");
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
        $addComment = new AddComment();
        $addComment->addComments($news);
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
