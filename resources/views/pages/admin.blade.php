@extends ('layouts.app')
@section('content')
<div class="admin-container">

<div class="adminsearch">
        @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
        @endif
        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass white-icon"></i>
            <input type="text" id="search" placeholder="Admin Search..."> 
        </div>
        <div id="results-users"></div>
        <div id="results-spaces"></div>
</div>
</div>
@include('partials.footer')
@endsection
