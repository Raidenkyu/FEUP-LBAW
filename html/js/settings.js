let sidebar = document.querySelector("#mySidenav");

function settingsButtonClicked() {
    if(sidebar.style.width == "250px"){
        sidebar.style.width = "0";
    }
    else{
        
        sidebar.style.width = "250px";
    }
  }
  
  function closeNav() {
    sidebar.style.width = "0";
  }