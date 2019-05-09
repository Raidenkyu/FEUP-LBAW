@extends('layouts.layout')

@section('title','Create a new project')

@section('content')

  <div class="container px-1 projects">
    <div class="container py-5">
      <div class="row">
        <h1 class="dashboard-title font-weight-bolder px-2">Create Project</h1>
      </div>
    </div>

    <form class="p-0 w-50 justify-content-left">
      <div class="form-group input-group-lg py-1">
        <input class="border rounded form-control ml-2" placeholder="Project name" type="text">
      </div>
    </form>
    <div class="color-box pt-4">
      <div class="container px-0">
        <h5 class="font-weight-bolder">Color</h5>
        <div class="container">
          <div class="color-picker" id="color-picker-1"></div>
          <div class="color-picker" id="color-picker-2"></div>
          <div class="color-picker" id="color-picker-3"></div>
          <div class="color-picker" id="color-picker-4"></div>
          <div class="color-picker" id="color-picker-5"></div>
          <div class="color-picker" id="color-picker-6"></div>
        </div>
        <div class="container">
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
      <h5 class="font-weight-bolder py-2 team-title">Team</h5>
      <h6 class="py-2 man-title">MANAGERS</h6>
      <div class="py-1 container px-0">
        <img src="./images/pedro.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
        <img src="./icons/+.svg" class="mr-2 rounded-circle team-profile-add" alt="Responsive image">
      </div>
      <h6 class="pt-2 dev-title">DEVELOPERS</h6>
      <div class="pt-1 pb-2 container px-0">
        <img src="./images/claudio.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
        <img src="./images/joao.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
        <img src="./images/fernando.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Responsive image">
        <img src="./icons/+.svg" class="mr-2 rounded-circle team-profile-add" alt="Responsive image">
      </div>
      <button class="btn btn-lg btn-primary my-5" type="submit" class="btn btn-primary">
        <a href="./dashboard_project.html" style="color:white;">Create project</a>
      </button>
    </div>
  </div>

@endsection
