@if(session()->has('message'))
    <div class="container">
    <div class="alert alert-{{session('message_type')}} mt-4">
        {{session('message')}}
    </div>
    </div>
@endif