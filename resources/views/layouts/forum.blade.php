@extends('layouts.layout')

@section('title', 'Forums')

@section('content')

<div class="page-container">

  @include('partials.project-nav')
  <div class="topic-block">
    <div class="row d-flex justify-content-md-start">
      <div class="col-sm-* topic-col">
        <div class="list-group">
          <span class="topics-list-title">Topics</span>
          <div id="all-forums">
            @foreach($forums as $forum)
            <a href="/projects/{{$forum->project->id_project}}/forums/{{$forum->id_forum}}"
              class="list-group-item list-group-item-action topic-sel">{{$forum->topic}}</a>
            @endforeach
          </div>
          @if(\App\Member::find(Auth::user()->id_member)->my_projects->find($forum->project->id_project) != null)
          <form id="create-forum-form" class="" action="/projects/{{$forum->project->id_project}}/forums/create_forum"
            method="post">
            @csrf
            <input class="list-group-item list-group-item-action topic-extra-sel" id="create-topic"
              name="topic" required placeholder="+ Create new topic">
          </form>
          @endif
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
