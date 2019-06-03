let sidebar = document.querySelector("#mySidenav");
let negSize = "-320px";
let settingsButton = document.querySelector("#sidebarCollapse");
let opaque = document.getElementById('opaque');
let globalProjectId = document.getElementById('title-box').getAttribute('data-id');
let submitButton = document.getElementById("submit-button");
let sideProjectTitle = document.querySelector(".pop-up-name");
let globalProjectColor = document.querySelector(".title-line");

colorPicker();

settingsButton.addEventListener('click', settingsButtonClicked);
settingsButton.addEventListener('click', getRequest);
opaque.addEventListener('click', closeSettings);
submitButton.addEventListener('click', putRequest);
sideProjectTitle.addEventListener('click', (event) => {
    event.preventDefault;
});
globalProjectColor.style.backgroundColor = "#" + colorToHex(globalProjectColor.getAttribute('data-color'));

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
}

function getRequestHandler() {
    let project = JSON.parse(this.responseText);
    let projectTitle = document.querySelector(".pop-up-name");
    projectTitle.innerHTML = `${project.project.name}`;
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
    let projectTitle = document.querySelector(".pop-up-name");
    let projectColor = document.querySelector(".title-line");
    if (this.status == 200) {
        let project = JSON.parse(this.responseText);
        projectTitle.innerHTML = project['name'];
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
    colorPicker.setAttribute('checked', true);
}

