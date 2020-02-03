@extends('layout')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            {{$post->title}}
        </h3>
        <p class="blog-post-meta">{{$post->created_at->format('d.m.Y H:i:s')}}</p>

        {{$post->body}}
        <hr>
        <a href="/posts">Back to post's list</a>
    </div>
@endsection
