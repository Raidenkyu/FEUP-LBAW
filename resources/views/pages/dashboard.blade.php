@extends('layouts.layout')

@section('title', '{{$project->name}}')

@section('content')

<link rel="stylesheet" href="/css/dashboard_project.css">

<script src="/js/settings.js" defer></script>

<script src="{{asset('js/task.js')}}" defer></script>
<script src="{{asset('js/utils.js')}}" defer></script>

<div class="page-container">
  @include('partials.project-nav')

  <div class="task-list-block">
    <div class="row lists-table d-flex justify-content-md-start">
      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">To Do</span>
          <div class="btn-group-vertical" data-list="to-do">
            @foreach($todo as $task)
            <button data-id='{{$task->id_task}}' type="button" class="btn btn-primary task-sel task-button" data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
            @endforeach
          </div>
          <div class="add-button-to-do">
            <a type="button" class="add-project-button" data-list="to-do">Create New Task</a>
          </div>
        </div>
      </div>

      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">In Progress</span>
          <div class="btn-group-vertical" data-list="in-progress">
            @foreach($in_progress as $task)
            <button data-id='{{$task->id_task}}' type="button" class="btn btn-primary task-sel task-button" data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
            @endforeach
          </div>
          <div class="add-button-in-progress">
            <a type="button" class="add-project-button" data-list="in-progress">Create New Task</a>
          </div>
        </div>
      </div>

      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">Pending Approval</span>
          <div class="btn-group-vertical" data-list="pending">
            @foreach($pending as $task)
            <button data-id='{{$task->id_task}}' type="button" class="btn btn-primary task-sel task-button" data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
            @endforeach
          </div>
          <div class="add-button-pending">
            <a type="button" class="add-project-button" data-list="pending">Create New Task</a>
          </div>
        </div>
      </div>

      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">Done</span>
          <div class="btn-group-vertical" data-list="done">
            @foreach($done as $task)
            <button data-id='{{$task->id_task}}' type="button" class="btn btn-primary task-sel task-button" data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
            @endforeach
          </div>
          <div class="add-button-done">
            <a type="button" class="add-project-button" data-list="done">Create New Task</a>
          </div>
        </div>
      </div>

      <div class="col-sm-6"></div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="task-pop-up" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="taskTitle">Create Interface</h5>
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
                    <img src="/images/claudio.jpg" class="rounded-circle img-fluid" style="max-width:35px;" alt="Team Member">
                  </div>
                  <div class="col-sm">
                    <span class="res-text task-edit-top-title">Due Date</span>
                    <span id="due-date" class="res-text">Jun 3 at 10:00 PM</span>
                  </div>
                  <div class="col-sm">
                    <span class="res-text task-edit-top-title">Issue</span>
                    <button id="issue" type="button" class="btn btn-primary task-edit-button issue-button res-text">#6566</button>
                  </div>
                </div>
                <div class="row task-edit-desc-row">
                  <div class="col-md-10">
                    <span class="res-text">
                      <img src="/icons/description.svg" class="rounded-circle img-fluid task-edit-desc-svg">Description
                    </span>
                    <div class="form-group task-edit-description">
                      <textarea class="form-control" rows="3" id="description-text"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row task-edit-check-row">
                  <div id="checklist" class="col-md-10">
                    <span class="res-text">
                      <img src="/icons/check.svg" class="rounded-circle img-fluid task-edit-check-svg">Checklist title
                    </span>
                    <br>

                    <div class="progress task-edit-prog-bar">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="row check">
                      <div class="">
                        <img src="/icons/check.svg" class="task-check-icon" alt="User Photo">
                      </div>
                      <div class="res-text tasks-text">
                        <span>Task #1</span>
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
                <div class="btn-group-vertical task-edit-button-group task-list-action">
                  
                </div>

              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>

  <!-- Settings side bar -->
  <div id="mySidenav" class="sidenav mt-5">
    <a href="javascript:void(0)" class="closebtn" onclick="settingsButtonClicked({{$project}});">&times;</a>
    <div class="pop-up-box">
      <div class="pop-up-settings-box pt-3">
        <span class="pop-up-title font-weight-bolder">Settings</span><br>
      </div>

    <form id="settings-form" method="POST" action="/api/projects/{{$project->id_project}}/settings">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="pop-up-name-box px-0 pt-4">
          <span class="pop-up-name-title font-weight-bolder py-2">Name</span><br>
          <input type="text" class="pop-up-name" value="{{ $project->name }}"></input><br>
        </div>
        <div class="pop-up-color-box pt-4">
          <div class="container px-0">
            <h5 class="font-weight-bolder">Color</h5>
            <div  class="color-picker container px-0 pt-2">
              <div>
                <input type="radio" id="color-picker-1" name="color" value="color-1">
                <label for="color-picker-1">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>
              
              <div>
                <input type="radio" id="color-picker-2" name="color" value="color-2">
                <label for="color-picker-2">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>
              
              <div>
                <input type="radio" id="color-picker-3" name="color" value="color-3">
                <label for="color-picker-3">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>
            
              <div>
                <input type="radio" id="color-picker-4" name="color" value="color-4">
                <label for="color-picker-4">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-5" name="color" value="color-4">
                <label for="color-picker-5">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-6" name="color" value="color-4">
                <label for="color-picker-6">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>
            </div>
            <div class="color-picker container px-0">
              <div>
                <input type="radio" id="color-picker-7" name="color" value="color-1">
                <label for="color-picker-7">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>
              
              <div>
                <input type="radio" id="color-picker-8" name="color" value="color-2">
                <label for="color-picker-8">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>
              
              <div>
                <input type="radio" id="color-picker-9" name="color" value="color-3">
                <label for="color-picker-9">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>
            
              <div>
                <input type="radio" id="color-picker-10" name="color" value="color-4">
                <label for="color-picker-10">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-11" name="color" value="color-4">
                <label for="color-picker-11">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-12" name="color" value="color-4">
                <label for="color-picker-12">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Checked" />
                  </span>
                </label>
              </div>
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
        </div>

        <button class="btn btn-primary submit-button my-5" id="submit-button" type="submit" class="btn btn-primary">
          Save
        </button><br>

      </form>

      <button class="btn btn-primary pop-up-button-first" type="submit" class="btn btn-primary">
        Leave project
      </button><br>
      <button class="btn btn-primary pop-up-button-last" type="submit" class="btn btn-primary">
        Delete project
      </button>
    </div>

  </div>

  <!--Div for greyed out background-->
  <div id="opaque"></div>

</div>

@endsection