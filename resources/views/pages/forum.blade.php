@extends('layouts.forum')

@section('title', 'Forums')

@section('forum')

<script src="/js/forum.js" defer></script>

<link rel="stylesheet" href="/css/forum_project.css">

<div class="col-sm-8 topic-col">
  <div class="topic-title-div">
    <span class="topic-title">{{$selectedForum->topic}}</span>
  </div>
  <div id="all-comments">
    @foreach ($selectedForum->comments as $comment)
    <div class="row forum-comment">
      <div class="col-2 forum-comment-image-box">
        <img src="/images/{{$comment->member->username}}.jpg" class="rounded-circle forum-comment-image" alt="User Photo">
      </div>
      <div class="col-10">
        <div class="row">
          <div class="col-5 forum-comment-name">
            <span class="align-text-bottom">{{$comment->member->name}}</span>
          </div>
          <div class="col-7 forum-comment-date">
            <span class="align-bottom">{{date('H:i Y-m-d', strtotime($comment->date))}}</span>
            <form action="/projects/{{$selectedForum->project->id_project}}/forums/{{$selectedForum->id_forum}}/{{$comment->id_comment}}" method="post">
              @method('patch')
              @csrf
              <button type="submit" >EDIT</button>
            </form>
            <form action="/projects/{{$selectedForum->project->id_project}}/forums/{{$selectedForum->id_forum}}/{{$comment->id_comment}}" method="post">
              @method('delete')
              @csrf
              <button type="submit" >DELETE</button>
            </form>
          </div>
        </div>
        <p class="forum-comment-text">{{$comment->content}}</p>
      </div>
    </div>
    @endforeach
  </div>
  <div class="form-group forum-comment-box">
    <form id="add-comment-form" action="/projects/{{$selectedForum->project->id_project}}/forums/{{$selectedForum->id_forum}}/create_comment" method="post">
      @csrf
      <textarea required class="form-control" rows="5" name="content" id="comment-content"></textarea>
      <button id="add-comment-button" type="button submit" class="btn btn-secondary">Add Comment</button>
    </form>
  </div>
</div>

<script>
    var token = '{{Session::token()}}';
    var urlComment = '/projects/{{$selectedForum->project->id_project}}/forums/{{$selectedForum->id_forum}}/create_comment';
    var name = '{{\App\Member::find(Auth::user()->id_member)->name}}';
    var username = '{{\App\Member::find(Auth::user()->id_member)->username}}';
    var idProject = '{{$selectedForum->project->id_project}}';
    var idForum = '{{$selectedForum->id_forum}}';
</script>

@endsection
