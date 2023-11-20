@extends ('layouts.app')
@section('content')
<div class="adminsearch">
        @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
        @endif
    <input type="text" id="search" placeholder="Admin Search..."> 
    <div id="results-users"></div>
    <div id="results-spaces"></div>
</div>


@endsection
