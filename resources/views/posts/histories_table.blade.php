<p>{{$item->name}} - {{$item->pivot->created_at->diffForHumans()}} - </p>
<table class="table">
    <thead>
    <tr>
        <th scope="col" colspan="2">Before</th>
        <th scope="col" colspan="2">After</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <th scope="col">Field</th>
        <th scope="col">Value</th>
        <th scope="col">Field</th>
        <th scope="col">Value</th>
    </tr>
    @foreach($keys as $key)
        <tr>
            <td>{{$key}}</td>
            <td>{{$befores[$key]}}</td>
            <td>{{$key}}</td>
            <td>{{$afters[$key]}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>