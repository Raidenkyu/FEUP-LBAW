$('#create-comment-form').on('submit', createForumCommentRequest);
$('#create-forum-form').on('submit', createForumRequest);
$('.delete-comment').on('click', deleteForumCommentRequest);
$('.edit-comment').on('click', editForumComment);
// $('.edit-comment-form').on('submit', editForumCommentRequest);

function editForumComment(event){
  event.preventDefault();
  let comment = event.target.parentNode.parentNode.parentNode.parentNode.querySelector('.forum-comment-text');
  let button = comment.parentNode.querySelector('button');
  button.classList.remove('hidden-button');
  let textarea = document.createElement('textarea');
  textarea.classList.add('forum-comment-textarea');
  textarea.setAttribute('name', 'content');
  textarea.required = true;
  textarea.innerHTML = `${comment.innerHTML}`;
  comment.replaceWith(textarea);
}

function editForumCommentRequest(event){
  // event.preventDefault();
  // console.log(1);
  // console.log(event.target);
}

function createForumCommentRequest(event){
  event.preventDefault();

  let content = $('#comment-content').val();

  if(content != '')
    sendAjaxRequest('post', urlCreateComment, {content: content, _token: token}, createForumCommentHandler);
}

function createForumRequest(event){
  event.preventDefault();

  let topic = $('#create-topic').val();

  if(topic != '')
    sendAjaxRequest('post', urlCreateForum, {topic: topic, _token: token}, createForumHandler);
}

function deleteForumCommentRequest(event){
  event.preventDefault();
  sendAjaxRequest('delete', event.target.getAttribute("action"), {_token: token}, deleteForumCommentHandler);
}

function editForumCommentRequest(event){
  event.preventDefault();
  // sendAjaxRequest('delete', event.target.getAttribute("action"), {_token: token}, deleteForumCommentHandler);
}

function createForumCommentHandler(){
  // if (this.status != 200) window.location = '/';
  let comment = JSON.parse(this.responseText);

  let newComment = createComment(comment);
  document.querySelector('#all-comments').appendChild(newComment);

  newComment.querySelector('.delete-comment').addEventListener('click', deleteForumCommentRequest);
  newComment.querySelector('.edit-comment').addEventListener('click', editForumCommentRequest);

  $('#comment-content').val("");

}

function createForumHandler(){
  // if (this.status != 200) window.location = '/';
  let forum = JSON.parse(this.responseText);

  let newForum = createForum(forum);
  document.querySelector('#all-forums').appendChild(newForum);

  $('#create-topic').value = "";

}

function deleteForumCommentHandler(){
  // if (this.status != 200) window.location = '/';
  let id = JSON.parse(this.responseText);
  $(`#forum-comment-${id}`).remove();
}

function createComment(comment){
  let newComment = document.createElement('div');
  newComment.id = `forum-comment-${comment.id_forum_comment}`;
  newComment.classList.add('row');
  newComment.classList.add('forum-comment');
  newComment.innerHTML = `
  <div class="col-2 forum-comment-image-box">
    <img src="/images/${username}.jpg" class="rounded-circle forum-comment-image" alt="User Photo">
  </div>
  <div class="col-10">
    <div class="row">
      <div class="col-5 forum-comment-name">
        <span class="align-text-bottom">${name}</span>
      </div>
      <div class="col-7 forum-comment-date">
        <span class="align-bottom">${String(today.getHours() + 1).padStart(2, '0') + ':' + String(today.getMinutes()).padStart(2, '0') + ' ' + today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0')}</span>
        <a class="edit-comment" href="#"><img action="/projects/${idProject}/forums/${idForum}/${comment.id_forum_comment}" src="/icons/edit_pencil.svg" alt="Edit comment" /></a>
        <a class="delete-comment" href="#"><img action="/projects/${idProject}/forums/${idForum}/${comment.id_forum_comment}" src="/icons/trash.svg" alt="Delete comment" /></a>
      </div>
    </div>
    <p class="forum-comment-text">${comment.content}</p>
  </div>
  `
  return newComment;
}

function createForum(forum){
  let newForum = document.createElement('a');
  newForum.classList.add('list-group-item');
  newForum.classList.add('list-group-item-action');
  newForum.classList.add('topic-sel');
  newForum.setAttribute('href', `/projects/${idProject}/forums/${forum.id_forum}`);
  newForum.innerHTML = `${forum.topic}`
  return newForum;
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}
