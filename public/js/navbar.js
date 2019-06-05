
let notification_button = document.querySelector('button.dropdown-toggle');

notification_button.addEventListener('click', clickNotificationAction);

$('.dropdown-menu').click(function(e) {
    e.stopPropagation();
});

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

    let notButton = document.createElement('a');
    notButton.classList.add('dropdown-item', 'col-sm-10');
    notButton.setAttribute('href', '#');
    


    if (notification.interactable) {

        notButton.innerHTML = "You were invited to Project " + projName;

        let notAccept = createAcceptButton();
        let notDeny = createDenyButton();

        notAccept.addEventListener('click', () => {console.log("Accept")});
        notDeny.addEventListener('click', () => {console.log("Deny")});


        notDiv.appendChild(notButton);
        notDiv.appendChild(notAccept);
        notDiv.appendChild(notDeny);
    }
    else {



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

