<div class="edit-user-container">
    <div class="edit-user-card">
        <button id="openEditUserModal" class="fas fa-edit">Edit User</button>
        <div id="editUserModal" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        <form method="POST" action="{{ url('profile/edit') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <section class="edit-page-photo-options">
                <h4 for="image"><i class="fa-solid fa-image"></i> Choose a profile picture:</h4>
                <img id="edit-profile-photo" class="edit-page-image" src="{{ Auth::user()->media() }}" width=20%
                    alt="Profile image">
                <input type="file" name="image" id="image">
                <button form="removePhoto" class="edit-page-button">Remove Photo</button>
            </section>
            <input type="hidden" name="user_id" value="{{ request()->route('id') }}">
            <label for="name"><i class="fa-solid fa-user-pen"></i> Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
            @endif
            <label for="email"><i class="fa-solid fa-square-envelope"></i> E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
            <span class="error">
                {{ $errors->first('email') }}
            </span>
            @endif
            <label for="is_public"><i class="fa-solid fa-key"></i> Private Profile</label>
            <input id="is_public" type="hidden" name="is_public" value="0">
            <input id="is_public" type="checkbox" name="is_public" value="1" {{ old('is_public') !==null ? 'checked'
                : '' }}>
            @if ($errors->has('is_public'))
            <span class="error">
                {{ $errors->first('is_public') }}
            </span>
            @endif
            <div>
                <button type="submit">
                    Edit <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </div>
        </form>
    </div>
    </div>
    </div>
</div>


<script>
// Get the modal
var modal = document.getElementById("editUserModal");
console.log(modal);

// Get the button that opens the modal
var btn = document.getElementById("openEditUserModal");

console.log(btn);

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