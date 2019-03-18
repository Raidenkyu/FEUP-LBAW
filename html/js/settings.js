let sidebar = document.querySelector("#mySidenav");
let negSize = "-320px";
let settingsButton = document.querySelector("#sidebarCollapse");
let opaque = document.getElementById('opaque');


settingsButton.addEventListener('click', settingsButtonClicked);
opaque.addEventListener('click', closeSettings);

function settingsButtonClicked() {
    if (sidebar.style.right == negSize || sidebar.style.right == "") {
        sidebar.style.right = "0";
        opaque.style.display = 'block';
    }
    else {
        sidebar.style.right = negSize;
        opaque.style.display = 'none';
    }

}

function closeSettings(event) {
    if (opaque.style.display == 'block') {
        sidebar.style.right = negSize;
        opaque.style.display = 'none';
    }
}



