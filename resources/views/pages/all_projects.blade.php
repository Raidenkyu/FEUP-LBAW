@extends('layouts.layout')

@section('title', 'Projects')

@section('content')

<link rel="stylesheet" href="/css/dashboard.css">

<div class="container projects">
  <div class="container py-5">
    <div class="row">
      <h1 class="dashboard-title font-weight-bolder">Projects</h1>
    </div>
  </div>

  <div class="container py-3">
    <div class="row">
      <h5>My Projects</h5>
      <div class="popover__wrapper">
        <a href="#">
          <img class="popover__title mx-2 mt-1" src="./icons/options.svg" style="width:15px;height:15px;" alt="Search Icon">
        </a>
        <div class="popover__content">
          <p class="popover__message">Here you can find all the projects you manage</p>
          </div>
      </div>
    </div>
  </div>

  <div class="container-fluid projects-list">
    @foreach ($my_projects as $project)
    <div class="card text-white mb-3 project-card mx-2" style="background-color:#{{\App\Http\Controllers\ProjectsController::colorToHex($project->color)}};">
      <div class="card-body">
        <a href="/projects/{{ $project->id_project }}" style="color:white;">
          <h5>{{ $project->name }}</h5>
        </a>
      </div>
    </div>
    @endforeach
  </div>

  <div class="container py-3">
    <div class="row">
      <h5>All Projects</h5>
      <div class="popover__wrapper">
        <a href="#">
          <img class="popover__title mx-2 mt-1" src="./icons/options.svg" style="width:15px;height:15px;" alt="Search Icon">
        </a>
        <div class="popover__content">
          <p class="popover__message">Here you can find all the projects you're apart of as a developer and manager</p>
          </div>
      </div>
    </div>
  </div>

  <div class="container projects-list">
    @foreach ($projects as $project)
    <div class="card text-white mb-3 project-card mx-2" style="background-color:#{{\App\Http\Controllers\ProjectsController::colorToHex($project->color)}};">
      <div class="card-body">
        <a href="/projects/{{ $project->id_project }}" style="color:white;">
          <h5>{{ $project->name }}</h5>
        </a>
      </div>
    </div>
    @endforeach

  </div>
</div>
@endsection
