@extends('layouts.layout')

@section('title', 'Forums')

@section('content')

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
            <a href="dashboard_project.html"><button type="button" class="btn btn-primary selection-button">•••Tasks</button></a>
            <a href="forum_project.html"><button type="button" class="btn btn-primary selection-button">•••Discussion</button></a>
            <a><button type="button" id="sidebarCollapse" onclick="settingsButtonClicked()" class="btn btn-primary selection-button">•••Settings</button></a>
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
          <div id="all-forums">
            @foreach($forums as $forum)
            <a href="/projects/{{$forum->project->id_project}}/forums/{{$forum->id_forum}}" class="list-group-item list-group-item-action topic-sel">{{$forum->topic}}</a>
            @endforeach
          </div>
          <form id="create-forum-form" class="" action="/projects/{{$forum->project->id_project}}/forums/create_forum" method="post">
            @csrf
            <input href="#" class="list-group-item list-group-item-action topic-extra-sel" id="create-topic" name="topic" required placeholder="+ Create new topic">
          </form>
        </div>
      </div>
      @yield('forum')

    </div>
  </div>
</div>

<script>
    var token = '{{Session::token()}}';
    var urlCreateForum = '/projects/{{$forums->first()->project->id_project}}/forums/create_forum';
    var idProject = '{{$forums->first()->project->id_project}}';
</script>


@endsection
