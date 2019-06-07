@extends('layouts.layout')

@section('title', $project->name)

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
            <button data-id='{{$task->id_task}}' type="button" class="btn btn-primary task-sel task-button"
              data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
            @endforeach
          </div>
          <div class="add-button-to-do">
            <button type="button" class="add-project-button btn btn-outline-light btn-block" data-list="to-do">Create New Task</button>
          </div>
        </div>
      </div>

      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">In Progress</span>
          <div class="btn-group-vertical" data-list="in-progress">
            @foreach($in_progress as $task)
            <button data-id='{{$task->id_task}}' type="button" class="btn btn-primary task-sel task-button"
              data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
            @endforeach
          </div>
          <div class="add-button-in-progress">
            <button type="button" class="add-project-button btn btn-outline-light btn-block" data-list="in-progress">Create New Task</button>
          </div>
        </div>
      </div>

      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">Pending Approval</span>
          <div class="btn-group-vertical" data-list="pending">
            @foreach($pending as $task)
            <button data-id='{{$task->id_task}}' type="button" class="btn btn-primary task-sel task-button"
              data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
            @endforeach
          </div>
          <div class="add-button-pending">
            <button type="button" class="add-project-button btn btn-outline-light btn-block" data-list="pending">Create New Task</button>
          </div>
        </div>
      </div>

      <div class="col-sm-* list-col">
        <div class="list-group">
          <span class="list-col-title">Done</span>
          <div class="btn-group-vertical" data-list="done">
            @foreach($done as $task)
            <button data-id='{{$task->id_task}}' type="button" class="btn btn-primary task-sel task-button"
              data-toggle="modal" data-target="#task-pop-up">{{$task->name}}</button>
            @endforeach
          </div>
          <div class="add-button-done">
            <button type="button" class="add-project-button btn btn-outline-light btn-block" data-list="done">Create New Task</button>
          </div>
        </div>
      </div>

      <div class="col-sm-6"></div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="task-pop-up" tabindex="-1" role="dialog" aria-labelledby="taskTitleHeader"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title-header" id="taskTitleHeader"> <input type="text" id="taskTitle"
              class="modal-title border rounded" name="title"></input></h5>
          <button id="close-task-button" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <span class="res-text task-edit-top-title">Issue</span>
                    <input type="text" id="issue"
                        class="modal-title border rounded" name="issue"></input>

                  </div>
                </div>
                <div class="row task-edit-desc-row">
                  <div class="col-md-10">
                    <span class="res-text">
                      <img src="/icons/description.svg" class="rounded-circle img-fluid task-edit-desc-svg"
                        alt="Description Icon">Description
                    </span>
                    <div class="form-group task-edit-description">
                      <textarea class="form-control" rows="4" id="description-text" style="resize: none;"></textarea>
                    </div>
                  </div>
                </div>
                <div id="checklist-box" class="row task-edit-check-row">
                  <div id="checklist" class="col-md-10">
                    <span class="res-text">
                      <img src="/icons/check.svg" class="rounded-circle img-fluid task-edit-check-svg"
                        alt="Checklist Icon">Checklist title
                    </span>
                    <br>

                    <div class="row check">
                      <div class="">
                        <img src="/icons/check.svg" class="task-check-icon" alt="Checklist Subtasks Check Icon">
                      </div>
                      <div class="res-text tasks-text">
                        <span class="check-text">Task #1</span>
                      </div>
                    </div>

                  </div>

                </div>
                <div id="add-task-button" class="row">

                  <div class="">
                    <button class="btn btn-link pr-0 mr-0">
                      <img src="/icons/plus.svg" class="task-add-icon pr-0 mr-0" alt="Add SubTask Icon">
                    </button>
                  </div>
                  <div class="res-text tasks-text">
                    <button class="add-subtask btn btn-link text-dark">Add SubTask</button>
                  </div>

                </div>

              </div>
              <div class="col-sm-3 task-edit-side">
                <span>Task Settings</span>

                <div class="btn-group-vertical task-edit-button-group">
                  <button type="button" class="btn btn-primary task-edit-button res-text">Self-Assign</button>
                  <button type="button" class="btn btn-primary task-edit-button delete-task res-text" data-dismiss="modal">Delete Task</button>
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

      @if($isManager)
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
            <div class="color-picker container px-0 pt-2">
              <div>
                <input type="radio" id="color-picker-1" name="color" value="color-1">
                <label for="color-picker-1">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Orange Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-2" name="color" value="color-2">
                <label for="color-picker-2">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Yellow Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-3" name="color" value="color-3">
                <label for="color-picker-3">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Red Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-4" name="color" value="color-4">
                <label for="color-picker-4">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Green Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-5" name="color" value="color-5">
                <label for="color-picker-5">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Lilac Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-6" name="color" value="color-6">
                <label for="color-picker-6">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Sky Color" />
                  </span>
                </label>
              </div>
            </div>
            <div class="color-picker container px-0">
              <div>
                <input type="radio" id="color-picker-7" name="color" value="color-7">
                <label for="color-picker-7">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Brown Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-8" name="color" value="color-8">
                <label for="color-picker-8">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Golden Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-9" name="color" value="color-9">
                <label for="color-picker-9">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Bordeaux Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-10" name="color" value="color-10">
                <label for="color-picker-10">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Emerald Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-11" name="color" value="color-11">
                <label for="color-picker-11">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Purple Color" />
                  </span>
                </label>
              </div>

              <div>
                <input type="radio" id="color-picker-12" name="color" value="color-12">
                <label for="color-picker-12">
                  <span>
                    <img src="/icons/check-icn.svg" alt="Blue Color" />
                  </span>
                </label>
              </div>
            </div>
          </div>
        </div>



        <button class="btn btn-primary submit-button my-5" id="submit-button" type="submit">
          Save
        </button><br>

      </form>
      @endif

      @if($isManager)
      <button onclick="location.href = '/projects/{{$project->id_project}}/members'"
        class="btn btn-primary mt-2 pop-up-button-first" type="submit">
        Add members
      </button><br>

      <form method="POST" action="/api/projects/{{ $project->id_project }}/delete">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button class="btn btn-primary pop-up-button-delete" type="submit">
          Delete project
        </button><br>
      </form>

      @endif

      <form method="POST" action="/api/projects/{{ $project->id_project }}/leave">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button class="btn btn-primary pop-up-button-delete pop-up-button-last" type="submit">
          Leave project
        </button><br>
      </form>

    </div>

  </div>

  <!--Div for greyed out background-->
  <div id="opaque"></div>

</div>

@endsection
