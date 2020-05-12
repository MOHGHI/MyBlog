@extends('adminIndex')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            News's list
            <a class="float-right" href="/admin/news/create">Создать Новость</a>
        </h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Заголовок</th>
                <th scope="col">Короткое содержание</th>
                <th scope="col">Изменить</th>
                <th scope="col">Опупликованна?</th>
            </tr>
            </thead>
            <tbody>
                @foreach($news as $new)
                    @include('news.admin.item')
                @endforeach
            </tbody>
        </table>
    </div>
@endsection