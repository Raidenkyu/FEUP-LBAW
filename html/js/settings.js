let sidebar = document.querySelector("#mySidenav");
let size = "320px";

function settingsButtonClicked() {
    if(sidebar.style.width == size){
        sidebar.style.width = "0";
    }
    else{
        
        sidebar.style.width = size;
    }
  }
  
  function closeNav() {
    sidebar.style.width = "0";
  }