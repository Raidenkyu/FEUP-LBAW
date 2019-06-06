document.querySelector('#range-min').addEventListener('mouseup', function(event){
  if(event.target.value > rangeMax)
    event.target.value = rangeMin;
  else
    rangeMin = event.target.value;

    document.querySelector('#range-min-value').innerHTML = rangeMin;
});


document.querySelector('#range-max').addEventListener('mouseup', function(event){
  if(event.target.value < rangeMin)
    event.target.value = rangeMax;
  else
    rangeMax = event.target.value;

  document.querySelector('#range-max-value').innerHTML = rangeMax;
});

[].forEach.call(document.querySelectorAll('.managers-pics .one-pic .delete-circle'), function(manager) {
  managersList.push(parseInt(manager.getAttribute('id_member')));
});

[].forEach.call(document.querySelectorAll('.developers-pics .one-pic .delete-circle'), function(developer) {
  developersList.push(parseInt(developer.getAttribute('id_member')));
});

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
    sendAjaxRequest('delete', `/projects/${idProject}/remove`, {id: id, _token: token}, function(){
      if (this.status != 200) window.location = '/';
      let json = JSON.parse(this.responseText);
    });
  } else if(developersList.includes(id)){
    developersList.splice(developersList.indexOf(id), 1);
    event.target.parentNode.remove();
    sendAjaxRequest('delete', `/projects/${idProject}/remove`, {id: id, _token: token}, function(){
      if (this.status != 200) window.location = '/';
      let json = JSON.parse(this.responseText);
    });
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
  let filter = document.querySelector('#filter-checkbox');
  let content = $(this).val();
  let languages = filter.checked? document.querySelector('input[name=languages]').value  : '';
  let location = filter.checked? document.querySelector('input[name=location]').value  : '';
  let ageMin = filter.checked? document.querySelector('#range-min').value : '';
  let ageMax = filter.checked? document.querySelector('#range-max').value : '';
  sendAjaxRequest('POST', "/projects/search", {content: content, languages: languages, location: location, ageMin: ageMin, ageMax: ageMax,  _token: token}, searchManagersHandler);
}

function searchDevelopersRequest(event){
  let filter = document.querySelector('#filter-checkbox');
  let content = $(this).val();
  let languages = filter.checked? document.querySelector('input[name=languages]').value  : '';
  let location = filter.checked? document.querySelector('input[name=location]').value  : '';
  let ageMin = filter.checked? document.querySelector('#range-min').value : '';
  let ageMax = filter.checked? document.querySelector('#range-max').value : '';
  sendAjaxRequest('POST', "/projects/search", {content: content, languages: languages, location: location, ageMin: ageMin, ageMax: ageMax,  _token: token}, searchDevelopersHandler);
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

  while (results.firstChild) {
    results.removeChild(results.firstChild);
  }

  let j = 0;

  for (var i = 0; i < json.length; i++) {

    if(!managersList.includes(json[i].id_member) && !developersList.includes(json[i].id_member)){
      j++;
      let item = document.createElement('div');
      item.addEventListener('click', addManager);
      item.classList.add('item');
      item.setAttribute('id_member', json[i].id_member);
      item.innerHTML = `<img id_member="${json[i].id_member}" src="/profile/${json[i].id_member}/image" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><a id_member="${json[i].id_member}">${json[i].name}</a>`
      results.appendChild(item);
    }
  }

  if(j == 0) results.classList.add('hidden');
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

  while (results.firstChild) {
    results.removeChild(results.firstChild);
  }

  let j = 0;

  for (var i = 0; i < json.length; i++) {

    if(!managersList.includes(json[i].id_member) && !developersList.includes(json[i].id_member)){
      j++;
      let item = document.createElement('div');
      item.addEventListener('click', addDeveloper);
      item.classList.add('item');
      item.setAttribute('id_member', json[i].id_member);
      item.innerHTML = `<img id_member="${json[i].id_member}" src="/profile/${json[i].id_member}/image" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><a id_member="${json[i].id_member}">${json[i].name}</a>`
      results.appendChild(item);
    }
  }

  if(j == 0) results.classList.add('hidden');
}

function addManager(event){
  let id = event.target.getAttribute('id_member');

  sendAjaxRequest('post', `/projects/${idProject}/add`, {id: id, manager: 'true', _token: token}, function(){
    if (this.status != 200) window.location = '/';
    let json = JSON.parse(this.responseText);

    let pic = document.createElement('container');
    pic.classList.add('one-pic');
    pic.addEventListener('mouseover', addX);
    pic.addEventListener('mouseout', removeX);
    pic.innerHTML = `<img id_member="${json}" src="/profile/${json}/image" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><img id_member="${json}" src="/icons/delete.png" class="delete-circle mr-2 rounded-circle team-profile-icon" alt="Responsive image">`
    pic.querySelector('.delete-circle').addEventListener('click', removeUser);
    managersList.push(parseInt(json));
    document.querySelector('.managers-pics').appendChild(pic);

    $('.team-profile-add-managers').val('');

    let results = document.querySelector('.results.managers');
    while (results.firstChild) {
      results.removeChild(results.firstChild);
    }

    inputFocusOut(document.querySelector('.team-profile-add-managers'));
  });
}

function addDeveloper(event){
  let id = event.target.getAttribute('id_member');

  sendAjaxRequest('post', `/projects/${idProject}/add`, {id: id, manager: 'false', _token: token}, function(){
    if (this.status != 200) window.location = '/';
    let json = JSON.parse(this.responseText);

    let pic = document.createElement('container');
    pic.classList.add('one-pic');
    pic.addEventListener('mouseover', addX);
    pic.addEventListener('mouseout', removeX);
    pic.innerHTML = `<img id_member="${json}" src="/profile/${json}/image" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"><img id_member="${json}" src="/icons/delete.png" class="delete-circle mr-2 rounded-circle team-profile-icon" alt="Responsive image">`
    pic.querySelector('.delete-circle').addEventListener('click', removeUser);
    managersList.push(parseInt(json));
    document.querySelector('.developers-pics').appendChild(pic);

    $('.team-profile-add-developers').val('');

    let results = document.querySelector('.results.developers');
    while (results.firstChild) {
      results.removeChild(results.firstChild);
    }

    inputFocusOut(document.querySelector('.team-profile-add-developers'));
  });
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

let globalProjectColor = document.querySelector(".title-line");

globalProjectColor.style.backgroundColor = "#" + colorToHex(globalProjectColor.getAttribute('data-color'));

function colorToHex(color) {
    let colors = {
        'Orange' : 'f77d13',
        'Yellow' : 'ffcc00',
        'Red' : 'e82020',
        'Green' : '2dcc71',
        'Lilac' : '9c58b6',
        'Sky' : '4894dd',
        'Brown' : 'c45e00',
        'Golden' : 'f39c13',
        'Bordeaux' : 'c92b1a',
        'Emerald' : '179f85',
        'Purple' : '7f14ad',
        'Blue' : '2880ba',
    };

    return colors[color];
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
