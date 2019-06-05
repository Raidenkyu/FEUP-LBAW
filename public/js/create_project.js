$('.team-profile-add-managers').on('keyup', searchManagersRequest);
$('.team-profile-add-developers').on('keyup', searchDevelopersRequest);
$('#create-project-form').on('submit', createProjectRequest);
$('.delete-circle').on('click', removeUser);
$('.one-pic').on('mouseover', addX);
$('.one-pic').on('mouseout', removeX);

function addX(event){
  event.target.parentNode.querySelector('.delete-circle').classList.add('showing');
}
function removeX(event){
  event.target.parentNode.querySelector('.delete-circle').classList.remove('showing');
}

function removeUser(event){
  let id = parseInt(event.target.getAttribute('id_member'));

  if(managersList.includes(id) && managersList.length > 1){
    managersList.splice(managersList.indexOf(id), 1);
    event.target.parentNode.remove();
  } else if(developersList.includes(id)){
    developersList.splice(developersList.indexOf(id), 1);
    event.target.parentNode.remove();
  }
}

function createProjectRequest(event){
  event.preventDefault();

  let projectName = $('input.project-name').val();

  if(projectName != '')
    sendAjaxRequest('post', '/projects', {name: projectName, color: selectedColor, managers: JSON.stringify(managersList), developers: JSON.stringify(developersList), _token: token}, createProjectHandler);
}

function createProjectHandler(event){
  if (this.status != 200) window.location = '/';
  let json = JSON.parse(this.responseText);
  window.location.href = json;
}

function searchManagersRequest(event){
  let content = $(this).val();
  sendAjaxRequest('POST', "/projects/search", {content: content, _token: token}, searchManagersHandler);
}

function searchDevelopersRequest(event){
  let content = $(this).val();
  sendAjaxRequest('POST', "/projects/search", {content: content, _token: token}, searchDevelopersHandler);
}

function searchManagersHandler(event){
  if (this.status != 200) window.location = '/';
  let json = JSON.parse(this.responseText);
  let results = document.querySelector('.results.managers');

  if(json.length > 0)
    results.classList.remove('hidden');
  else{
    results.classList.add('hidden');
  }

  for (var i = 0; i < json.length; i++) {
    while (results.firstChild) {
      results.removeChild(results.firstChild);
    }

    if(!managersList.includes(json[i].id_member) && !developersList.includes(json[i].id_member)){
      let item = document.createElement('div');
      item.addEventListener('click', addManager);
      item.classList.add('item');
      item.setAttribute('id_member', json[i].id_member);
      item.innerHTML = `<img id_member="${json[i].id_member}" src="/images/${json[i].id_member}.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><a id_member="${json[i].id_member}">${json[i].name}</a>`
      results.appendChild(item);
    }
  }
}

function searchDevelopersHandler(event){
  if (this.status != 200) window.location = '/';
  let json = JSON.parse(this.responseText);
  let results = document.querySelector('.results.developers');

  if(json.length > 0)
    results.classList.remove('hidden');
  else{
    results.classList.add('hidden');
  }

  for (var i = 0; i < json.length; i++) {
    while (results.firstChild) {
      results.removeChild(results.firstChild);
    }

    if(!managersList.includes(json[i].id_member) && !developersList.includes(json[i].id_member)){
      let item = document.createElement('div');
      item.addEventListener('click', addDeveloper);
      item.classList.add('item');
      item.setAttribute('id_member', json[i].id_member);
      item.innerHTML = `<img id_member="${json[i].id_member}" src="/images/${json[i].id_member}.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><a id_member="${json[i].id_member}">${json[i].name}</a>`
      results.appendChild(item);
    }
  }
}

function addManager(event){
  let pic = document.createElement('container');
  pic.classList.add('one-pic');
  pic.addEventListener('mouseover', addX);
  pic.addEventListener('mouseout', removeX);
  pic.innerHTML = `<img id_member="${event.target.getAttribute('id_member')}" src="/images/${event.target.getAttribute('id_member')}.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><img id_member="${event.target.getAttribute('id_member')}" src="/icons/delete.png" class="delete-circle mr-2 rounded-circle team-profile-icon" alt="Responsive image">`
  pic.querySelector('.delete-circle').addEventListener('click', removeUser);
  managersList.push(parseInt(event.target.getAttribute('id_member')));
  document.querySelector('.managers-pics').appendChild(pic);

  $('.team-profile-add-managers').val('');

  let results = document.querySelector('.results.managers');
  while (results.firstChild) {
    results.removeChild(results.firstChild);
  }

  inputFocusOut(document.querySelector('.team-profile-add-managers'));
}

function addDeveloper(event){
  let pic = document.createElement('container');
  pic.classList.add('one-pic');
  pic.addEventListener('mouseover', addX);
  pic.addEventListener('mouseout', removeX);
  pic.innerHTML = `<img id_member="${event.target.getAttribute('id_member')}" src="/images/${event.target.getAttribute('id_member')}.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><img id_member="${event.target.getAttribute('id_member')}" src="/icons/delete.png" class="delete-circle mr-2 rounded-circle team-profile-icon" alt="Responsive image">`
  pic.querySelector('.delete-circle').addEventListener('click', removeUser);
  developersList.push(parseInt(event.target.getAttribute('id_member')));
  document.querySelector('.developers-pics').appendChild(pic);

  $('.team-profile-add-developers').val('');

  let results = document.querySelector('.results.developers');
  while (results.firstChild) {
    results.removeChild(results.firstChild);
  }

  inputFocusOut(document.querySelector('.team-profile-add-developers'));
}

$('.color-picker').click(function(event){
  let colorSelected = document.querySelector('.color-selected');
  if(this != colorSelected){
    $(colorSelected).removeClass("color-selected");
    $(this).addClass("color-selected");
    selectedColor = getColor($('.color-picker').index(this));
  }
});

$('.team-profile-add-managers, .team-profile-add-developers').on('focus', teamProfileOnFocus);

function teamProfileOnFocus(event){
  event.target.setAttribute('placeholder', '');
  event.target.style.borderRadius = '5px';
  event.target.style.width = '300px';
  event.target.style.textAlign = 'left';
}

$('.team-profile-add-managers, .team-profile-add-developers').on('focusout', teamProfileOnFocusOut);

function teamProfileOnFocusOut(event){
  if(event.target.value == ''){
    event.target.setAttribute('placeholder', '+');
    event.target.value = '';
    event.target.style.borderRadius = '100px';
    event.target.style.width = '50px';
    event.target.style.textAlign = 'center';
    let results = event.target.parentNode.querySelector('.results');
    results.classList.add('hidden');
    while (results.firstChild) {
      results.removeChild(results.firstChild);
    }
  }
}

function inputFocusOut(element){
  element.setAttribute('placeholder', '+');
  element.value = '';
  element.style.borderRadius = '100px';
  element.style.width = '50px';
  element.style.textAlign = 'center';
  let results = element.parentNode.querySelector('.results');
  results.classList.add('hidden');
  while (results.firstChild) {
    results.removeChild(results.firstChild);
  }
}

function getColor(id){
  var colors = ['Orange', 'Yellow', 'Red', 'Green', 'Lilac', 'Sky', 'Brown', 'Golden', 'Bordeaux', 'Emerald', 'Purple', 'Blue'];
  return colors[id];
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}
