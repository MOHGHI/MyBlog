@php
    $comments = $comments ?? collect();
@endphp

@if($comments->isNotEmpty())
    <div>
        @foreach($comments as $comment)
            <hr>
            <div class="col-md-8 blog-main">
                <h5 class="pb-4 mb-4 font-italic border-bottom">
                    {{$comment->title}}
                </h5>
                <p class="blog-post-meta">{{$comment->owner->name}}</p>
                <p class="blog-post-meta">{{$comment->created_at->format('d.m.Y H:i:s')}}</p>
                {{$comment->comment}}
            </div>
            <hr>
        @endforeach
    </div>
@endif