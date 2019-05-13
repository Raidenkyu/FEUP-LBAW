@extends('layouts.layout')

@section('title', 'Profile')

@section('content')

<link rel="stylesheet" href="/css/dashboard_project.css">

<script src="/js/settings.js" defer></script>

<div class="page-container">
  <div class="container-fluid title-row">
    <div class="row">
      <div class="col-2 align-self-center">
        <div class="title-line"></div>
      </div>
      <div class="col-* title-box">{{$project->name}}</div>
      <div class="col-3 title-buttons">
        <div class="container">
          <div class="btn-group">
            <a href="dashboard_project.html"><button type="button"
                class="btn btn-primary selection-button">•••Tasks</button></a>
            <a href="forum_project.html"><button type="button"
                class="btn btn-primary selection-button">•••Discussion</button></a>
            <a><button type="button" id="sidebarCollapse"
                class="btn btn-primary selection-button">•••Settings</button></a>
          </div>
        </div>
      </div>
      <div class="col-*"></div>
    </div>
  </div>

  <div class="task-list-block">
    <div class="row lists-table d-flex justify-content-md-start">
      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">To Do</span>
          <div class="btn-group-vertical">
            @foreach($todo as $task)
              <button type="button" class="btn btn-primary task-sel" data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
            @endforeach
          </div>
          <!--<a class="list-group-item list-group-item-action task-sel">Create Interface</a>
          <a href="#" class="list-group-item list-group-item-action task-sel">Fix Login</a>
          <a href="#" class="list-group-item list-group-item-action task-sel">Add Tests</a>-->
        </div>
      </div>

      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">In Progress</span>
          <div class="btn-group-vertical">
          @foreach($in_progress as $task)
            <button type="button" class="btn btn-primary task-sel" data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
          @endforeach
          </div>
        </div>
      </div>

      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">Pending Approval</span>
          <div class="btn-group-vertical">
          @foreach($pending as $task)
            <button type="button" class="btn btn-primary task-sel" data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
          @endforeach
          </div>
        </div>
      </div>

      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">Done</span>
          <div class="btn-group-vertical">
          @foreach($done as $task)
            <button type="button" class="btn btn-primary task-sel" data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
          @endforeach
          </div>
        </div>
      </div>

      <div class="col-sm-6"></div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="task-pop-up" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Interface</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-sm-9">
                <div class="row task-edit-top">
                  <div class="col-sm">
                    <span class="res-text task-edit-top-title">Members</span>
                    <img src="/images/claudio.jpg" class="rounded-circle img-fluid" style="max-width:35px;"
                      alt="Team Member">
                  </div>
                  <div class="col-sm">
                    <span class="res-text task-edit-top-title">Due Date</span>
                    <span class="res-text">Jun 3 at 10:00 PM</span>
                  </div>
                  <div class="col-sm">
                    <span class="res-text task-edit-top-title">Issue</span>
                    <button type="button"
                      class="btn btn-primary task-edit-button issue-button res-text">#6566</button>
                  </div>
                </div>
                <div class="row task-edit-desc-row">
                  <div class="col-md-10">
                    <span class="res-text">
                      <img src="/icons/description.svg" class="rounded-circle img-fluid task-edit-desc-svg">Description
                    </span>
                    <div class="form-group task-edit-description">
                      <textarea class="form-control" rows="3" id="comment"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row task-edit-check-row">
                  <div class="col-md-10">
                    <span class="res-text">
                      <img src="/icons/check.svg" class="rounded-circle img-fluid task-edit-check-svg">Checklist title
                    </span>
                    <br>

                    <div class="progress task-edit-prog-bar">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="row">
                      <div class="">
                        <img src="/icons/check.svg" class="rounded-circle task-check-icon" alt="User Photo">
                      </div>
                      <div class="res-text tasks-text">
                        <span>Task #1</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="">
                        <img src="/icons/check.svg" class="task-check-icon" alt="User Photo">
                      </div>
                      <div class="res-text tasks-text">
                        <span>Task #2</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="">
                        <img src="/icons/check.svg" class="task-check-icon" alt="User Photo">
                      </div>
                      <div class="res-text tasks-text">
                        <span>Task #3</span>
                      </div>
                    </div>


                  </div>
                </div>

                <div class="row task-edit-comm-row">
                  <div class="col-md-10">
                    <span class="res-text">
                      <img src="/icons/comments.svg" class="img-fluid task-edit-check-svg">Comments
                    </span>

                  </div>
                </div>

              </div>
              <div class="col-sm-3 task-edit-side">
                <span>Add to Task</span>

                <div class="btn-group-vertical task-edit-button-group">
                  <button type="button" class="btn btn-primary task-edit-button res-text">Members</button>
                  <button type="button" class="btn btn-primary task-edit-button res-text">Due Date</button>
                  <button type="button" class="btn btn-primary task-edit-button res-text">Checklist</button>
                  <button type="button" class="btn btn-primary task-edit-button res-text">Attachment</button>
                </div>
                <br>
                <span>Actions</span>
                <div class="btn-group-vertical task-edit-button-group">
                  <button type="button" class="btn btn-primary task-edit-button res-text">Move to in Progress</button>
                </div>

              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>

  <div id="mySidenav" class="sidenav mt-5">
    <a href="javascript:void(0)" class="closebtn" onclick="settingsButtonClicked();">&times;</a>
    <div class="pop-up-box">
      <div class="pop-up-settings-box pt-3">
        <span class="pop-up-title font-weight-bolder">Settings</span><br>
      </div>
      <div class="pop-up-name-box px-0 pt-4">
        <span class="pop-up-name-title font-weight-bolder py-2">Name</span><br>
        <span class="pop-up-name">{{ $project->name }}</span><br>
      </div>
      <div class="pop-up-color-box pt-4">
        <div class="container px-0">
          <h5 class="font-weight-bolder">Color</h5>
          <div class="container px-0 pt-2">
            <div class="color-picker" id="color-picker-1"></div>
            <div class="color-picker" id="color-picker-2"></div>
            <div class="color-picker" id="color-picker-3"></div>
            <div class="color-picker" id="color-picker-4"></div>
            <div class="color-picker" id="color-picker-5"></div>
            <div class="color-picker" id="color-picker-6"></div>
          </div>
          <div class="container px-0">
            <div class="color-picker" id="color-picker-7"></div>
            <div class="color-picker" id="color-picker-8"></div>
            <div class="color-picker" id="color-picker-9"></div>
            <div class="color-picker" id="color-picker-10"></div>
            <div class="color-picker" id="color-picker-11"></div>
            <div class="color-picker" id="color-picker-12"></div>
          </div>
        </div>
      </div>

      <div class="container px-0 pt-4">
        <h5 class="font-weight-bolder py-2 pop-up-team-title">Team</h5>
        <h6 class="py-2 pop-up-man-title">MANAGERS</h6>
        <div class="py-1 container px-0">
          <img src="/images/pedro.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
          <img src="/icons/plus.svg" class="mr-2 rounded-circle team-profile-add" alt="Responsive image">
        </div>
        <h6 class="pt-2 pop-up-dev-title">DEVELOPERS</h6>
        <div class="pt-1 pb-2 container px-0">
          <img src="/images/claudio.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
          <img src="/images/joao.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
          <img src="/images/fernando.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
          <img src="/icons/plus.svg" class="mr-2 rounded-circle team-profile-add" alt="Responsive image">
        </div>
        <button class="btn btn-primary pop-up-button-first" type="submit" class="btn btn-primary">
          Leave project
        </button><br>
        <button class="btn btn-primary pop-up-button-last" type="submit" class="btn btn-primary">
          Delete project
        </button>
      </div>
    </div>

  </div>

  <!--Div for greyed out background-->
  <div id="opaque"></div>

</div>

@endsection
