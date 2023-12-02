<button id="createGroupButton">Create Group</button>

<div id="addGroupForm" style="display: none;">
<form method="POST" action="{{ url('/group/add') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="name" class="Title-color">Create a new Group</label>
    <input id="name" type="text" name="name" placeholder="Write The title of the Group" style="color: white;" required autofocus>
    @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
    @endif
    <label for="description">Description</label>
    <input id="description" type="text" name="description" placeholder="Write a description of the Group" style="color: white;" required autofocus>
    @if ($errors->has('description'))
        <span class="error">
            {{ $errors->first('description') }}
        </span>
    @endif
    <label>
        Public Group? <input type="checkbox" name="public" checked>
    </label>
    <button type="submit">
        Create Group
    </button>
</form>
</div>

<script>
document.getElementById('createGroupButton').addEventListener('click', function() {
    var form = document.getElementById('addGroupForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
});
</script>
