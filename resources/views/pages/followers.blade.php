@extends('layouts.app')

@section('content')
    <div class="flex-container">
        @include('partials.sidebar')
        <div class="user-followers">
            <div class="search-container">
                <label for="searchc">Search:</label>
                <input type="text" id="searchc" oninput="filterUsers()">
            </div>

            @if (isset($follows) && count($follows) == 0)
                <h2>No follows yet</h2>
            @endif

            @foreach ($follows as $follow)
                @php
                    $user = \App\Models\User::findOrFail($follow->user_id1);
                @endphp

                <div class="profile-card">
                    <h2><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></h2>
                    <button id="remove{{ $user->id }}"
                        onclick="removeFollower({{ $user->id }},{{ Auth::user()->id }})" class="button-user">
                        <i class="fa-solid fa-user-minus"></i> Unfollow
                    </button>
                </div>
            @endforeach
        </div>
        @include('partials.sideSearchbar')
    </div>
    @include('partials.footer')

    <script>
        function filterUsers() {
            var input, filter, cards, card, h2, i, txtValue;
            input = document.getElementById("searchc");
            filter = input.value.toUpperCase();
            cards = document.getElementsByClassName("profile-card");

            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                h2 = card.getElementsByTagName("h2")[0];
                txtValue = h2.textContent || h2.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }
    </script>
@endsection
