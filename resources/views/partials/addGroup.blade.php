<button id="openFormButton" class="fas fa-plus"></button>

<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
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
</div>

<!-- JavaScript to handle the button click -->
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("openFormButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
  setTimeout(function() {
    modal.style.opacity = "1";
  }, 50); // Delay to ensure the modal is visible before starting the transition
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.opacity = "0";
  setTimeout(function() {
    modal.style.display = "none";
  }, 500); // Delay to ensure the transition finishes before hiding the modal
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.opacity = "0";
    setTimeout(function() {
      modal.style.display = "none";
    }, 500); // Delay to ensure the transition finishes before hiding the modal
  }
}
</script>
