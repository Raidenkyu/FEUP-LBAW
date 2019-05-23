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

  let date = task['due_date'];
  if (date != null) {
    let due_date = document.querySelector('#due-date');
    due_date.innerHTML = date;
  }
}
