@extends ('layouts.app')
@section('content')
    <div class="admin-container">
        @include('partials.sidebar')
        <div class="adminsearch">
            @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
            @endif

            <div class="main-menu admin-options">
                <button id="usersButton" onclick="UsersDropDown()"><i class="fa-solid fa-user"></i> Users</button>
                <button id="groupsButton" onclick="GroupsDropDown()"><i class="fa-solid fa-users"></i> Groups</button>
                <button id="spacesButton" onclick="SpacesDropDown()"><i class="fa-solid fa-comment"></i> Spaces</button>
            </div>

            <div id="adminUsersSearch" class="search-container" style="display: none;">
                <i class="fa-solid fa-magnifying-glass white-icon"></i>
                <input type="text" id="search" placeholder="User Search...">
                <div id="results-users"></div>
            </div>
            <div id="adminGroupsSearch" class="search-container" style="display: none;">
                <i class="fa-solid fa-magnifying-glass white-icon"></i>
                <input type="text" id="search" placeholder="Groups Search...">
                <div id="results-groups"></div>
            </div>
            <div id="adminSpacesSearch" class="search-container" style="display: none;">
                <i class="fa-solid fa-magnifying-glass white-icon"></i>
                <input type="text" id="search" placeholder="Spaces Search...">
                <div id="results-spaces"></div>
            </div>

            <div id="createUser" class="admincreate" style="display: none;">
                <button onclick="location.href='{{ url('/register') }}'" class="btn btn-primary">Create User</button>
            </div>
        </div>
    </div>
    @include('partials.footer')
@endsection
