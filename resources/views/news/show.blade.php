@extends('layout.master')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            {{$news->title}}
            @can('update', $news)
            <a href="/news/{{$news->slug}}/edit">Change</a>
            @endcan
        </h3>

        @include('news.tags', ['tags' => $news->tags])

        <p class="blog-post-meta">{{$news->created_at->format('d.m.Y H:i:s')}}</p>

        {{$news->body}}

        @include('posts.comments', ['comments' => $news->comments])

        <div class="col-md-8 blog-main">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                Add Comment
            </h3>
            @include('errors.errors')
            <form method="post" action="/news/comments/{{$news->slug}}">
                @csrf
                <div class="form-group">
                    <label for="inputTitle">Title</label>
                    <input type="text" class="form-control" name="title" id="inputTitle" placeholder="Title">
                </div>
                <div class="form-group">
                    <label for="inputComment">Comment </label>
                    <textarea class="form-control" name="comment" id="inputComment" placeholder="Comment"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add comment</button>
            </form>
        </div>


        <hr>
        <a href="/news">Back to news's list</a>
    </div>
@endsection
