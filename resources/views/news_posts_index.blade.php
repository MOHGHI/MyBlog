@extends('layout.master')

@section('content')
    <div class="col-md-8 blog-main">
        <div class="border-bottom">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                News's list
            </h3>
            @foreach($allRelations['news'] as $new)
                @include('news.item')
            @endforeach
        </div>

        <div class="border-bottom">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                Post's list
            </h3>
            @foreach($allRelations['posts'] as $post)
                @include('posts.item')
            @endforeach
        </div>

        <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a>
        </nav>

    </div><!-- /.blog-main -->
@endsection