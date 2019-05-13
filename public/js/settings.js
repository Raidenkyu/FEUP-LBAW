let sidebar = document.querySelector("#mySidenav");
let negSize = "-320px";
let settingsButton = document.querySelector("#sidebarCollapse");
let opaque = document.getElementById('opaque');
let projectTitle = document.querySelector(".pop-up-name");


settingsButton.addEventListener('click', settingsButtonClicked);
opaque.addEventListener('click', closeSettings);

function settingsButtonClicked(project) {
    if (sidebar.style.right == negSize || sidebar.style.right == "") {
        sidebar.style.right = "0";
        opaque.style.display = 'block';
        //displayProjectName(project);
    }
    else {
        sidebar.style.right = negSize;
        opaque.style.display = 'none';
    }

}

function displayProjectName($project) {
    projectTitle.innerHTML = 'teste';
}

function closeSettings(event) {
    if (opaque.style.display == 'block') {
        sidebar.style.right = negSize;
        opaque.style.display = 'none';
    }
}



