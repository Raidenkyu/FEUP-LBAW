$('.team-profile-add-managers').on('keyup', searchManagersRequest);
$('.team-profile-add-developers').on('keyup', searchDevelopersRequest);
$('#create-project-form').on('submit', createProjectRequest);

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
      item.innerHTML = `<img src="/images/${json[i].id_member}.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><a>${json[i].name}</a>`
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
      item.innerHTML = `<img src="/images/${json[i].id_member}.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><a>${json[i].name}</a>`
      results.appendChild(item);
    }
  }
}

function addManager(event){
  let pic = document.createElement('img');
  managersList.push(parseInt(event.target.parentNode.getAttribute('id_member')));
  pic.classList.add('mr-2');
  pic.classList.add('rounded-circle');
  pic.classList.add('team-profile-icon');
  pic.setAttribute('src', `/images/${event.target.parentNode.getAttribute('id_member')}.jpg`)
  event.target.parentNode.parentNode.parentNode.querySelector('.pics').appendChild(pic);

  $('.team-profile-add-managers').val('');

  let results = document.querySelector('.results.managers');
  while (results.firstChild) {
    results.removeChild(results.firstChild);
  }

  inputFocusOut(document.querySelector('.team-profile-add-managers'));
}

function addDeveloper(event){
  let pic = document.createElement('img');
  developersList.push(parseInt(event.target.parentNode.getAttribute('id_member')));
  pic.classList.add('mr-2');
  pic.classList.add('rounded-circle');
  pic.classList.add('team-profile-icon');
  pic.setAttribute('src', `/images/${event.target.parentNode.getAttribute('id_member')}.jpg`)
  event.target.parentNode.parentNode.parentNode.querySelector('.pics').appendChild(pic);

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
