@extends('layouts.forum')

@section('title', 'Forums')

@section('forum')


<link rel="stylesheet" href="/css/forum_project.css">

<div class="col-sm-8 topic-col">
  <div class="topic-title-div">
    <span class="topic-title">{{$selectedForum->topic}}</span>
  </div>
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

          <span class="align-bottom">{{$comment->date}}</span>
        </div>
      </div>
      <p class="forum-comment-text">{{$comment->content}}</p>
    </div>
  </div>
  @endforeach
  <button type="button" class="btn btn-secondary">Add Comment</button>
  <div class="form-group forum-comment-box">
    <textarea class="form-control" rows="5" id="comment"></textarea>
  </div>
</div>

@endsection
