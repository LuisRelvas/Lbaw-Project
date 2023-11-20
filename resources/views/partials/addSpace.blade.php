<form method="POST" action="{{ url('space/add') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="content" class="label-color">Create a new Space</label>
    <input id="content" type="text" name="content" placeholder="Write space..." style="color: white;" required autofocus>

    @if ($errors->has('content'))
        <span class="error">
            {{ $errors->first('content') }}
        </span>
    @endif

    <button type="submit">
        Create Space
    </button>
</form>
