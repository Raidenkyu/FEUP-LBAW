let taskButtons = document.querySelectorAll('.task-button');

taskButtons.forEach(function(button) {
  button.addEventListener('click', generateTaskModal.bind(button));
});


function generateTaskModal() {
  let id_task = this.getAttribute('data-id');
  // TODO: get project id
  let id_project = 1;
  var request = new XMLHttpRequest();
  request.addEventListener('load', function() {
    console.log(JSON.parse(this.responseText));
  });

  request.open(
      'GET', '/api/projects/' + id_project + '/tasks/' + id_task, true);
  request.send();
}
