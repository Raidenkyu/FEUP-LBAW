let taskButtons = document.querySelectorAll('.task-button');
let newTaskButtons = document.querySelectorAll('.add-project-button');

taskButtons.forEach(function(button) {
  button.addEventListener('click', generateTaskModal.bind(button, event));
});

newTaskButtons.forEach(function(button){
  button.addEventListener('click', function(event){
    event.preventDefault();
    addProjButtonToInput(button)
  });
});

function generateTaskModal() {
  let id_task = this.getAttribute('data-id');
  // TODO: get project id
  let id_project = 1;
  let url = '/api/projects/' + id_project + '/tasks/' + id_task;
  sendAjaxRequest('GET', url, {}, taskFetch);
}



function taskFetch() {
  let task = (JSON.parse(this.responseText))['data'];
  console.log(task);

  let taskTitle = document.querySelector('#taskTitle');
  taskTitle.innerHTML = task['name'];

  let descriptionText = task['description'];
  if (descriptionText != null) {
    let description = document.querySelector('#description-text');
    description.innerHTML = descriptionText;
  }

  let date = task['due_date'];
  if (date != null) {
    let due_date = document.querySelector('#due-date');
    due_date.innerHTML = date;
  }

  let checklistArray = task['checklist'];
  let checks = document.querySelectorAll('.check');

  checks.forEach(function(check) {
    check.remove();
  });
  if (checklistArray.length > 0) {
    let checklist = document.querySelector('#checklist');


    checklistArray.forEach(function(check) {
      let newCheck = document.createElement('div');
      newCheck.classList.add('row');
      newCheck.classList.add('check');
      let imgDiv = document.createElement('div');
      let img = document.createElement('img');
      img.setAttribute('src', '/icons/check.svg');
      img.classList.add('task-check-icon');
      img.setAttribute('alt', 'User Photo');
      imgDiv.appendChild(img);
      let checkDiv = document.createElement('div');
      checkDiv.classList.add('res-text');
      checkDiv.classList.add('tasks-text');
      let spanCheck = document.createElement('span');
      spanCheck.innerHTML = check;
      checkDiv.appendChild(spanCheck);
      newCheck.appendChild(imgDiv);
      newCheck.appendChild(checkDiv);
      checklist.appendChild(newCheck);
    })
  }

  issueText = task['issue'];
  let issue = document.querySelector('#issue');
  if (issueText != null) {
    issue.innerHTML = '#' + issueText;
  } else {
    issue.innerHTML = 'None';
  }
}


//////////////////////////////////////// JUAN ///////////////////////////////////////







//////////////////////////////////////// NANDO ///////////////////////////////////////

function addProjButtonToInput(button) {
  //console.log("Clicked");
  let newTask = document.createElement("input");
  let taskList = button.getAttribute('data-list');
  newTask.type = "text";
  
  newTask.placeholder = "Task Name";
  newTask.addEventListener('change', addTaskAction.bind(newTask, taskList));

  let list = document.querySelector('div[data-list="' + taskList + '"]');

  list.after(newTask);
  button.remove();
}

function addTaskAction(taskList){
  //console.log("Adding to " + taskList);

  let id = 1; //TODO: Get id
  let taskName = this.value;

  console.log("Task name: " + taskName);
  console.log("Task list: " + taskList);

  this.remove();

  sendAjaxRequest('post', '/api/projects/' + id + '/tasks', {name: taskName, list_name: taskList},addTaskReturn);

}


function addTaskReturn(){

  if(this.status == 201){

    let task = JSON.parse(this.responseText);

    // Create the new item
    //let new_task = createTask(task);
  
    /*
    // Insert the new item
    let card =
        document.querySelector('article.card[data-id="' + task.card_id + '"]');
    let form = card.querySelector('form.new_item');
    form.previousElementSibling.append(new_item);
  
    // Reset the new task form
    form.querySelector('[type=text]').value = '';
    */

    console.log(this.responseText);

    console.log(task);
    console.log(task.list_name); //TODO: Ver porque é que não gera o list_name

  }
  else{
    console.log("PANIC! ERROR IN ADD TASK");
  }

  console.log("Status: " + this.status);


  createTaskButton = document.createElement("a");
  createTaskButton.outerHTML = `<a type="button" class="add-project-button" data-list="${taskList}"></a>`
  createTaskButton.innerHTML = `Create New Task`;
  createTaskButton.setAttribute('type','button');
  createTaskButton.setAttribute('class','add-project-button');
  createTaskButton.setAttribute('data-list',taskList);
  createTaskButton.addEventListener('click', function(event){
    event.preventDefault();
    addProjButtonToInput(createTaskButton);
  });

  let list = document.querySelector('div[data-list="' + taskList + '"]');
  list.after(createTaskButton);

  console.log("Added");

}


function createTask(task) {

  //<button data-id='{{$task->id_task}}' type="button" class="btn btn-primary task-sel task-button" data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>

  let new_item = document.createElement('button');
  new_item.setAttribute('data-id', task.id_task);
  new_item.classList.add('item');
  
  new_item.innerHTML = `
  <label>
    <input type="checkbox"> <span>${
      item.description}</span><a href="#" class="delete">&#10761;</a>
  </label>
  `;

  new_item.querySelector('input').addEventListener(
      'change', sendItemUpdateRequest);
  new_item.querySelector('a.delete')
      .addEventListener('click', sendDeleteItemRequest);

  return new_item;
}



