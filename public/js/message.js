
console.log("the value of the Echo socket is",Echo.socketId());


document.addEventListener('DOMContentLoaded', (event) => {
  var forms = document.querySelectorAll('form');
  var form = forms[forms.length - 1];

  form.addEventListener('submit', function(e) {
      e.preventDefault();

      var receivedIdInput = form.querySelector('#received_id');

      var receivedId = receivedIdInput.value;

      console.log(receivedId);

      var contentInput = form.querySelector('#content');

      var content = contentInput.value;
  });
});

console.log(window.Echo);  
let order_cur = -1; 
function updateMessage(e, form) {
  e.preventDefault();
  new Date();
  var receivedIdInput = form.querySelector('#received_id'); 
  var receivedId = receivedIdInput.value; 
  var emitsIdInput = form.querySelector('#emits_id'); 
  var emitsId = emitsIdInput.value; 
  var contentInput = form.querySelector('#content'); 
  var content = contentInput.value; 
  console.log(receivedId); 
  console.log(content); 
  sendAjaxRequest('POST', '/messages/send', {emits_id: emitsId,received_id: receivedId, content: content, date:Date(), is_viewed:false}, function(response) {
    console.log('Response:', response);
    contentInput.value = ''; 
  });
}

document.querySelectorAll('.message-form').forEach(form => {
  form.addEventListener('submit', function(e) {
    updateMessage(e, form);
  });
});

let userId = document.getElementById('user-identifier').dataset.userId;
console.log(userId);

let userIdRec = document.getElementById('user-identifier-rec').dataset.userIdRec;
console.log(userIdRec);

Echo.private(`user.${userId}-${userIdRec}`).listen('.App\\Events\\Messages', (e) => {
  let messageElement = document.createElement('div');

  messageElement.classList.add('message');

  let profileElement = document.createElement('div');
  profileElement.classList.add('profile');
  profileElement.textContent = e.emits_id; 

  let bodyElement = document.createElement('div');
  bodyElement.classList.add('body');
  bodyElement.textContent = e.content;

  let timestampElement = document.createElement('div');
  timestampElement.classList.add('timestamp');
  timestampElement.textContent = 'just now'; 

  messageElement.appendChild(profileElement);
  messageElement.appendChild(bodyElement);
  messageElement.appendChild(timestampElement);

  let messageCardElement = document.querySelector('.message-card');


  let messageContentElement = document.querySelector('.message-content');

  if (!messageContentElement) {
    messageContentElement = document.createElement('div');
    messageContentElement.classList.add('message-content');
    messageCardElement.prepend(messageContentElement);
  }

  messageContentElement.appendChild(messageElement);
});

function handleMessageSent(e) {
  let messages = document.getElementById('messages');
  messages.innerHTML += `<li>${e.message.content}</li>`;
}
