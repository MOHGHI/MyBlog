@if (auth()->user() && auth()->user()->isAdmin())
    @php
        echo $section ?? '';
    @endphp
@endif