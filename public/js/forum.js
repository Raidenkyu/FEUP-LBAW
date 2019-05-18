$('#add-comment-form').on('submit', forumCommentRequest);
$('#create-forum-form').on('submit', forumRequest);

function forumCommentRequest(event){
  event.preventDefault();

  let content = $('#comment-content').val();

  if(content != '')
    sendAjaxRequest('post', urlComment, {content: content, _token: token}, forumCommentHandler);
}

function forumRequest(event){
  event.preventDefault();

  let topic = $('#create-topic').val();

  if(topic != '')
    sendAjaxRequest('post', urlForum, {topic: topic, _token: token}, forumHandler);
}

function forumCommentHandler(){
  // if (this.status != 200) window.location = '/';
  let comment = JSON.parse(this.responseText);

  let newComment = createComment(comment);
  document.querySelector('#all-comments').appendChild(newComment);

  $('#add-comment-form [type=text]').value = "";

}

function forumHandler(){
  // if (this.status != 200) window.location = '/';
  let forum = JSON.parse(this.responseText);

  let newForum = createForum(forum);
  document.querySelector('#all-forums').appendChild(newForum);

  $('#create-topic').value = "";

}

function createComment(comment){
  let newComment = document.createElement('div');
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
        <span class="align-bottom">${comment.date}</span>
        <form action="/projects/${idProject}/forums/${idForum}/${comment.id_comment}" method="post">
          <input type="hidden" name="_method" value="patch">
          <input type="hidden" name="_token" value="${token}">
          <button type="submit" >EDIT</button>
        </form>
        <form action="/projects/${idProject}/forums/${idForum}/${comment.id_comment}" method="post">
        <input type="hidden" name="_method" value="delete">
        <input type="hidden" name="_token" value="${token}">
          <button type="submit" >DELETE</button>
        </form>
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
