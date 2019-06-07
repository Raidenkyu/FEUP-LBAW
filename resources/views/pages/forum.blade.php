@extends('layouts.forum')

@section('title', 'Forums')

@section('forum')

<script src="/js/forum.js" defer></script>
<script src="/js/settings.js" defer></script>


<link rel="stylesheet" href="/css/forum_project.css">
<link rel="stylesheet" href="/css/dashboard_project.css">

<div class="col-sm-8 topic-col">
  <div class="topic-title-div">
    <span class="topic-title">{{$selectedForum->topic}}</span>
  </div>
  <div id="all-comments">
    @foreach ($selectedForum->comments as $comment)
    <div id="forum-comment-{{$comment->id_forum_comment}}" class="row forum-comment">
      <div class="col-2 forum-comment-image-box">
        <img src="{{asset(\App\Http\Controllers\ImageController::getImage($comment->member->id_member))}}"
          class="rounded-circle forum-comment-image" alt="User Image">
      </div>
      <div class="col-10">
        <div class="row">
          <div class="col-5 forum-comment-name">
            <span class="align-text-bottom">{{$comment->member->name}}</span>
          </div>
          <div class="col-7 forum-comment-date">
            <span class="align-bottom">{{date('H:i Y-m-d', strtotime($comment->date))}}</span>
            @if ($comment->id_member == Auth::user()->id_member)
            <a class="edit-comment" href="#"><img
                action="/projects/{{$selectedForum->project->id_project}}/forums/{{$selectedForum->id_forum}}/{{$comment->id_forum_comment}}"
                src="/icons/edit_pencil.svg" alt="Edit Comment" /></a>
            <a class="delete-comment" href="#"><img
                action="/projects/{{$selectedForum->project->id_project}}/forums/{{$selectedForum->id_forum}}/{{$comment->id_forum_comment}}"
                src="/icons/trash.svg" alt="Delete Comment" /></a>
            @endif
          </div>
        </div>
        @if ($comment->id_member == Auth::user()->id_member)
        <form class="edit-comment-form"
          action="/projects/{{$selectedForum->project->id_project}}/forums/{{$selectedForum->id_forum}}/{{$comment->id_forum_comment}}"
          method="post">
          @csrf
          @method('put')
          @endif
          <p class="forum-comment-text">{{$comment->content}}</p>
          @if ($comment->id_member == Auth::user()->id_member)
          <button id="edit-comment-button" type="button submit" class="btn btn-secondary hidden-button">Edit
            Comment</button>
        </form>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="form-group forum-comment-box">
    <form id="create-comment-form"
      action="/projects/{{$selectedForum->project->id_project}}/forums/{{$selectedForum->id_forum}}/create_comment"
      method="post">
      @csrf
      <textarea required class="form-control" rows="5" name="content" id="comment-content"></textarea>
      <button id="add-comment-button" type="button submit" class="btn btn-secondary">Add Comment</button>
    </form>
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

<script>
  var token = '{{Session::token()}}';
  var urlCreateComment = '/projects/{{$selectedForum->project->id_project}}/forums/{{$selectedForum->id_forum}}/create_comment';
  var name = '{{\App\Member::find(Auth::user()->id_member)->name}}';
  var idMember = '{{Auth::user()->id_member}}';
  var username = '{{\App\Member::find(Auth::user()->id_member)->username}}';
  var idProject = '{{$selectedForum->project->id_project}}';
  var idForum = '{{$selectedForum->id_forum}}';
  var today = new Date();
</script>

@endsection
