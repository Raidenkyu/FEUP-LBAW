/* Settings Window Animation */
let negSize = "-320px";
let opaque = document.getElementById('opaque');

/* Global Project Elements */
let globalProjectId = document.getElementById('title-box').getAttribute('data-id');
let globalProjectColor = document.querySelector(".title-line");

/* Settings Elements */
let sidebar = document.querySelector("#mySidenav");
let settingsButton = document.querySelector("#sidebarCollapse");
let settingsProjectTitle = document.querySelector(".pop-up-name");
let submitButton = document.getElementById("submit-button");

/* Permission Variable */
let isManager = document.getElementById('title-box').getAttribute('data-isManager');

if(isManager) {
    /* Update current color on Settings Tab*/
    colorPicker();

    /* Settings' Event Listeners */
    settingsButton.addEventListener('click', getRequest);
    submitButton.addEventListener('click', putRequest);
    settingsProjectTitle.addEventListener('click', (event) => {
        event.preventDefault;
    });
} 

/* Load Project Color */
globalProjectColor.style.backgroundColor = "#" + colorToHex(globalProjectColor.getAttribute('data-color'));

/* Settings' Event Listeners */
settingsButton.addEventListener('click', settingsButtonClicked);
opaque.addEventListener('click', closeSettings);

function settingsButtonClicked(project) {
    if (sidebar.style.right == negSize || sidebar.style.right == "") {
        sidebar.style.right = "0";
        opaque.style.display = 'block';
    } else {
        sidebar.style.right = negSize;
        opaque.style.display = 'none';
    }
}

function getRequest(event) {
    sendAjaxRequest('get', '/api/projects/' + globalProjectId + '/settings', {}, getRequestHandler);
    //sendAjaxRequest('get', '/api/projects/' + globalProjectId + '/members', {}, getMembersHandler);
}

function getRequestHandler() {
    let project = JSON.parse(this.responseText);
    let projectTitle = document.querySelector(".pop-up-name");
    projectTitle.innerHTML = `${project.project.name}`;
}

function getMembersHandler() {
    let devs = JSON.parse(this.responseText)['devs'];
    let managers = JSON.parse(this.responseText)['managers'];
    
}

function putRequest(event) {
    event.preventDefault();
    let projectTitle = document.querySelector(".pop-up-name").value;
    let projectColor = document.querySelector(".color-picker div :checked").value;

    sendAjaxRequest('put', '/api/projects/' + globalProjectId + '/settings', {
        name: projectTitle,
        color: projectColor
    }, putRequestHandler);
}

function putRequestHandler() {
    let projectColor = document.querySelector(".title-line");
    let globalProjectName = document.getElementById("title-box");
    if (this.status == 200) {
        let project = JSON.parse(this.responseText);
        globalProjectName.innerHTML = project['name'];
        projectColor.setAttribute('style', 'background-color: #' + colorToHex(project['color']));
    }
}

function closeSettings(event) {
    if (opaque.style.display == 'block') {
        sidebar.style.right = negSize;
        opaque.style.display = 'none';
    }
}

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
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

function colorToIndex(color) {
    let colors = {
        'Orange' : 'color-1',
        'Yellow' : 'color-2',
        'Red' : 'color-3',
        'Green' : 'color-4',
        'Lilac' : 'color-5',
        'Sky' : 'color-6',
        'Brown' : 'color-7',
        'Golden' : 'color-8',
        'Bordeaux' : 'color-9',
        'Emerald' : 'color-10',
        'Purple' : 'color-11',
        'Blue' : 'color-12',
    };

    return colors[color];
}

function colorPicker() {
    let color = globalProjectColor.getAttribute('data-color');
    let colorPicker = document.querySelector('.color-picker div input[value="' + colorToIndex(color) + '"]');
    colorPicker.setAttribute('checked', '');
}

