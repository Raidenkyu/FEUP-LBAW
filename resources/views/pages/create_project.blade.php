@extends('layouts.layout')

@section('title','Create a new project')

@section('content')


  <link rel="stylesheet" href="/css/create.css">
  <script src="/js/create_project.js" defer></script>

  </script>


  <div class="container px-1 projects">
    <div class="container py-5">
      <div class="row">
        <h1 class="dashboard-title font-weight-bolder px-2">Create new project</h1>
      </div>
    </div>

  <form id="create-project-form" class="p-0 w-50 justify-content-left" action="/projects" method="post">

    @csrf

    <div class="form-group input-group-lg py-1">
      <input required class="project-name border rounded form-control ml-2" placeholder="Project name" name="name" type="text">
    </div>

    {{-- <input type="hidden" name="color" id="color-selected-hidden" value="Orange"> --}}

    <div class="color-box pt-4">
      <div class="container px-0">
        <h5 class="font-weight-bolder">Color</h5>
        @for ($i = 0; $i < 2; $i++)
          <div class="container">
            @for ($j = 0; $j < 6; $j++)
              <div class="color-picker {{($i == 0 && $j == 0)? 'color-selected' : ''}}" id="color-picker-{{6*$i + $j + 1}}"></div>
            @endfor
          </div>
        @endfor
      </div>
    </div>

    <h5 class="font-weight-bolder py-2 team-title">Team</h5>
    <h6 class="py-2 man-title">MANAGERS</h6>
    <div class="py-1 container px-0">
      <container class="pics">
        <img src="/images/{{Auth::user()->id_member}}.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
      </container>
      <input type="text" name="content" placeholder="+" class="team-profile-add-managers">
      <div class="results managers hidden">
      </div>
    </div>
    <h6 class="pt-2 dev-title">DEVELOPERS</h6>
    <div class="py-1 container px-0">
      <container class="pics">
        {{-- <img src="/images/{{Auth::user()->id_member}}.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image"> --}}
      </container>
      <input type="text" name="content" placeholder="+" class="team-profile-add-developers">
      <div class="results developers hidden">
      </div>
    </div>

    <button class="btn btn-lg btn-primary my-5" type="submit" class="btn btn-primary">Create project</button>

      {{-- --}}
    </div>

  </form>

  <script>
      var token = '{{Session::token()}}';
      var selectedColor = 'Orange';
      var managersList = [{{Auth::user()->id_member}}];
      var developersList = [];
  </script>


@endsection
