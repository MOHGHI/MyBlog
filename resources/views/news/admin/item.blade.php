<tr class="{{$new->published ? '' : 'published'}}">
    <th scope="row"><a href="/news/{{$new->slug}}">{{$new->id}}</a></th>
    <td>{{$new->title}}</td>
    <td>{{$new->short_body}}</td>
    <th><a href="/admin/news/{{$new->slug}}/edit">Изменить</a></th>
    <td>
        <form method="post" action="/admin/news/published/{{$new->slug}}">
            @if($new->published)
                @method('PATCH')
            @endif
            @csrf
            <label class="form-check-label">
                <input class="form-check-label"
                       type="checkbox"
                       name="published"
                       onclick="this.form.submit()"
                        {{$new->published ? 'checked' : ''}}>
            </label>
        </form>
    </td>
</tr>
