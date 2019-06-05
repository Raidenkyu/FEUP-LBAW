@extends('layouts.layout')

@section('title','Add Members')

@section('content')


<link rel="stylesheet" href="/css/create.css">
<link rel="stylesheet" href="/css/dashboard_project.css">
<script src="/js/add_member.js" defer></script>

<div class="page-container">
    @include('partials.project-nav2')

    <div class="container px-1 projects">
        <div class="container py-5">
            <div class="row">
                <h1 class="dashboard-title font-weight-bolder px-2">Add New Developers</h1>
            </div>
        </div>

        <div class="container px-0 pt-4">
          <h5 class="font-weight-bolder py-2 team-title">Team</h5>
          <h6 class="py-2 man-title">MANAGERS</h6>
          <div class="py-1 container px-0">
            <container class="managers-pics pics">
              <container class="one-pic">
                <img id_member="{{Auth::user()->id_member}}" src="{{asset(\App\Http\Controllers\ImageController::getImage(Auth::user()->id_member))}}" class="mr-2 rounded-circle team-profile-icon">
                <img id_member="{{Auth::user()->id_member}}" src="/icons/delete.png" class="delete-circle mr-2 rounded-circle team-profile-icon" alt="Delete Icon">
              </container>
            </container>
            <input type="text" name="content" placeholder="+" class="team-profile-add-managers">
            <div class="results managers hidden">
            </div>
          </div>
          <h6 class="pt-2 dev-title">DEVELOPERS</h6>
          <div class="py-1 container px-0">
            <container class="developers-pics pics">
            </container>
            <input type="text" name="content" placeholder="+" class="team-profile-add-developers">
            <div class="results developers hidden">
            </div>
          </div>
          </div>

    </div>
</div>

@endsection
