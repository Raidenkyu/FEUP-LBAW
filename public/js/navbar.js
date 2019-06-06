

startUp();


function startUp(){

    let isLoggedDiv = document.querySelector('#isLogged');

    console.log(isLoggedDiv.getAttribute('data-isLogged'));

    if(isLoggedDiv.getAttribute('data-isLogged') == true){
        let notification_button = document.querySelector('button.dropdown-toggle');

        notification_button.addEventListener('click', clickNotificationAction);
        $('.dropdown-menu').click(function(e) {
            e.stopPropagation();
        });
    }


}


function clickNotificationAction() {

    console.log(this);

    // API call
    sendAjaxRequest('get', '/api/notifications', {}, clickNotificationReturn);

}

function clickNotificationReturn() {

    console.log(this.status);

    // Get and clear div
    let notifyFolder = document.querySelector('div.dropdown-menu');
    while (notifyFolder.firstChild) {
        notifyFolder.removeChild(notifyFolder.firstChild);
    }

    if (this.status == 200) {

        let notifications = (JSON.parse(this.responseText))['notifications'];
        let projNames = (JSON.parse(this.responseText))['names'];
        //console.log(notifications);
        //console.log(projNames)
        
        for (i in notifications) {
            console.log(notifications[i]);
            notifyFolder.appendChild(createNotification(notifications[i], projNames[i]));
        }

    }
    else {
        console.log("TODO: Handle errors")
    }



}

function createNotification(notification, projName) {

    //<div class="notify-box"><a class="dropdown-item" href="#">Link 1</a></div>

    let notDiv = document.createElement('div');
    notDiv.classList.add('notify-box', 'row', 'mx-0');
    notDiv.setAttribute('style', 'width:100%;');
    notDiv.setAttribute('data-id_notify', notification.id_notification);

    let notButton = document.createElement('a');
    notButton.classList.add('dropdown-item', 'col-sm-10');
    

    // If "is interactable"
    if (notification.interactable) {

        notButton.innerHTML = "You were invited to Project '" + projName + "'";

        let notAccept = createAcceptButton();
        let notDeny = createDenyButton();

        notAccept.addEventListener('click', readNotificationAction.bind(notDiv));
        notDeny.addEventListener('click', refuseInviteAction.bind(notDiv));


        notDiv.appendChild(notButton);
        notDiv.appendChild(notAccept);
        notDiv.appendChild(notDeny);
    }
    // If "not interactable"
    else {
        if(notification.action == "checkPending"){

            notButton.setAttribute('href', '/projects/' + notification.id_project);
            notButton.innerHTML = "A task needs approval in Project '" + projName + "'";
            
            let notAccept = createAcceptButton();
            notAccept.addEventListener('click', readNotificationAction.bind(notDiv));

            notDiv.appendChild(notButton);
            notDiv.appendChild(notAccept);
        }
        else if(notification.action == "beenRemoved"){
            
            notButton.innerHTML = "You were removed from Project '" + projName + "'";
            
            let notAccept = createAcceptButton();
            notAccept.addEventListener('click', readNotificationAction.bind(notDiv));

            notDiv.appendChild(notButton);
            notDiv.appendChild(notAccept);
        }
        else{
            // TODO: Handle de erro na base de dados?
        }
    }

    return notDiv;
}

function createAcceptButton() {

    let notAccept = document.createElement('a');
    notAccept.classList.add('col', 'px-0', 'col-sm-1');

    let notAcceptImg = document.createElement('img');
    notAcceptImg.src = "/icons/check.svg";
    notAcceptImg.classList.add('img-fluid');
    notAcceptImg.alt = "Accept Notification";
    notAccept.appendChild(notAcceptImg);

    return notAccept;
}

function createDenyButton() {

    let notDeny = document.createElement('a');
    notDeny.classList.add('col', 'px-0', 'col-sm-1');

    let notDenyImg = document.createElement('img');
    notDenyImg.src = "/icons/deny.svg";
    notDenyImg.classList.add('img-fluid');
    notDenyImg.alt = "Deny Notification";
    notDeny.appendChild(notDenyImg);

    return notDeny;
}


function readNotificationAction(){
    
    //get notification id
    let id_notify = this.getAttribute('data-id_notify');

    // API call
    sendAjaxRequest('delete', '/api/notifications/' + id_notify, {}, readNotificationReturn);

    //remove from page
    this.remove();
}

function readNotificationReturn(){
    
    if(this.status == 200){
        let notCount = JSON.parse(this.responseText);
        if(notCount == 0){
            changeNotificationIcon(false);
        }
    }
    else{
        console.log("TODO: Handle errors")
    }

}

function refuseInviteAction(){

    //get notification id
    let id_notify = this.getAttribute('data-id_notify');

    // API call
    sendAjaxRequest('post', '/api/notifications/' + id_notify + '/refuse', {}, refuseInviteReturn);

    //remove from page
    this.remove();
}

function refuseInviteReturn(){
    
    if(this.status == 200){
        // ok
    }
    else{
        console.log("TODO: Handle errors");
        console.log("Status: " + status);
    }

}


function changeNotificationIcon(newVal){

    //remove old icon
    let oldIconButton = document.querySelector('#notification-icon');

    while(oldIconButton.firstChild){
        oldIconButton.removeChild(oldIconButton.firstChild)
    }

    //add new icon
    let newIcon = document.createElement('img');
    if(newVal){
        newIcon.src = "/icons/ban.svg";
        newIcon.alt = "There are notifications";
    }
    else{
        newIcon.src = "/icons/notification_center.svg";
        newIcon.alt = "No notifications";
    }
    
    newIcon.classList.add('mx-1');
    newIcon.setAttribute('style','width:45px');
    
    oldIconButton.appendChild(newIcon);
}



function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data)
        .map(function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
        })
        .join('&');
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader(
        'X-CSRF-TOKEN',
        document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}

