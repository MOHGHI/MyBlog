@extends('layout.master')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            Create News
        </h3>
        @include('errors.errors')
        <form method="post" action="/admin/news">
            @csrf
            @include('news.news_form')
            <button type="submit" class="btn btn-primary">Создать Новость</button>
        </form>
    </div><!-- /.blog-main -->
@endsection
