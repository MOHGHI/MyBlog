<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {

        $postsNumber = DB::table('posts')->count();
        $newsNumber = DB::table('news')->count();

        $mostPostsAuthor = DB::table('users')->join('posts',
            'users.id', '=', 'posts.owner_id');

        $userMostPosts = DB::table('posts')->selectRaw('owner_id , count(*) as postNumber')
            ->groupBy('owner_id')->orderByDesc('postNumber')->first();

        $usersPostsAvg = DB::table('posts')->selectRaw('avg(postNumber)')->from(DB::table('posts')->selectRaw('owner_id , count(*) as postNumber')
            ->groupBy('owner_id'), 'dd')->where('postNumber' , '>', 1)->value('avg(postNumber)');

        $userMostPostsId = $userMostPosts->owner_id;
        $userMostPostsNumber = $userMostPosts->postNumber;

        $userMostPostsName = DB::table('users')->where('users.id', '=', $userMostPostsId)->value('name');

        $longestPostQuery = DB::table('posts')->selectRaw('id , length(body) as bodyLength')
            ->orderByDesc('bodyLength')->first();
        $longestPost = DB::table('posts')->where('posts.id', '=', $longestPostQuery->id)->get();
        $longestPostBodyLength = $longestPostQuery->bodyLength;

        $shortestPostQuery = DB::table('posts')->selectRaw('id , length(body) as bodyLength')
            ->orderBy('bodyLength', 'asc')->first();
        $shortestPost = DB::table('posts')->where('posts.id', '=', $shortestPostQuery->id)->get();
        $shortestPostBodyLength = $shortestPostQuery->bodyLength;

        $mostChangePostID = DB::table('post_histories')->selectRaw('post_id , count(*) as changNumber')
            ->groupBy('post_id')->orderByDesc('changNumber')->first()->post_id;

        $mostChangePost = DB::table('posts')->select('*')->where('id' , '=' , $mostChangePostID)->get();

        $mostCommentPostID = DB::table('commentables')->selectRaw('count(*) as commentQuantity, commentable_id')
            ->where('commentable_type' , '=' , 'App\Post')->groupBy('commentable_id')
            ->orderByDesc('commentQuantity')->first()->commentable_id;
        $mostCommentPost = DB::table('posts')->select('*')->where('id' , '=' , $mostCommentPostID)->get();


        return view('stastistics.statistics', compact('postsNumber',
            'newsNumber', 'userMostPostsName', 'longestPost', 'longestPostBodyLength', 'shortestPost', 'shortestPostBodyLength', 'usersPostsAvg' , 'mostChangePost' , 'mostCommentPost'));
    }
}
