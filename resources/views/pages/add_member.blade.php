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
            <h5 class="font-weight-bolder py-2 pop-up-team-title">Team</h5>
            <h6 class="py-2 pop-up-man-title">MANAGERS</h6>
            <div id="settings-managers" class="py-1 container px-0">
              <img src="/images/pedro.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Member Image">
              <img src="/icons/plus.svg" class="mr-2 rounded-circle team-profile-add" alt="Member Image">
            </div>
            <h6 class="pt-2 pop-up-dev-title">DEVELOPERS</h6>
            <div id="settings-devs" class="pt-1 pb-2 container px-0">
              <img src="/images/claudio.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Member Image">
              <img src="/images/joao.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Member Image">
              <img src="/images/fernando.jpg" class="mr-2 rounded-circle team-profile-icon" alt="Member Image">
              <img src="/icons/plus.svg" class="mr-2 rounded-circle team-profile-add" alt="Member Image">
            </div>
          </div>

    </div>
</div>

@endsection