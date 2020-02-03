@extends('layout')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            Create Posts
        </h3>
        @include('errors.errors')
        <form method="post" action="/posts">
            @csrf
            <div class="form-group">
                <label for="inputTitle">Символьный код</label>
                <input type="text" class="form-control" id="inputSlug" name="slug" placeholder="Введите Символьный код">
            </div>
            <div class="form-group">
                <label for="inputTitle">Название статьи </label>
                <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Введите Название статьи">
            </div>
            <div class="form-group">
                <label for="inputBody">Краткое описание статьи</label>
                <input type="text" class="form-control" id="inputSBody" name="short_body" placeholder="Введите Краткое описание">
            </div>
            <div class="form-group">
                <label for="inputBody">Описание статьи</label>
                <input type="text" class="form-control" id="inputBody" name="body" placeholder="Введите описание">
            </div>
            <div class="form-group">
                <input type="checkbox" class="form-check-input"  name="published"  value="1" id="published">
                <label class="form-check-label" for="published">Опубликовано</label>
            </div>
            <button type="submit" class="btn btn-primary">Создать статью</button>
        </form>
    </div><!-- /.blog-main -->
@endsection
