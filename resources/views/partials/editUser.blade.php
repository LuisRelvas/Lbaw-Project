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
            <label for="password"><i class="fa-solid fa-lock"></i> Current Password</label>
        @if (Auth::user()->isAdmin(Auth::user()))
            <input id="oldPassword" type="password" name="oldPassword">
        @else
            <input id="oldPassword" type="password" name="oldPassword" >
        @endif
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif
    <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
        @if (Auth::user()->isAdmin(Auth::user()))
            <input id="password" type="password" name="password">
        @else
            <input id="password" type="password" name="password" >
        @endif
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif

    <label for="password-confirm"><i class="fa-solid fa-square-check"></i> Confirm Password</label>
        @if (Auth::user()->isAdmin(Auth::user()))
            <input id="password-confirm" type="password" name="password_confirmation">
        @else
            <input id="password-confirm" type="password" name="password_confirmation">
        @endif
            <input type="hidden" name="id" value="{{ request()->route('id') }}">

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

// Get the button that opens the modal
var btn = document.getElementById("openEditUserModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
  setTimeout(function() {
    modal.style.opacity = "1";
    modal.style.transform = "translate(-50%, -50%) scale(1)"; // Add this line
  }, 50); // Delay to ensure the modal is visible before starting the transition
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.opacity = "0";
  modal.style.transform = "translate(-50%, -50%) scale(0.9)"; // Add this line
  setTimeout(function() {
    modal.style.display = "none";
  }, 500); // Delay to ensure the transition finishes before hiding the modal
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.opacity = "0";
    modal.style.transform = "translate(-50%, -50%) scale(0.9)"; // Add this line
    setTimeout(function() {
      modal.style.display = "none";
    }, 500); // Delay to ensure the transition finishes before hiding the modal
  }
}
</script>