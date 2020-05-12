<?php

namespace App\Http\Controllers;

use App\News;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {

        $postsNumber = Post::count();
        $newsNumber = News::count();
        $userMostPosts = User::withCount('posts')->orderByDesc('posts_count')->first();
        $usersPostsAvg = User::withCount('posts')->havingRaw('posts_count > 1')->get()->average('posts_count');
        $longestPost = Post::selectRaw('* , length(body) as bodyLength')
            ->orderByDesc('bodyLength')->first();
        $shortestPost = Post::selectRaw('* , length(body) as bodyLength')
            ->orderBy('bodyLength')->first();
        $mostChangePost = Post::whereHas('history')->withCount('history')->orderByDesc('history_count')->first();
        $mostCommentPost = Post::whereHas('comments')->withCount('comments')->orderByDesc('comments_count')->first();

        return view('stastistics.statistics', compact('postsNumber',
            'newsNumber', 'userMostPosts', 'longestPost', 'shortestPost', 'usersPostsAvg' , 'mostChangePost' , 'mostCommentPost'));
    }
}
