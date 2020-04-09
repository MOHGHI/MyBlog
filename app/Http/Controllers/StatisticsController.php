<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $s = 'select users.id,  count(*) as postNumber from posts join users on posts.owner_id = users.id
               group by users.id order by postNumber desc limit 1';
        $ss = 'select id from (select id , length(body) as lenghts from posts order by lenghts desc limit 1) as dd';

        $s3 = 'select avg(postNumber) from (select users.id,  count(*) as postNumber from posts join users on posts.owner_id = users.id
    group by users.id) as dd where postNumber > 1';

        $s4 = 'select count(*), commentable_id from commentables where commentable_type = \'App\\Post\' group by commentable_id';

        $postsNumber = DB::table('posts')->count();
        $newsNumber = DB::table('news')->count();
        $mostPostsAuthor = DB::table('users')->join('posts',
            'users.id', '=', 'posts.owner_id');

        $userMostPosts = DB::table('posts')->selectRaw('users.id,  count(*) as postNumber')->join('users', 'posts.owner_id', '=', 'users.id')
            ->groupBy('users.id')->orderByDesc('postNumber')->limit(1);

        $usersPostsAvg = DB::table('posts')->join('users', 'posts.owner_id', '=',
            'users.id')->groupBy('users.id')->selectRaw('count(*) as postNumber')->having('postNumber', '>', '1')->get()->average('postNumber');

        $userMostPostsId = $userMostPosts->pluck('id')[0];
        $userMostPostsNumber = $userMostPosts->pluck('postNumber')[0];
        $userMostPostsName = DB::table('users')->where('users.id', '=', $userMostPostsId)->value('name');

        $longestPostQuery = DB::table('posts')->selectRaw('id , length(body) as length')
            ->orderByDesc('length')->limit(1)->get();
        $longestPost = DB::table('posts')->where('posts.id', '=', $longestPostQuery->pluck('id')[0])->get();
        $longestPostBodyLength = $longestPostQuery->pluck('length')[0];

        $shortestPostQuery = DB::table('posts')->selectRaw('id , length(body) as length')
            ->orderBy('length', 'asc')->limit(1)->get();
        $shortestPost = DB::table('posts')->where('posts.id', '=', $shortestPostQuery->pluck('id')[0])->get();
        $shortestPostBodyLength = $shortestPostQuery->pluck('length')[0];

        $mostChangePostID = DB::table('post_histories')->join('posts', 'post_id', '=',
        'posts.id')->groupBy('posts.id')->selectRaw('post_id , count(*) as changNumber')->orderByDesc('changNumber')->limit(1)->pluck('post_id')[0];

        $mostChangePost = DB::table('posts')->select('*')->where('id' , '=' , $mostChangePostID)->get();

        $mostCommentPostID = DB::table('commentables')->selectRaw('count(*) as commentQuantity, commentable_id')
            ->where('commentable_type' , '=' , 'App\Post')->groupBy('commentable_id')
            ->orderByDesc('commentQuantity')->limit(1)->pluck('commentable_id')[0];;
        $mostCommentPost = DB::table('posts')->select('*')->where('id' , '=' , $mostCommentPostID)->get();


        return view('stastistics.statistics', compact('postsNumber',
            'newsNumber', 'userMostPostsName', 'longestPost', 'longestPostBodyLength', 'shortestPost', 'shortestPostBodyLength', 'usersPostsAvg' , 'mostChangePost' , 'mostCommentPost'));
    }
}
