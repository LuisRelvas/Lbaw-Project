function encodeForAjax(data) {
  console.log('In the encode for Ajax the space is',data);
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function resetEditStateComment(id) {
  let comment = document.querySelector("#comment" + id);
  let content = comment.querySelector(".content");
  console.log(content);

  // Restore the original content
  content.textContent = content.dataset.originalContent;

  // Hide the cancel button
  document.querySelector('#cancelEditComment' + id).style.visibility = 'hidden';

  // Change the button back to edit
  let edit_button = document.querySelector("#editComment" + id);
  let edit_button_icon = edit_button.querySelector("#text-icon");
  edit_button_icon.classList.remove("fa-floppy-o");
  edit_button_icon.classList.add("fa-pencil");

  // Restore the original onclick function
  let button = document.querySelector('#editComment' + id);
  button.onclick = function () {
      editComment(id);
  };
}

function cancelEditComment(id) {
  let comment = document.querySelector("#comment" + id);
  let content = comment.querySelector(".content");
  // Restore the original content
  content.textContent = content.dataset.originalContent;
  // Reset the edit state
  resetEditStateComment(id);
}


function editComment(id) {
  let comment = document.querySelector("#comment" + id);
  console.log(id);
  console.log(comment);

  if (!comment) {
      console.error("Comment element not found");
      return;
  }

  let content = comment.querySelector(".content");

  if (!content) {
      console.error("Content element not found within the comment element");
      return;
  }

  // Save the original content for cancel action
  let originalContent = content.textContent.trim();
  content.dataset.originalContent = originalContent;

  // Transform the content into a textbox
  let textarea = document.createElement('textarea');
  textarea.type = 'textbox';
  textarea.className = 'content';
  textarea.value = originalContent;
  content.innerHTML = ''; // Clear the content
  content.appendChild(textarea);

  // Make the cancel button visible
  document.querySelector('#cancelEditComment' + id).style.visibility = 'visible';

  // Change the edit button to a confirm button
  let edit_button = document.querySelector("#editComment" + id);
  let edit_button_icon = edit_button.querySelector("#text-icon");
  edit_button_icon.classList.remove("fa-pencil");
  edit_button_icon.classList.add("fa-floppy-o");

  // Change the onclick of the button
  let button = document.querySelector('#editComment' + id);
  button.onclick = function () {
    // Get the updated content
    let updatedContent = textarea.value;
    // Update the content on the page
    content.innerHTML = updatedContent;

    // Send an AJAX request to update the content on the server
    let url = '/comment/edit'; // Replace with the actual server endpoint
    let data = {
      id: id,
      content: updatedContent
    };
    console.log('The value of data is',data);


    sendAjaxRequest('PUT', url, data, function (response) {
      // Reset the edit state
      content.innerHTML = updatedContent;
      content.dataset.originalContent = updatedContent;
      console.log('Updated Content:', updatedContent);
      resetEditStateComment(id);
    });
  };

}


function resetEditState(id) {
let space = document.querySelector("#space" + id);
let main = space.querySelector("main");

// Hide the cancel button
document.querySelector('#cancelEditSpace' + id).style.visibility = 'hidden';

// Change the button back to edit
let edit_button = document.querySelector("#editSpace" + id);
let edit_button_icon = edit_button.querySelector("#text-icon");
edit_button_icon.classList.remove("fa-floppy-o");
edit_button_icon.classList.add("fa-pencil");

// Restore the original onclick function
let button = document.querySelector('#editSpace' + id);
button.onclick = function () {
  editSpace(id);
};
}

function editSpace(id) {
  let space = document.querySelector("#space" + id);
  if (!space) {
      console.error("Space element not found");
      return;
  }

  let main = space.querySelector("main");

  if (!main) {
      console.error("Main element not found within the space element");
      return;
  }

  // Save the original content for cancel action
  let originalContent = main.textContent.trim();
  main.dataset.originalContent = originalContent; 
  
  // transformar o content numa caixa de texto
  let textarea = document.createElement('textarea');
  textarea.type = 'textbox';
  textarea.className = 'spacecontent';
  textarea.value = originalContent;
  main.innerHTML = ''; // Clear the main content
  main.appendChild(textarea);

  // construção de uma checkbox com base no .innerHTML
  document.querySelector('#cancelEditSpace' + id).style.visibility = 'visible';

  // change button edit to confirm
  let edit_button = document.querySelector("#editSpace" + id);
  let edit_button_icon = edit_button.querySelector("#text-icon");
  edit_button_icon.classList.remove("fa-pencil");
  edit_button_icon.classList.add("fa-floppy-o");

  // mudar o onclick do botão
  let button = document.querySelector('#editSpace' + id);
  button.onclick = function () {
    // Get the updated content and visibility
    let updatedContent = textarea.value;

    // Send an AJAX request to update the content on the server
    let url = '/space/' + id // Replace with the actual server endpoint
    let data = {
      id: id,
      content: updatedContent
    };
    console.log('The value of data from space is',data);
    sendAjaxRequest('PUT', url, data, function (response) {
      console.log('Updated Content:', updatedContent);
      // Update the content on the page
      main.innerHTML = updatedContent;
      // Update the originalContent data attribute
      main.dataset.originalContent = updatedContent;
      // Reset the edit state
      resetEditState(id);
    });
  };
}
function cancelEditSpace(id) {
let space = document.querySelector("#space" + id);
let main = space.querySelector("main");
// Restore the original content
main.textContent = main.dataset.originalContent;
// Reset the edit state
resetEditState(id);
}

function deleteSpace(id) {
if (!confirm('Are you sure you want to delete this space?')) {
  return;
}

var url = `/api/space/${id}`;
var method = 'DELETE';
var data = null; // No data to send for a DELETE request

sendAjaxRequest(method, url, data, function(event) {
  if (event.target.status === 200) {
    var response = JSON.parse(event.target.responseText);
    console.log(response); // Log the server response (optional)
    
    // Redirect to the appropriate URL based on whether the user is an admin
    if (response.isAdmin) {
      window.location.href = '/admin';
    } else {
      window.location.href = '/homepage';
    }
  } else {
    console.error('Error:', event.target.status, event.target.statusText);
  }
});
}

function deleteComment(id) {
  if (!confirm('Are you sure you want to delete this comment?')) {
      return;
  }

  var pathParts = window.location.pathname.split('/');
  var spaceId = pathParts[pathParts.length - 1];
  var url = `/api/comment/${id}`;
  var method = 'DELETE';
  var data = null; // No data to send for a DELETE request

sendAjaxRequest(method, url, data, function(event) {
  if (event.target.status === 200) {
    console.log(event.target.responseText); // Log the server response (optional)
    
    // Redirect to the back URL after successful deletion
    window.location.href = '/space/' + spaceId;
  } else {
    console.error('Error:', event.target.status, event.target.statusText);
  }
});
}



async function getAPIResult(type, search) {
  const query = '../api/' + type + '?search=' + search
  const response = await fetch(query)
  return response.text()
}

function updateTotal(quantity, id) {
let statistic = document.getElementById(id)
if (statistic) {
  statistic.innerHTML = statistic.innerHTML.replace(/\d+/g, quantity)
}
}


async function search(input) {
document.querySelector('#results-users').innerHTML = await getAPIResult('profile', input);
document.querySelector('#results-spaces').innerHTML = await getAPIResult('space', input);
updateTotal((document.querySelector('#results-users').innerHTML.match(/<article/g) || []).length, 'userResults');
updateTotal((document.querySelector('#results-spaces').innerHTML.match(/<article/g) || []).length, 'spaceResults');

}

function init() {
const search_bar = document.querySelector("#search");
if (search_bar) {
    let initial_input = window.location.toString().match(/query=(.*)$/g);
    if (initial_input != null) {
        search_bar.value = decodeURIComponent(initial_input[0].replace('query=', ''));
        search(search_bar.value.replace('#', ''));
        search(input);
    }
    search_bar.addEventListener('input', function () {
        let input = this.value.replace('#', '');
        search(input);
    });
}
}

document.addEventListener('DOMContentLoaded', function() {
  var form = document.getElementById('loginForm');
  var introText = document.getElementById('introText');
  var button = document.getElementById('toggleLoginForm');

  if (button) {
      button.addEventListener('click', function() {
          if (form.style.display === "none") {
              form.style.display = "block";
              introText.style.display = "none";
              button.style.display = "none"; // Hide the button
          } else {
              form.style.display = "none";
              introText.style.display = "block";
              button.style.display = "block"; // Show the button
          }
      });
  }
});

function handleSearchButtonClick() {
  const searchInput = document.querySelector("#search").value;
  search(searchInput);
}

init();

