@extends('layout')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            Send Notifications
        </h3>
        @include('errors.errors')
        <form method="post" action="/service">
            @csrf
            <div class="form-group">
                <label for="inputTitle">Notification head</label>
                <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Введите head" value="{{ old('title') }}">
            </div>
            <div class="form-group">
                <label for="inputBody">Notifi text</label>
                <textarea class="form-control" id="inputBody" name="text" placeholder="Введите описание задачи">{{ old('body') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send notifi</button>
        </form>
    </div>
@endsection
