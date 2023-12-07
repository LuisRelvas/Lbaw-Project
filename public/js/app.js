function encodeForAjax(data) {
  console.log('In the encode for Ajax the space is',data);
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();
  console.log('The value of the data is',data);
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


function showNotifications() {
  var notificationsContainer = document.getElementById('notificationsContainer');
  sendAjaxRequest('GET','/notification',null,function(response) {
    var notifications = JSON.parse(response.target.responseText);
    notificationsContainer.innerHTML = '';
    notifications.forEach(notification => {
      var p = document.createElement('p');
      p.textContent = JSON.stringify(notification); // Convert each notification object to a string
      notificationsContainer.appendChild(p);
    });

    notificationsContainer.style.display = 'block';
  });
}

function updateNotification(id) 
{
  let url = 'notification/' + id; 
  var method = 'PUT';
  var data = {
    id: id  };
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


function deleteNotification(id) {
  if (!confirm('Are you sure you want to delete this notification?')) {
    return;
  }
  
  var url = `api/notification/${id}`;
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


let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
Pusher.logToConsole = true;
const pusher = new Pusher('e0f29d0e833b76381d01', {
    cluster: 'eu',
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    }
});

var ownerChannel;
var userChannel;
var currentOwner; // The current owner of the page

function setupOwnerChannel(owner) {
    ownerChannel = pusher.subscribe('private-lbaw2372.' + owner);

    ownerChannel.bind('pusher:subscription_succeeded', function () {
        console.log('Owner Channel - Subscription succeeded');
    });

    ownerChannel.bind('notification-spaceLike', function (data) {
        console.log('Owner Channel - Space ID:', data.space_id);
        console.log('Owner Channel - Message:', data.message);
        data.message = 'User ' + ' liked your space.';
        showNotification(data.message);
    });
}

function setupUserChannel(user) {
    userChannel = pusher.subscribe('private-lbaw2372.' + user);

    userChannel.bind('pusher:subscription_succeeded', function () {
        console.log('User Channel - Subscription succeeded');
    });

    userChannel.bind('notification-spaceLike', function (data) {
        console.log('User Channel - Space ID:', data.space_id);
        console.log('User Channel - Message:', data.message);
        showNotification(data.message);
    });
}

function useCurrentOwner() {
  console.log('The value of the currentOwner OUTSIDE is', currentOwner);
}

let currentUrl = window.location.href;
let currentUrlParts = currentUrl.split('/');
let currentUrlOwner = currentUrlParts[currentUrlParts.length - 1];
setupOwnerChannel(window.spaceUserId);


function changeLikeState(id, liked, user, owner) {
    let url, data3;
    currentOwner = owner;
    useCurrentOwner();

    console.log("The value of the currentOwner is",currentOwner);
    let countElement = document.getElementById('countSpaceLikes' + id);
    let currentCount = parseInt(countElement.textContent);
    let likeButton = document.getElementById('likeButton' + id);
    console.log('The value of the currentOwner INSIDE is', currentOwner);
    if (!userChannel || !userChannel.subscribed) {
        // Set up the user channel if it's not already set up
        setupUserChannel(user);
    }

    switch (liked) {
        case true:
            url = '/space/unlike';
            data3 = { id: id };
            sendAjaxRequest('DELETE', url, data3, function (response) {
                console.log('Response:', response);
                countElement.textContent = currentCount - 1;
                likeButton.setAttribute('onclick', `changeLikeState(${id}, false,${user},${owner})`);
            });
            break;
        case false:
            let url2 = '/space/like';
            let data2 = { id: id };
            sendAjaxRequest('POST', url2, data2, function (response) {
                console.log('Response:', response);
                countElement.textContent = currentCount + 1;
                likeButton.setAttribute('onclick', `changeLikeState(${id}, true,${user},${owner})`);
                
                // Notify the user when they like a space
                userChannel.trigger('client-notification-spaceLike', {
                    space_id: id,
                    message: 'You liked the space.'
                });
            });
            break;
    }
}



function showNotification(message) {
  // Use SweetAlert2 or any other custom notification logic here
  Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: 'Space',
    text: message,
    showConfirmButton: false,
    timer: 3000 // Adjust the duration as needed
  });
}



function acceptInvite(id, notification_id) 
{
  console.log(notification_id);
  let url = '/group/acceptinvite';
  let data = {
    group_id: id
  };
  sendAjaxRequest('POST', url, data, function (response) {
    console.log('Response:', response);
    delNot(notification_id);
  });
}


function delNot(id) 
{
    var url = `api/notification/${id}`;
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
function declineInvite(id,notification_id)
{
  let url = '/group/declineinvite';
  let data = {
    group_id: id
  };
  sendAjaxRequest('DELETE', url, data, function (response) {
    console.log('Response:', response);
  });
}

function changeLikeStateC(id, liked, user, owner) {
  let url, data;
  let countElement = document.getElementById('countCommentLikes' + id);
  let currentCount = parseInt(countElement.textContent);
  let likeButton = document.getElementById('likeButton' + id); // Corrected here

  switch (liked) {
    case true:
      url = '/comment/unlike';
      data = { id: id };
      sendAjaxRequest('DELETE', url, data, function (response) {
        console.log('Response:', response);
        countElement.textContent = currentCount - 1;
        likeButton.setAttribute('onclick', `changeLikeStateC(${id}, false,${user},${owner})`);
      });
      break;
    case false:
      url = '/comment/like';
      data = { id: id };
      sendAjaxRequest('POST', url, data, function (response) {
        console.log('Response:', response);
        countElement.textContent = currentCount + 1;
        likeButton.setAttribute('onclick', `changeLikeStateC(${id}, true,${user},${owner})`);
      });
      break;
  }
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

///////////////////////////




function resetEditGroup(id) {
  let group = document.querySelector("#group" + id);
  let main = group.querySelector("main");

  // Hide the cancel button
  document.querySelector('#cancelEditGroup' + id).style.visibility = 'hidden';

  // Change the button back to edit
  let edit_button = document.querySelector("#editGroup" + id);
  edit_button.textContent = 'Edit';

  // Restore the original onclick function
  edit_button.onclick = function () {
      editGroup(id);
  };
}

function editGroup(id) {
  let group = document.querySelector("#group" + id);
  let main = group.querySelector("main");

  // Save the original content for cancel action
  let originalName = group.querySelector(".groupname").textContent.trim();
  let originalDescription = group.querySelector(".groupcontent").textContent.trim();

  // Transform the content into two text boxes
  let nameTextarea = document.createElement('textarea');
  nameTextarea.className = 'groupname';
  nameTextarea.value = originalName;

  let descriptionTextarea = document.createElement('textarea');
  descriptionTextarea.className = 'groupdescription';
  descriptionTextarea.value = originalDescription;

  main.innerHTML = ''; // Clear the main content
  main.appendChild(nameTextarea);
  main.appendChild(descriptionTextarea);

  // Show the cancel button
  document.querySelector('#cancelEditGroup' + id).style.visibility = 'visible';

  // Change the button to confirm
  let edit_button = document.querySelector("#editGroup" + id);
  edit_button.textContent = 'Confirm';

  main.dataset.originalName = originalName;
  main.dataset.originalDescription = originalDescription;

  // Change the onclick of the button
  edit_button.onclick = function () {
    // Get the updated content and visibility
    let updatedName = nameTextarea.value;
    let updatedDescription = descriptionTextarea.value;

    // Send an AJAX request to update the content on the server
    let url = '/group/edit';
    let data = {
      id: id,
      name: updatedName,
      description: updatedDescription
    };

    sendAjaxRequest('PUT', url, data, function (response) {
      console.log('Updated Content:', updatedName, updatedDescription);

      // Create new divs for the name and description
      let newNameDiv = document.createElement('div');
      newNameDiv.className = 'groupname';
      newNameDiv.textContent = updatedName;

      let newDescriptionDiv = document.createElement('div');
      newDescriptionDiv.className = 'groupcontent';
      newDescriptionDiv.textContent = updatedDescription;

      // Replace the textareas with the new divs
      main.innerHTML = '';
      main.appendChild(newNameDiv);
      main.appendChild(newDescriptionDiv);

      // Hide the cancel button
      document.querySelector('#cancelEditGroup' + id).style.visibility = 'hidden';

      // Change the button back to edit
      let edit_button = document.querySelector("#editGroup" + id);
      edit_button.textContent = 'Edit';

      // Restore the original onclick function
      edit_button.onclick = function () {
          editGroup(id);
      };
    });
  };
  }

  function cancelEditGroup(id) {
    let group = document.querySelector("#group" + id);
    let main = group.querySelector("main");
  
    // Get the original content from the main element's dataset
    let originalName = main.dataset.originalName;
    let originalDescription = main.dataset.originalDescription;
  
    // Create new divs for the name and description
    let newNameDiv = document.createElement('div');
    newNameDiv.className = 'groupname';
    newNameDiv.textContent = originalName;
  
    let newDescriptionDiv = document.createElement('div');
    newDescriptionDiv.className = 'groupcontent';
    newDescriptionDiv.textContent = originalDescription;
  
    // Replace the textareas with the new divs
    main.innerHTML = '';
    main.appendChild(newNameDiv);
    main.appendChild(newDescriptionDiv);
  
    // Reset the edit state
    resetEditGroup(id);
  }

function deleteGroup(id) {
  if (!confirm('Are you sure you want to delete this group?')) {
      return;
  }

  var url = `/api/group/${id}`;
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

function deleteProfile(id) {
  if (!confirm('Are you sure you want to delete your account?')) {
      return;
  }

  var url = `/api/profile/${id}`;
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
              window.location.href = '/logout';
          }
      } else {
          console.error('Error:', event.target.status, event.target.statusText);
      }
  });
}


function declineJoin(id,group_id)
{
  sendAjaxRequest('DELETE', '/group/joinrequest', {id: id,group_id:group_id}, function(response) {
    console.log('Response:', response);
  });
}

function declineFollowRequest(user_id1,user_id2)
{
  sendAjaxRequest('DELETE', '/profile/followsrequest', {user_id1: user_id1,user_id2:user_id2}, function(response) {
    console.log('Response:', response);
  });
}

function acceptJoin(id,group_id)
{

  let url = '/group/joinrequest/'+ id;
  console.log('the value of the url in accept is',url);
sendAjaxRequest('POST', url, {id: id,group_id:group_id}, function(response) {
  console.log('Response:', response);
});
}

function acceptFollowRequest(user_id1,user_id2)
{
  let url = '/profile/followsrequest/'+ user_id2;
  console.log('the value of the url in accept is',url);
sendAjaxRequest('POST', url, {user_id1: user_id1,user_id2:user_id2}, function(response) {
  console.log('Response:', response);
});
}




function changeProfileState(user_id2,user_id1,publicProfile)
{
  console.log('The boolean of the public profile is',publicProfile);
  const state_in_html = document.querySelector('#profileState' + user_id2).innerHTML.replace(/\s/g, '');
  const state = state_in_html.replace( /(<([^>]+)>)/ig,'');
  switch(state) {
    case 'Follow':
      if(publicProfile == null) {
        console.log('entered in a public profile');
        let url = '/profile/follow/' + user_id2;
        let data = {
          user_id1: user_id1,
          user_id2: user_id2
        };
        // Send the AJAX request
        sendAjaxRequest('POST', url, data, function(response) {
          console.log('Response:', response);
          // Change the button text to 'Unfollow'
          document.querySelector('#profileState' + user_id2).innerHTML = '<i id="text-icon" aria-hidden="true"></i> Unfollow';
        });
      }
      else 
      {
        console.log('The value of the id is',user_id2);
        console.log('The value of the user_id is',user_id1);
        sendAjaxRequest('POST', '/profile/followsrequest', {user_id1: user_id1, user_id2: user_id2}, function(response) {
          console.log('Response:', response);
          // Change the button text to 'Pending'
          document.querySelector('#profileState' + user_id2).innerHTML = 'Pending';
        });
      }
      break; 
      case 'Unfollow':
      let url = '/profile/unfollow/' + user_id2;
      let data = {
        user_id1: user_id1,
        user_id2: user_id2
      };
      sendAjaxRequest('DELETE', url, data, function(response){
        console.log('Response:', response);
        document.querySelector('#profileState' + user_id2).innerHTML = '<i id="text-icon" aria-hidden="true"></i> Follow';
      });
    }
} 

function changeGroupState(id,user_id,publicGroup)
{
  console.log('The boolean of the public group is',publicGroup);
  const state_in_html = document.querySelector('#groupState' + id).innerHTML.replace(/\s/g, '');
  const state = state_in_html.replace( /(<([^>]+)>)/ig,'');
  switch(state) {
    case 'JoinGroup':
      if(publicGroup == null) {
        console.log('entered in a public group');
        let url = '/group/join';
        let data = {
          id: id,
          user_id: user_id
        };
        // Send the AJAX request
        sendAjaxRequest('POST', url, data, function(response) {
          console.log('Response:', response);

        });
      }
      else 
      {
        console.log('The value of the id is',id);
        console.log('The value of the user_id is',user_id);
        sendAjaxRequest('POST', '/group/joinrequest', {id: id, user_id: user_id}, function(response) {
          console.log('Response:', response);
        });
      }
      break;
      case 'LeaveGroup': 
      let url = '/group/leave';
      let data = {
        id: id,
        user_id: user_id
      };
      sendAjaxRequest('DELETE', url, data, function(response){
        console.log('Response:', response);
      });
  }
}


function addMessage() {
  console.log('entered in the add message function');
  let url = '/messages/send';
  let data = {
      content: document.getElementById('messageContent').value,
      emits_id: document.getElementById('emitsId').value
  };

  sendAjaxRequest('POST', url, data, function(response) {
      console.log('Response:', response);
  });
}


function deleteMember(id) {
  var pathParts = window.location.pathname.split('/');
  var groupId = parseInt(pathParts[pathParts.length - 1]);

  console.log('The value of the id is', id);
  console.log('The value of the groupId is', groupId);
  if (!confirm('Are you sure you want to delete this member?')) {
    return;
  }

  var url = '/api/group/' + groupId;  // Corrected line
  var method = 'DELETE';
  
  let data = {
    groupId: groupId,
    userId: id
  };

  sendAjaxRequest(method, url, data, function(event) {
    if (event.target.status === 200) {
      var response = JSON.parse(event.target.responseText);
      console.log(response); // Log the server response (optional)
    } else {
      console.error('Error:', event.target.status, event.target.statusText);
    }
  });
}




async function getAPIResult(type, search) {
  // Use a regular expression to allow only letters and numbers
  const sanitizedSearch = search.replace(/[^a-zA-Z0-9]/g, '');

  const query = `../api/${type}?search=${sanitizedSearch}`;
  const response = await fetch(query);

  return response.text();
}


function updateTotal(quantity, id) {
let statistic = document.getElementById(id)
if (statistic) {
  statistic.innerHTML = statistic.innerHTML.replace(/\d+/g, quantity)
}
}

function handleUsers() {
  document.getElementById('users').style.display = 'block';
  document.getElementById('spaces').style.display = 'none';
  document.getElementById('comments').style.display = 'none';
}

function handleSpaces() {
  document.getElementById('users').style.display = 'none';
  document.getElementById('spaces').style.display = 'block';
  document.getElementById('comments').style.display = 'none';
}

function handleComments() {
  document.getElementById('users').style.display = 'none';
  document.getElementById('spaces').style.display = 'none';
  document.getElementById('comments').style.display = 'block';
}

function handlePrincipal() {
  document.getElementById('users').style.display = 'block';
  document.getElementById('spaces').style.display = 'block';
  document.getElementById('comments').style.display = 'block';
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
function handleSearchButtonClick() {
  const searchInput = document.querySelector("#search").value;
  
  search(searchInput);
}
init();

