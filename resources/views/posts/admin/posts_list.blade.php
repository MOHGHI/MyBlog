@extends('adminIndex')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            Post's list
        </h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Заголовок</th>
                <th scope="col">Короткое содержание</th>
                <th scope="col">Пользователь</th>
                <th scope="col">Опупликованна?</th>
            </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    @include('posts.admin.item')
                @endforeach
            </tbody>
        </table>
    </div>
@endsection