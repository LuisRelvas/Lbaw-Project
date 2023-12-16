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