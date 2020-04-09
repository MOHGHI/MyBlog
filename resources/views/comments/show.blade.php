@extends('layout.master')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            {{$comment->title}}
        </h3>
        <p class="blog-post-meta">{{$comment->created_at->format('d.m.Y H:i:s')}}</p>

        {{$comment->comment}}
        <hr>
    </div>
@endsection
