let banButtons = document.querySelectorAll('.ban[data-ban="false"]');
let unbanButtons = document.querySelectorAll('.ban[data-ban="true"]');

let deleteButtons = document.querySelectorAll('.ban[data-delete="false"]');
let restoreButtons = document.querySelectorAll('.ban[data-delete="true"]');

banButtons.forEach((button)=>{
    button.addEventListener('click',banUser);
})

unbanButtons.forEach((button)=>{
    button.addEventListener('click',unbanUser);
})

deleteButtons.forEach((button)=>{
    button.addEventListener('click',deleteProject);
})

restoreButtons.forEach((button)=>{
    
    button.addEventListener('click',restoreProject);
})

function banUser(){
    let id = this.getAttribute('data-id');
    sendAjaxRequest('put', '/api/projects/' + id + '/ban', {}, playerBanned.bind(this));
}

function unbanUser(){
    let id = this.getAttribute('data-id');
    sendAjaxRequest('put', '/api/projects/' + id + '/unban', {}, playerUnbanned.bind(this));
}

function deleteProject(){
    let id = this.getAttribute('data-id');
    sendAjaxRequest('put', '/api/projects/' + id + '/delete', {}, projectDeleted.bind(this));
}

function restoreProject(){
    let id = this.getAttribute('data-id');
    sendAjaxRequest('put', '/api/projects/' + id + '/restore', {}, projectRestored.bind(this));
}

function playerBanned(load){
    let request = load.srcElement;
    if(request.status == 200){
        let user = JSON.parse(request.responseText);
        let img = document.createElement('img');
        img.setAttribute('src','/icons/done.svg');
        img.setAttribute('data-id',this.getAttribute('data-id'));
        img.setAttribute('data-ban',user['banned']);
        img.setAttribute('alt',"Ban Icon");
        img.classList.add('ban');
        img.addEventListener('click',unbanUser.bind(img));
        this.replaceWith(img);

    }

}

function playerUnbanned(load){
    let request = load.srcElement;
    if(request.status == 200){
        let user = JSON.parse(request.responseText);
        let img = document.createElement('img');
        img.setAttribute('src','/icons/ban.svg');
        img.setAttribute('data-id',this.getAttribute('data-id'));
        img.setAttribute('data-ban',user['banned']);
        img.setAttribute('alt',"Ban Icon");
        img.classList.add('ban');
        img.addEventListener('click',banUser.bind(img));
        this.replaceWith(img);
    }

}

function projectDeleted(load){
    let request = load.srcElement;
    if(request.status == 200){
        let user = JSON.parse(request.responseText);
        let img = document.createElement('img');
        img.setAttribute('src','/icons/done.svg');
        img.setAttribute('data-id',this.getAttribute('data-id'));
        img.setAttribute('data-delete',user['deleted']);
        img.setAttribute('alt',"Ban Icon");
        img.classList.add('ban');
        img.addEventListener('click',restoreProject.bind(img));
        this.replaceWith(img);
    }

}

function projectRestored(load){
    let request = load.srcElement;
    if(request.status == 200){
        let user = JSON.parse(request.responseText);
        let img = document.createElement('img');
        img.setAttribute('src','/icons/ban.svg');
        img.setAttribute('data-id',this.getAttribute('data-id'));
        img.setAttribute('data-delete',user['deleted']);
        img.setAttribute('alt',"Ban Icon");
        img.classList.add('ban');
        img.addEventListener('click',deleteProject.bind(img));
        this.replaceWith(img);
    }

}