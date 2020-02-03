@extends('layout')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            {{$feedback->email}}
        </h3>
        <p class="blog-post-meta">{{$feedback->created_at->format('d.m.Y H:i:s')}}</p>

        {{$feedback->message}}
        <hr>
        <a href="/feedbacks">Back to feedback's list</a>
    </div>
@endsection
