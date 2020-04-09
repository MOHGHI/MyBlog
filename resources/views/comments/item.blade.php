<tr>
    <th scope="row"><a href="/feedback/{{$feedback->id}}">{{$feedback->id}}</a></th>
    <td>{{$feedback->email}}</td>
    <td>{{$feedback->message}}</td>
    <td>{{$feedback->created_at->format('d.m.Y H:i:s')}}</td>
</tr>
