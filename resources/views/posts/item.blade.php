<div class="blog-post">
    <h2 class="blog-post-title"><a href="/posts/{{$post->slug}}">{{$post->title}} </a> </h2>
    @if (auth()->user() && auth()->user()->isAdmin())
        <a href="/admin/posts/">Change</a>
    @endif
    <p class="blog-post-meta">{{$post->created_at->format('d.m.Y H:i:s')}}</p>

    @include('posts.tags', ['tags' => $post->tags])

    {{$post->short_body}}
</div>