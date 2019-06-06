

startUp();

/**
 * Start up function that runs as the page loads
 */
function startUp() {

    // Div that contains info that tells if a user is logged in or not
    let isLoggedDiv = document.querySelector('#isLogged');

    // if the user is logged in, add logic for notification button
    if (isLoggedDiv.getAttribute('data-isLogged') == 'true') {
        let notification_button = document.querySelector('button.dropdown-toggle');

        notification_button.addEventListener('click', clickNotificationAction);
        $('.dropdown-menu').click(function (e) {
            e.stopPropagation();
        });
    }
}

/**
 *  Action that gets called after the notification button is clicked
 */
function clickNotificationAction() {

    //console.log(this);

    // API call
    sendAjaxRequest('get', '/api/notifications', {}, clickNotificationReturn);
}

/**
 * Function that gets called after the "clickNotificationAction" AJAX call returns
 */
function clickNotificationReturn() {

    // Get and clear div
    let notifyFolder = document.querySelector('div.dropdown-menu');
    while (notifyFolder.firstChild) {
        notifyFolder.removeChild(notifyFolder.firstChild);
    }

    if (this.status == 200) {

        let notifications = (JSON.parse(this.responseText))['notifications'];
        let projNames = (JSON.parse(this.responseText))['names'];

        // if there are no notifications
        if (notifications.length == 0) {
            notifyFolder.appendChild(createEmptyNotifications());
        }
        else {
            // create all the notifications
            for (i in notifications) {
                //console.log(notifications[i]);
                notifyFolder.appendChild(createNotification(notifications[i], projNames[i]));
            }
        }

    }
    else {
        console.log("TODO: Handle errors")
    }

}

/**
 * Function to create a "no notification" element
 */
function createEmptyNotifications(){
    
    let notDiv = document.createElement('div');
    notDiv.classList.add('notify-box', 'row', 'mx-0');
    notDiv.setAttribute('style', 'width:100%;');

    let notButton = document.createElement('a');
    notButton.classList.add('dropdown-item', 'col-sm-10');
    notButton.innerHTML = "No new notifications";
    notDiv.appendChild(notButton);

    return notDiv;
}


/**
 * Function to create a notification element
 * @param {*} notification 
 * @param {*} projName 
 */
function createNotification(notification, projName) {

    // Example notification
    //<div class="notify-box"><a class="dropdown-item" href="#">Link 1</a></div>

    let notDiv = document.createElement('div');
    notDiv.classList.add('notify-box', 'row', 'mx-0');
    notDiv.setAttribute('style', 'width:100%;');
    notDiv.setAttribute('data-id_notify', notification.id_notification);

    let notButton = document.createElement('a');
    notButton.classList.add('dropdown-item', 'col-sm-10');

    // If "is interactable"
    if (notification.interactable) {

        // Add correct text
        notButton.innerHTML = "You were invited to Project '" + projName + "'";

        // Create appropriate buttons
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
        if (notification.action == "checkPending") {

            // Add correct text and anchor
            notButton.setAttribute('href', '/projects/' + notification.id_project);
            notButton.innerHTML = "A task needs approval in Project '" + projName + "'";

            // Create appropriate buttons
            let notAccept = createAcceptButton();
            notAccept.addEventListener('click', readNotificationAction.bind(notDiv));
            notDiv.appendChild(notButton);
            notDiv.appendChild(notAccept);
        }
        else if (notification.action == "beenRemoved") {

            // Add correct text
            notButton.innerHTML = "You were removed from Project '" + projName + "'";

            // Create appropriate buttons
            let notAccept = createAcceptButton();
            notAccept.addEventListener('click', readNotificationAction.bind(notDiv));
            notDiv.appendChild(notButton);
            notDiv.appendChild(notAccept);
        }
        else {
            // TODO: Handle de erro na base de dados?
        }
    }

    return notDiv;
}

/**
 * Function to create a "Accept notification" button
 */
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

/**
 * Function to create a "Refuse notification" button
 */
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

/**
 * Action that gets called after a "Read notification" button is pressed
 */
function readNotificationAction() {

    //get notification id
    let id_notify = this.getAttribute('data-id_notify');

    // API call
    sendAjaxRequest('delete', '/api/notifications/' + id_notify, {}, readNotificationReturn);

    //remove from page
    this.remove();
}

/**
 * Function that gets called after the "readNotificationAction" AJAX call returns
 */
function readNotificationReturn() {

    if (this.status == 200) {
        // Update the icon if necessary
        let notCount = JSON.parse(this.responseText);
        if (notCount == 0) {
            changeNotificationIcon(false);
            let notifyFolder = document.querySelector('div.dropdown-menu');
            notifyFolder.appendChild(createEmptyNotifications());
        }
    }
    else {
        console.log("TODO: Handle errors")
    }

}

/**
 * Action that gets called after a "Refuse invite" button is pressed
 */
function refuseInviteAction() {

    //get notification id
    let id_notify = this.getAttribute('data-id_notify');

    // API call
    sendAjaxRequest('post', '/api/notifications/' + id_notify + '/refuse', {}, refuseInviteReturn);

    //remove from page
    this.remove();
}

/**
 * Function that gets called after the "refuseInviteAction" AJAX call returns
 */
function refuseInviteReturn() {

    if (this.status == 200) {
        // Update the icon if necessary

    }
    else {
        console.log("TODO: Handle errors");
        console.log("Status: " + status);
    }

}

/**
 * Function that changes the notification icon according to the argument received (true => change to "Has notifications"; false => change to "No notifications")
 * @param {*} newVal 
 */
function changeNotificationIcon(newVal) {

    //remove old icon
    let oldIconButton = document.querySelector('#notification-icon');

    while (oldIconButton.firstChild) {
        oldIconButton.removeChild(oldIconButton.firstChild)
    }

    //add new icon
    let newIcon = document.createElement('img');
    if (newVal) {
        newIcon.src = "/icons/ban.svg";
        newIcon.alt = "There are notifications";
    }
    else {
        newIcon.src = "/icons/notification_center.svg";
        newIcon.alt = "No notifications";
    }

    newIcon.classList.add('mx-1');
    newIcon.setAttribute('style', 'width:45px');

    oldIconButton.appendChild(newIcon);
}



// AJAX FUNCTIONS

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

