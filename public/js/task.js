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
  console.log(JSON.parse(this.responseText));
}
