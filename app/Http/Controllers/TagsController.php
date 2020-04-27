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
        $allRelations = $tag->load(['posts', 'news']);
        return view('news_posts_index', compact("allRelations"));
    }

}
