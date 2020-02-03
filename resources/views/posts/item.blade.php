<div class="blog-post">
    <h2 class="blog-post-title"><a href="/post/{{$post->slug}}">{{$post->title}} </a> </h2>
    <p class="blog-post-meta">{{$post->created_at->format('d.m.Y H:i:s')}}</p>
    {{$post->short_body}}
</div>