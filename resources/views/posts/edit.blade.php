@extends('layout.master')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            Change Post
        </h3>
        @include('errors.errors')
        <form method="post" action="/posts/{{$post->slug}}">
            @csrf
            @method('PATCH')
            <div class="form-group">
            @include('posts.post_form')
                <button type="submit" class="btn btn-primary">Change post</button>
            </div>
        </form>

        <form method="post" action="/posts/{{ $post->slug }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete post</button>
        </form>
        <hr>
        <a href="/posts">Back to post's list</a>
    </div>
@endsection
