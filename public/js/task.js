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

  // Add event listener
  newTaskInput.addEventListener('change', addTaskAction.bind(newTaskInput, taskList)); //TODO: Add focus on create
  newTaskInput.addEventListener('focusout', () => { console.log('TODO: Replace with create button!'); });

  // Add newTaskInput to the correct task list
  let list = document.querySelector('div[data-list="' + taskList + '"]');
  list.after(newTaskInput);
  button.remove();
}

/**
 * Function that gets called after a change on the Add Task input box
 * @param {*} taskList 
 */
function addTaskAction(taskList) {

  let projectId = globalProjectId;
  let taskName = this.value;

  console.log("Task name: " + taskName);
  console.log("Task list: " + taskList);

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
  console.log("THIS:");
  console.log(request);
  console.log("Task list: " + taskList);

  console.log("Status: " + request.status);

  if (request.status == 201) {

    let task = JSON.parse(request.responseText);

    console.log(request.responseText);

    //console.log(task);
    console.log(task.list_name); //TODO: Ver porque é que não gera o list_name

    createTask(task, taskList); 

  }
  else {
    console.log("PANIC! ERROR IN ADD TASK");
  }

  createTaskButton = document.createElement("a");
  createTaskButton.innerHTML = `Create New Task`;
  createTaskButton.setAttribute('type', 'button');
  createTaskButton.classList.add('add-project-button');
  createTaskButton.setAttribute('data-list', taskList);
  createTaskButton.addEventListener('click', function (event) {
    event.preventDefault();
    addTaskClick(createTaskButton);
  });

  // create "add task" button
  let list = document.querySelector('div .add-button-' + taskList);
  list.appendChild(createTaskButton);

  console.log("Added");
}


function createTask(task, taskList) {

  // create the new task
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


