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

  <form class="p-0 w-50 justify-content-left" action="/projects" method="post">

    @csrf

    <div class="form-group input-group-lg py-1">
      <input required class="border rounded form-control ml-2" placeholder="Project name" name="name" type="text">
    </div>

    <input type="hidden" name="color" id="color-selected-hidden" value="Orange">

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

    <button class="btn btn-lg btn-primary my-5" type="submit" class="btn btn-primary">Create project</button>

      {{-- --}}
    </div>

  </form>
    {{--




    <div class="container px-0 pt-4">
      <h5 class="font-weight-bolder py-2 team-title">Team</h5>
      <h6 class="py-2 man-title">MANAGERS</h6>
      <div class="py-1 container px-0">
        <img src="/images/pedro.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
        <img src="/icons/plus.svg" class="mr-2 rounded-circle team-profile-add" alt="Responsive image">
      </div>
      <h6 class="pt-2 dev-title">DEVELOPERS</h6>
      <div class="pt-1 pb-2 container px-0">
        <img src="/images/claudio.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
        <img src="/images/joao.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
        <img src="/images/fernando.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
        <img src="/icons/plus.svg" class="mr-2 rounded-circle team-profile-add" alt="Responsive image">
      </div>
      <button class="btn btn-lg btn-primary my-5" type="submit" class="btn btn-primary">
        <a href="/dashboard_project.html" style="color:white;">Create project</a>
      </button>
    </div>--}}

@endsection
