function addEventListeners() {
    let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
    [].forEach.call(itemCheckers, function(checker) {
      checker.addEventListener('change', sendItemUpdateRequest);
    });
  
    let itemCreators = document.querySelectorAll('article.card form.new_item');
    [].forEach.call(itemCreators, function(creator) {
      creator.addEventListener('submit', sendCreateItemRequest);
    });
  
    let itemDeleters = document.querySelectorAll('article.card li a.delete');
    [].forEach.call(itemDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteItemRequest);
    });
  
    let cardDeleters = document.querySelectorAll('article.card header a.delete');
    [].forEach.call(cardDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteCardRequest);
    });
  
    let cardCreator = document.querySelector('article.card form.new_card');
    if (cardCreator != null)
      cardCreator.addEventListener('submit', sendCreateCardRequest);
  }
  
  function encodeForAjax(data) {
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
  
  function sendItemUpdateRequest() {
    let item = this.closest('li.item');
    let id = item.getAttribute('data-id');
    let checked = item.querySelector('input[type=checkbox]').checked;
  
    sendAjaxRequest('space', '/api/item/' + id, {done: checked}, itemUpdatedHandler);
  }
  
  function sendDeleteItemRequest() {
    let id = this.closest('li.item').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
  }
  
  function sendCreateItemRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
    let description = this.querySelector('input[name=description]').value;
  
    if (description != '')
      sendAjaxRequest('put', '/api/cards/' + id, {description: description}, itemAddedHandler);
  
    event.preventDefault();
  }
  
  function sendDeleteCardRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
  }
  
  function sendCreateCardRequest(event) {
    let name = this.querySelector('input[name=name]').value;
  
    if (name != '')
      sendAjaxRequest('put', '/api/cards/', {name: name}, cardAddedHandler);
  
    event.preventDefault();
  }
  
  function itemUpdatedHandler() {
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    let input = element.querySelector('input[type=checkbox]');
    element.checked = item.done == "true";
  }
  
  function itemAddedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
  
    // Create the new item
    let new_item = createItem(item);
  
    // Insert the new item
    let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
    let form = card.querySelector('form.new_item');
    form.previousElementSibling.append(new_item);
  
    // Reset the new item form
    form.querySelector('[type=text]').value="";
  }
  
  function itemDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    element.remove();
  }
  
  function cardDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
    let article = document.querySelector('article.card[data-id="'+ card.id + '"]');
    article.remove();
  }
  
  function cardAddedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
  
    // Create the new card
    let new_card = createCard(card);
  
    // Reset the new card input
    let form = document.querySelector('article.card form.new_card');
    form.querySelector('[type=text]').value="";
  
    // Insert the new card
    let article = form.parentElement;
    let section = article.parentElement;
    section.insertBefore(new_card, article);
  
    // Focus on adding an item to the new card
    new_card.querySelector('[type=text]').focus();
  }
  
  function createCard(card) {
    let new_card = document.createElement('article');
    new_card.classList.add('card');
    new_card.setAttribute('data-id', card.id);
    new_card.innerHTML = `
  
    <header>
      <h2><a href="cards/${card.id}">${card.name}</a></h2>
      <a href="#" class="delete">&#10761;</a>
    </header>
    <ul></ul>
    <form class="new_item">
      <input name="description" type="text">
    </form>`;
  
    let creator = new_card.querySelector('form.new_item');
    creator.addEventListener('submit', sendCreateItemRequest);
  
    let deleter = new_card.querySelector('header a.delete');
    deleter.addEventListener('click', sendDeleteCardRequest);
  
    return new_card;
  }
  
  function createItem(item) {
    let new_item = document.createElement('li');
    new_item.classList.add('item');
    new_item.setAttribute('data-id', item.id);
    new_item.innerHTML = `
    <label>
      <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
    </label>
    `;
  
    new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
    new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);
  
    return new_item;
  }

  function parseContentEdit(content){
    return content.replace(/(<([^>]+)>)/ig, "");
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
      // Update the content on the page
      main.innerHTML = updatedContent;

      // Send an AJAX request to update the content on the server
      let url = '/space/{id}'; // Replace with the actual server endpoint
      let data = {
        id: id,
        content: updatedContent
      };

      sendAjaxRequest('PUT', url, data, function (response) {
        console.log('Updated Content:', updatedContent);
        // Reset the edit state
        resetEditState(id);
      });
    };
}

function cancelEditSpace(id) {
    // Reset the edit state to the original content
    resetEditState(id);
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
  document.querySelector('#results-users').innerHTML = await getAPIResult('profile', input)
  updateTotal((document.querySelector('#results-users').innerHTML.match(/<article/g) || []).length, 'userResults');
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

  
  addEventListeners();
  