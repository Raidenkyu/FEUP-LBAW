 taskButtons = document.querySelectorAll('.task-button');
let newTaskButtons = document.querySelectorAll('.add-project-button');
//let globalProjectId = document.getElementById('title-box').getAttribute('data-id');

taskButtons.forEach(function(button) {
  button.addEventListener('click', generateTaskModal.bind(button, event));
});

newTaskButtons.forEach(function(button) {
  button.addEventListener('click', function(event) {
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
  taskTitle.setAttribute('value', task['name']);
  taskTitle.setAttribute('data-id', task['id']);

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
      spanCheck.setAttribute('class', 'check-test');
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
    issue.innerHTML = issueText;
  } else {
    issue.innerHTML = 'None';
  }



  // == Task List Actions == //

  // Get and clear div
  let taskListActionDiv = document.querySelector('div.task-list-action');
  while (taskListActionDiv.firstChild) {
    taskListActionDiv.removeChild(taskListActionDiv.firstChild);
  }

  // Create buttons
  let taskUpgradeButton = newChangeTaskListButton();
  taskUpgradeButton.setAttribute('id', 'task-list-upgrade');
  taskUpgradeButton.addEventListener(
      'click', upgradeTaskAction.bind(task['id_proj'], task['id']));

  let taskDowngradeButton = newChangeTaskListButton();
  taskDowngradeButton.setAttribute("id", "task-list-downgrade");
  taskDowngradeButton.addEventListener("click", downgradeTaskAction.bind(task['id_proj'], task['id']));

  // console.log(task);
  switch (task['list_name']) {
    // just has an "upgrade" button
    case 'To Do':
      taskUpgradeButton.innerHTML = 'Move to "In Progress"';
      taskListActionDiv.appendChild(taskUpgradeButton);
      break;

    // has an "upgrade" and "downgrade" button
    case 'In Progress':
      taskUpgradeButton.innerHTML = 'Move to "Pending Approval"';
      taskListActionDiv.appendChild(taskUpgradeButton);
      taskDowngradeButton.innerHTML = 'Move to "To Do"';
      taskListActionDiv.appendChild(taskDowngradeButton);
      break;

    // has an "upgrade" and "downgrade" button (TODO: permission of upgrade)
    case 'Pending Approval':
      taskUpgradeButton.innerHTML = 'Move to "Done"';
      taskListActionDiv.appendChild(taskUpgradeButton);
      taskDowngradeButton.innerHTML = 'Move to "In Progress"';
      taskListActionDiv.appendChild(taskDowngradeButton);
      break;

    // just has an "downgrade" button (TODO: Maybe add a second downgrade to In
    // Progress?)
    case 'Done':
      taskDowngradeButton.innerHTML = 'Move to "Pending Approval"';
      taskListActionDiv.appendChild(taskDowngradeButton);
      break;

    default:
      console.log('TODO: Handle Errors');
      break;
  }
}


//////////////////////////////////////// JUAN /////////////////////////////////////////////

let closeTaskButton = document.querySelector('#close-task-button');

closeTaskButton.addEventListener('click', saveChanges);

function saveChanges() {
  let taskTitle = document.querySelector('#taskTitle');
  let description = document.querySelector('#description-text');
  let due_date = document.querySelector('#due-date');
  let checks = document.querySelectorAll('.check-test');
  let issue = document.querySelector('#issue');
  let tasklist = [];
  checks.forEach(function(check) {
    tasklist.push(check.innerHTML);
  });

  let projectId = globalProjectId;
  let taskId = taskTitle.getAttribute('data-id');

  // API call
  sendAjaxRequest(
      'put', '/api/projects/' + projectId + '/tasks/' + taskId, {
        name: taskTitle.value,
        description: description.innerHTML,
        due_date: due_date.innerHTML,
        tasklist: tasklist,
        issue: issue.innerHTML
      },
      saveChangesAnswer);
}


function saveChangesAnswer() {
  console.log(this.status);
  if (this.status == 200) {
    let task = JSON.parse(this.responseText);
    let taskId = task['id_task'];
    let taskButton = document.querySelector('button[data-id="' + taskId + '"]');
    taskButton.innerHTML = task['name'];
    console.log(task);
  }
  else{
    console.log(this.responseText);
  }
}



//////////////////////////////////////// NANDO //////////////////////////////////////////


/**
 * Function that gets called when you press the "Create Task Button"
 * @param {*} button
 */
function addTaskClick(button) {
  // Create the text input
  let newTaskInput = document.createElement('input');
  let taskList = button.getAttribute('data-list');
  newTaskInput.type = 'text';
  newTaskInput.placeholder = 'Task Name';
  newTaskInput.setAttribute('data-list', taskList);

  // Add event listener
  newTaskInput.addEventListener('focusout', removeInputBox);
  newTaskInput.addEventListener(
      'change',
      addTaskAction.bind(newTaskInput, taskList));  // TODO: Add focus on create

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
  sendAjaxRequest(
      'post', '/api/projects/' + projectId + '/tasks',
      {name: taskName, list_name: taskList}, addTaskReturn.bind(taskList));
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
  } else {
    console.log('PANIC! ERROR IN ADD TASK');  // TODO: Handle errors
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
 * Function to erase a "Task Button" in the correct list
 * @param {*} task
 */
function eraseTaskButton(task, taskList) {
  let item = document.querySelector('button[data-id="' + task.id_task + '"]');
  item.remove();
}


/**
 * Function to create a "Add New Task" button and insert in the correct list
 * @param {*} taskList
 */
function createAddTaskButton(taskList) {
  // create "Add Task" button
  let addTaskButton = document.createElement('a');
  addTaskButton.innerHTML = `Create New Task`;
  addTaskButton.setAttribute('type', 'button');
  addTaskButton.classList.add('add-project-button');
  addTaskButton.setAttribute('data-list', taskList);
  addTaskButton.addEventListener('click', function(event) {
    event.preventDefault();
    addTaskClick(addTaskButton);
  });

  // insert "Add Task" button
  let list = document.querySelector('div .add-button-' + taskList);
  list.appendChild(addTaskButton);
}


/**
 * Function to remove a "New Task" input text area
 * @param {*} event
 */
function removeInputBox(event) {
  event.preventDefault();  // Does nothing?

  this.removeEventListener('change', addTaskAction);  // Does nothing?

  if (this.value == '') {
    createAddTaskButton(this.getAttribute('data-list'));
  }

  this.remove();
}


/**
 * Switch for values of a Task's list
 * @param {*} taskList
 */
function taskListSwitch(taskList) {
  switch (taskList) {
    case 'To Do':
      return 'to-do';
    case 'In Progress':
      return 'in-progress';
    case 'Pending Approval':
      return 'pending';
    case 'Done':
      return 'done';

    default:
      return 'to-do';
  }
}


function newChangeTaskListButton() {
  // create the new "Change Task List Button"
  let new_item = document.createElement('button');
  new_item.type = 'button';
  new_item.classList.add('btn', 'btn-primary', 'task-edit-button', 'res-text');
  new_item.setAttribute('data-dismiss', 'modal');

  return new_item;
}


/**
 * Action that gets called after an upgrade button is pressed
 * @param {*} taskId
 */
function upgradeTaskAction(taskId) {
  let projectId = this;

  // API Call
  sendAjaxRequest('put', '/api/projects/' + projectId + '/tasks/' + taskId + '/listName', { action: "upgrade" }, changeTaskListReturn);
}

/**
 * Action that gets called after an downgrade button is pressed
 * @param {*} taskId
 */
function downgradeTaskAction(taskId) {
  let projectId = this;

  // API Call
  sendAjaxRequest(
      'put', '/api/projects/' + projectId + '/tasks/' + taskId + '/listName',
      {action: 'downgrade'}, changeTaskListReturn);
}

/**
 * Function to change the pages without reload
 */
function changeTaskListReturn() {
  if (this.status == 200) {
    let task = (JSON.parse(this.responseText))['task'];
    let old_list = (JSON.parse(this.responseText))['old_list'];
    let action = (JSON.parse(this.responseText))['action'];

    eraseTaskButton(task, taskListSwitch(old_list));
    createTaskButton(task, taskListSwitch(task.list_name));
  } else {
    console.log('TODO: Handle errors');
  }
}
