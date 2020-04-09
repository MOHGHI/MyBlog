@extends('layout.master')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            {{$post->title}}
            @can('update', $post)
            <a href="/posts/{{$post->slug}}/edit">Change</a>
            @endcan
        </h3>

        @include('posts.tags', ['tags' => $post->tags])

        <p class="blog-post-meta">{{$post->created_at->format('d.m.Y H:i:s')}}</p>

        {{$post->body}}

{{--        @dd($post->comments)--}}

        @include('posts.comments', ['comments' => $post->comments])

{{--        @include('comments.create')--}}
        <div class="col-md-8 blog-main">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                Add Comment
            </h3>
            @include('errors.errors')
            <form method="post" action="/posts/comments/{{$post->slug}}">
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

        <div class="col-md-8 blog-main">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                Change History
            </h3>
        @forelse($post->history as $item)
        @php
            $befores = json_decode($item->pivot->before, true);
            $afters = json_decode($item->pivot->after, true);
            $keys = array_keys($befores);
        @endphp
            @include('posts.histories_table')
        @empty
            <p>Нет истории изменении</p>
        @endforelse
        </div>
        <a href="/posts">Back to post's list</a>
    </div>
@endsection
