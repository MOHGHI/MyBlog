@extends('layout.master')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            Statistics
        </h3>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Parameter</th>
                <th scope="col">Value</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>Общее количество статей</td>
                <td>{{$postsNumber}}</td>
            </tr>
            <tr>
                <td>Общее количество новостей</td>
                <td>{{$newsNumber}}</td>
            </tr>
            <tr>
                <td>ФИО автора, у которого больше всего статей</td>
                <td>{{$userMostPostsName}}</td>
            </tr>
            <tr>
                <td>Самая длинная статья </td>
                <td>{{$longestPost->pluck('title')[0]}}</td>
                <td><a href="/posts/{{$longestPost->pluck('slug')[0]}}">Go to post</a></td>
                <td>Длина: {{$longestPostBodyLength}}</td>
            </tr>
            <tr>
                <td>Самая короткая статья </td>
                <td>{{$shortestPost->pluck('title')[0]}}</td>
                <td><a href="/posts/{{$shortestPost->pluck('slug')[0]}}">Go to post</a></td>
                <td>Длина: {{$shortestPostBodyLength}}</td>
            </tr>
            <tr>
                <td>Средние количество статей у активных пользователей</td>
                <td>{{floor($usersPostsAvg)}}</td>
            </tr>
            <tr>
                <td>Самая непостоянная статья </td>
                <td>{{$mostChangePost->pluck('title')[0]}}</td>
                <td><a href="/posts/{{$mostChangePost->pluck('slug')[0]}}">Go to post</a></td>
            </tr>
            <tr>
                <td>Самая обсуждаемая статья </td>
                <td>{{$mostCommentPost->pluck('title')[0]}}</td>
                <td><a href="/posts/{{$mostCommentPost->pluck('slug')[0]}}">Go to post</a></td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection