

console.log("the value of the Echo socket is",Echo.socketId());


document.addEventListener('DOMContentLoaded', (event) => {
  var forms = document.querySelectorAll('form');
  var form = forms[forms.length - 1];

  form.addEventListener('submit', function(e) {
      // Prevent the form from being submitted
      e.preventDefault();

      // Get the received_id input field
      var receivedIdInput = form.querySelector('#received_id');

      // Get the value of the received_id input field
      var receivedId = receivedIdInput.value;

      // Log the value to the console
      console.log(receivedId);

      // Get the content input field
      var contentInput = form.querySelector('#content');

      // Get the value of the content input field
      var content = contentInput.value;
  });
});

console.log(window.Echo);  
let order_cur = -1; 
function updateMessage(e, form) {
  e.preventDefault();
  new Date();
  var receivedIdInput = form.querySelector('#received_id'); // Get the received_id input field
  var receivedId = receivedIdInput.value; // Get the value of the received_id input field
  var emitsIdInput = form.querySelector('#emits_id'); // Get the emits_id input field
  var emitsId = emitsIdInput.value; // Get the value of the emits_id input field
  var contentInput = form.querySelector('#content'); // Get the content input field
  var content = contentInput.value; // Get the value of the content input field
  console.log(receivedId); // Log the value to the console
  console.log(content); // Log the message content to the console
  sendAjaxRequest('POST', '/messages/send', {emits_id: emitsId,received_id: receivedId, content: content, date:Date()}, function(response) {
    console.log('Response:', response);
});
}

document.querySelectorAll('.message-form').forEach(form => {
  form.addEventListener('submit', function(e) {
    updateMessage(e, form);
  });
});

let userId = document.getElementById('user-identifier').dataset.userId;

Echo.private(`user.${userId}`).listen('.App\\Events\\Messages', (e) => {
  // Create a new h1 element
  let messageElement = document.createElement('h1');

  // Set the content of the h1 element to the message content
  messageElement.textContent = e.content; // Change this line

  // Append the h1 element to the body of the document
  document.body.appendChild(messageElement);
});

function handleMessageSent(e) {
  let messages = document.getElementById('messages');
  messages.innerHTML += `<li>${e.message.content}</li>`;
}