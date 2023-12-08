<button id="createSpaceButton">Create Space</button>
<div id="addSpaceForm" style="display: none;">
<form method="POST" action="{{ url('space/add') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="content" class="label-color">Create a new Space</label>
    <input id="content" type="text" name="content" placeholder="Write space..." style="color: white;" required autofocus>
    @if ($errors->has('content'))
        <span class="error">
            {{ $errors->first('content') }}
        </span>
    @endif
    <section class="edit-page-photo-options">
        <h4 for="image">Choose a profile picture:</h4>
        <input type="file" name="image" id="image">
    </section>
    <label>
        Public Group? <input type="checkbox" name="public" checked>
    </label>
    <button type="submit">
        Create Space
    </button>
</form>
</div>


<script>
document.getElementById('createSpaceButton').addEventListener('click', function() {
    var form = document.getElementById('addSpaceForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
});
</script>
