<form method="POST" action="{{ url('space/add') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="content">Content</label>
    <input id="content" type="text" name="content" required autofocus>
    
    @if ($errors->has('content'))
        <span class="error">
            {{ $errors->first('content') }}
        </span>
    @endif
    
    <button type="submit">
        Create Space
    </button>
</form>
