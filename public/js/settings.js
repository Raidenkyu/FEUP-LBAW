let sidebar = document.querySelector("#mySidenav");
let negSize = "-320px";
let settingsButton = document.querySelector("#sidebarCollapse");
let opaque = document.getElementById('opaque');
let projectTitle = document.querySelector(".pop-up-name");


settingsButton.addEventListener('click', settingsButtonClicked);
settingsButton.addEventListener('click', sendSettingsRequest);
opaque.addEventListener('click', closeSettings);


function settingsButtonClicked(project) {
    if (sidebar.style.right == negSize || sidebar.style.right == "") {
        sidebar.style.right = "0";
        opaque.style.display = 'block';
    }
    else {
        sidebar.style.right = negSize;
        opaque.style.display = 'none';
    }

}

function sendSettingsRequest(event) {  
    let id = document.getElementById('title-box').getAttribute('data-id');
    sendAjaxRequest('get', '/api/projects/' + id, {}, settingsRequestHandler);
}

function settingsRequestHandler() {
    let project = JSON.parse(this.responseText);
    projectTitle.innerHTML = `${project.project.name}`;
  }

function closeSettings(event) {
    if (opaque.style.display == 'block') {
        sidebar.style.right = negSize;
        opaque.style.display = 'none';
    }
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
    //request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
  }



