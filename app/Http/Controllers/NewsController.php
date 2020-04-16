<?php

namespace App\Http\Controllers;

use App\News;
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

    public function store(Request $request)
    {
        $request_arr = $this->validate(request(), [
            'slug' =>
                array(
                    'required',
                    'unique:news,slug',
                    'regex:/(^([a-zA-Z0-9-_]+)(\d+)?$)/u'
                ),
            'title' => 'required |min:5 |max:100',
            'short_body' => 'required |max:255',
            'body' => 'required',
        ]);

        $request_arr['published']  = \request('published') == 'on' ? 1 : 0;
        $news = News::create($request_arr);
        $tags = collect(explode(',', \request('tags')))->keyBy(function ($item) {
            return $item;
        });
        addTags($news,$tags);

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
        $attribute = request()->validate([
            'title' => 'required |min:5 |max:100',
            'short_body' => 'required |max:255',
            'body' => 'required',
        ]);

        $attribute['published']  = \request('published') == 'on' ? 1 : 0;
        $tags = collect(explode(',', \request('tags')))->keyBy(function ($item) {
            return $item;
        });
        addTags($news,$tags);
        $news->update($attribute);
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
        $request_arr = $this->validate(request(), [
            'title' => 'required |min:5 |max:100',
            'comment' => 'required |max:255',
        ]);
        $request_arr['owner_id'] = auth()->id();
        $comment = \App\Comment::Create($request_arr);
        $news->comments()->save($comment);
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
