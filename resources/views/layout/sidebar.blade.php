<aside class="col-md-4 blog-sidebar">
    <div class="p-4 mb-3 bg-light rounded">
        <h4 class="font-italic">Tags</h4>
{{--        @include('posts.tags',['tags' => $tagsCloud])--}}
                @include('posts.tags',['tags' => \App\Tag::tagsCloud()])
    </div>
</aside>