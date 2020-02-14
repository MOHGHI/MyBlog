@extends('layout.master')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            Feedback's list
        </h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">email</th>
                <th scope="col">сообщение</th>
                <th scope="col">дата получения</th>
            </tr>
            </thead>
            <tbody>
                @foreach($feedbacks as $feedback)
                    @include('feedbacks.item')
                @endforeach
            </tbody>
        </table>


        <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a>
        </nav>

    </div><!-- /.blog-main -->
@endsection