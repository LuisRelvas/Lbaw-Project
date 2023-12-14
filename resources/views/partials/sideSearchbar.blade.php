<div class="searchbar">
    <input type="text" id="search" placeholder="Search..." style="color: white;" pattern="[a-zA-Z0-9\s]+">
    <div id="results-users"></div>
    @if (Auth::check())
        <div id="results-spaces"></div>
        <div id="results-groups"></div>
        <div id="results-comments"></div>
    @endif
    @if (Auth::check())
        @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
        @endif
    @endif

    <div class ="trend-content">
        <h2>Trending</h2>
        <div class="trend">
            @if (Auth::check())
                @foreach ($trends as $trend)
                    @php
                        $real_space = \App\Models\Space::findOrFail($trend->space_id);
                    @endphp
                    <a href="/space/{{ $trend->space_id }}" class="trend-card">{{ $real_space->content }}</a>
                @endforeach
            @endif
        </div>
    </div>
</div>