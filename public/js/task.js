let taskButtons = document.querySelectorAll('.task-button');
let newTaskButtons = document.querySelectorAll('.add-project-button');
let globalProjectId = document.getElementById('title-box').getAttribute('data-id');

taskButtons.forEach(function (button) {
  button.addEventListener('click', generateTaskModal.bind(button, event));
});

newTaskButtons.forEach(function (button) {
  button.addEventListener('click', function (event) {
    event.preventDefault();
    addTaskClick(button);
  });
});

function generateTaskModal() {
  let id_task = this.getAttribute('data-id');

  let id_project = globalProjectId;
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

  checks.forEach(function (check) {
    check.remove();
  });
  if (checklistArray.length > 0) {
    let checklist = document.querySelector('#checklist');


    checklistArray.forEach(function (check) {
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


/**
 * Function that gets called when you press the "Create Task Button"
 * @param {*} button 
 */
function addTaskClick(button) {
  
  // Create the text input
  let newTaskInput = document.createElement("input");
  let taskList = button.getAttribute('data-list');
  newTaskInput.type = "text";
  newTaskInput.placeholder = "Task Name";
  newTaskInput.setAttribute("data-list", taskList);

  // Add event listener
  newTaskInput.addEventListener('focusout', removeInputBox);
  newTaskInput.addEventListener('change', addTaskAction.bind(newTaskInput, taskList)); //TODO: Add focus on create

  // Add newTaskInput to the correct task list
  let list = document.querySelector('div[data-list="' + taskList + '"]');
  list.after(newTaskInput);
  // Set focus on new input
  document.querySelector('div[data-list="' + taskList + '"] + input').focus();

  button.remove();
}


/**
 * Function that gets called after a change on the Add Task input box
 * @param {*} taskList 
 */
function addTaskAction(taskList) {

  let projectId = globalProjectId;
  let taskName = this.value;

  // remove the input box
  this.remove();

  // API call
  sendAjaxRequest('post', '/api/projects/' + projectId + '/tasks', { name: taskName, list_name: taskList }, addTaskReturn.bind(taskList));
}


/**
 * Function that gets called after the addTaskAction AjaxRequest
 */
function addTaskReturn(load) {
  let request = load.srcElement;
  let taskList = this;

  if (request.status == 201) {

    let task = JSON.parse(request.responseText);

    // On success, create a task button for the new task
    createTaskButton(task, taskList); 
  }
  else {
    console.log("PANIC! ERROR IN ADD TASK"); //TODO: Handle errors
  }

  createAddTaskButton(taskList);
}


/**
 * Function to create a "Task Button" in the correct list
 * @param {*} task 
 * @param {*} taskList 
 */
function createTaskButton(task, taskList) {

  // create the new "Task Button"
  let new_item = document.createElement('button');
  new_item.setAttribute('data-id', task.id_task);
  new_item.setAttribute('class', 'btn btn-primary task-sel task-button');
  new_item.setAttribute('data-toggle', 'modal');
  new_item.setAttribute('data-target', '#task-pop-up')
  new_item.innerHTML = task.name;

  // add event listener
  new_item.addEventListener('click', generateTaskModal.bind(new_item));

  // add to respective task list
  let list = document.querySelector('div[data-list="' + taskList + '"]');
  list.appendChild(new_item);
}


/**
 * Function to create a "Add New Task" button and insert in the correct list
 * @param {*} taskList 
 */
function createAddTaskButton(taskList){

  // create "Add Task" button
  let addTaskButton = document.createElement("a");
  addTaskButton.innerHTML = `Create New Task`;
  addTaskButton.setAttribute('type', 'button');
  addTaskButton.classList.add('add-project-button');
  addTaskButton.setAttribute('data-list', taskList);
  addTaskButton.addEventListener('click', function (event) {
    event.preventDefault();
    addTaskClick(addTaskButton);
  });

  // insert "Add Task" button
  let list = document.querySelector('div .add-button-' + taskList);
  list.appendChild(addTaskButton);
}

function removeInputBox(event){
  event.preventDefault();  // Does nothing?

  this.removeEventListener('change', addTaskAction); // Does nothing?

  if(this.value == ""){
    createAddTaskButton(this.getAttribute("data-list"));
  }

  this.remove();
}


/**
 * Switch for values of a Task's list 
 * @param {*} taskList 
 */
function taskListSwitch(taskList) {
  switch (taskList) {
    case "To Do":
      return 'to-do';
    case "In Progress":
      return 'in-progress';
    case "Pending":
      return 'pending';
    case "Done":
      return 'done';
    
    default:
      return 'to-do';
  }
}


