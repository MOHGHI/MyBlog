<div class="blog-post">
    <h2 class="blog-post-title"><a href="/news/{{$new->slug}}">{{$new->title}} </a> </h2>
{{--    @if (auth()->user() && auth()->user()->isAdmin())--}}
{{--        <a href="/admin/posts/">Change</a>--}}
{{--    @endif--}}
    @php
        $section = '<a href="/admin/news/' . $new->slug . '/edit">Change</a>';
    @endphp

    @isAdmin(['section' => $section])
    @endisAdmin
    <p class="blog-post-meta">{{$new->created_at->format('d.m.Y H:i:s')}}</p>

    @include('news.tags', ['tags' => $new->tags])

    {{$new->short_body}}
</div>