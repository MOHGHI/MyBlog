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
                <label for="inputTitle">Change Post</label>
                <input type="text" class="form-control" id="inputTitle" placeholder="Enter post's title"
                       name="title"
                       value="{{old('title', $post->title)}}"
                >
                <div class="form-group">
                    <label for="inputBody">Post body</label>
                    <textarea class="form-control" id="inputBody" name="body">{{ old('body', $post->body) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="inputTag">Tags</label>
                    <input class="form-control"
                           type="text"
                           name="tags"
                           id="inputTags"
                           value="{{ old('tags', $post->tags->pluck('name')->implode(',')) }}"
{{--                           value="{{ old('tags')}}"--}}
                    >
                </div>

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
