<tr class="{{$post->published ? '' : 'published'}}">
    <th scope="row"><a href="/posts/{{$post->slug}}">{{$post->id}}</a></th>
    <td>{{$post->title}}</td>
    <td>{{$post->short_body}}</td>
    <td>{{($post->owner()->pluck('name')->toArray()[0])}}</td>
    <td>
        <form method="post" action="/admin/published/{{$post->slug}}">
            @if($post->published)
                @method('PATCH')
            @endif
            @csrf
            <label class="form-check-label">
                <input class="form-check-label"
                       type="checkbox"
                       name="published"
                       onclick="this.form.submit()"
                        {{$post->published ? 'checked' : ''}}>
            </label>
        </form>
    </td>
</tr>
