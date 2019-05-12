@extends('layouts.layout')

@section('title', 'Forums')

@section('content')

<link rel="stylesheet" href="/css/forum_project.css">

<div class="page-container">

  <div class="container-fluid title-row">
    <div class="row">
      <div class="col-2 align-self-center">
        <div class="title-line"></div>
      </div>
      <div class="col-* title-box">{{$forums->first()->project->name}}</div>
      <div class="col-3 title-buttons">
        <div class="container">
          <div class="btn-group">
            <a href="dashboard_project.html"><button type="button"
                class="btn btn-primary selection-button">•••Tasks</button></a>
            <a href="forum_project.html"><button type="button"
                class="btn btn-primary selection-button">•••Discussion</button></a>
            <a><button type="button" id="sidebarCollapse" onclick="settingsButtonClicked()"
                class="btn btn-primary selection-button">•••Settings</button></a>
          </div>
        </div>
      </div>
      <div class="col-*"></div>
    </div>
  </div>

  <div class="topic-block">
    <div class="row d-flex justify-content-md-start">
      <div class="col-sm-* topic-col">
        <div class="list-group">
          <span class="topics-list-title">Topics</span>
          @foreach($forums as $forum)
            <a href="/projects/{{$forum->project->id_project}}/forums/{{$forum->id_forum}}" class="list-group-item list-group-item-action topic-sel">{{$forum->topic}}</a>
          @endforeach
          <a href="#" class="list-group-item list-group-item-action topic-extra-sel" id="create-topic">+ Create Topic</a>
        </div>
      </div>

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

    </div>
  </div>


</div>

@endsection
