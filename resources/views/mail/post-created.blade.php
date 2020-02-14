@component('mail::message')
# New post was created

{{$post->body}}
@component('mail::button', ['url' => '/posts/' . $post->slug])
    See the created post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
