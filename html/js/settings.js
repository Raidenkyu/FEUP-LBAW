let sidebar = document.querySelector("#mySidenav");
let negSize = "-320px";

function settingsButtonClicked() {
    if(sidebar.style.right == negSize || sidebar.style.right == ""){
        sidebar.style.right = "0";
        document.getElementById('opaque').style.display='block';
    }
    else{
        sidebar.style.right = negSize;
        document.getElementById('opaque').style.display='none';
    }
    
  }



