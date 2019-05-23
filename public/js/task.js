let taskButtons = document.querySelectorAll('.task-button');

taskButtons.forEach(function(button) {
  button.addEventListener('click', generateTaskModal.bind(button));
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
