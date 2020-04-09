<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Tag $tag)
    {
        $posts = $tag->posts()->with('tags')->get();
        $news  = $tag->news()->with('tags')->get();
        return view('news_posts_index', compact("posts","news"));
    }

}
