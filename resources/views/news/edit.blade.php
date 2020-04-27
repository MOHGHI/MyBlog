@extends('layout.master')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            Change News
        </h3>
        @include('errors.errors')
        <form method="post" action="/admin/news/{{$news->slug}}">
            @csrf
            @method('PATCH')
            <div class="form-group">
            @include('news.news_form')
                <button type="submit" class="btn btn-primary">Change news</button>
            </div>
        </form>

        <form method="post" action="/news/{{ $news->slug }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete news</button>
        </form>
        <hr>
        <a href="/news">Back to news's list</a>
    </div>
@endsection
