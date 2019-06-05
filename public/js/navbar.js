
let notification_button = document.querySelector('button.dropdown-toggle');

notification_button.addEventListener('click', clickNotificationAction);

function clickNotificationAction(){
  
    console.log(this);

    // API call
    sendAjaxRequest('get', '/api/notifications', {}, clickNotificationReturn);

}

function clickNotificationReturn(){

    console.log(this.status);

    


}
