@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<link rel="stylesheet" href="{{asset('/css/admin.css')}}">
<script src="{{asset('/js/utils.js')}}" defer></script>
<script src="{{asset('/js/admin.js')}}" defer></script>
<div class="page-container">
  <div class="container py-5">
    <h1 class="dashboard-title font-weight-bolder">Admin dashboard</h1>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm users-table">
        <div class="row m-2">
          <h4 class="dashboard-menu-title font-weight-bolder">Users</h4>
          <img class="mx-2 mb-2" src="{{asset('icons/search.svg')}}" style="width:25px;height:25px;" alt="Search Icon">
        </div>
        <div class="row mx-2">
          <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr id="user{{$user->id_member}}">
                  <td><img class="ban rounded-circle" src="{{asset(\App\Http\Controllers\ImageController::getImage($user->id_member))}}" alt="User Image"></td>
                  <td><a class="text-dark profile-ref" href="/profiles/{{$user->id_member}}">{{$user->name}}</a></td>
                  <td>{{$user->email}}</td>
                  <td>
                    <img data-id="{{$user->id_member}}" data-ban="{{$user->banned? 'true' : 'false'}}" class="ban" src="{{asset(\App\Http\Controllers\ImageController::getBanImage($user->banned))}}" alt="Ban Icon">
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        </div>
      </div>
      <div class="col-sm projects-table">
        <div class="row m-2">
          <h4 class="dashboard-menu-title">Projects</h4>
          <img class="mx-2 mb-2" src="{{asset('icons/search.svg')}}" style="width:25px;height:25px;" alt="Search Icon">
        </div>
        <div class="row mx-2">
          <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Project</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($projects as $project)
                <tr>
                  <td>{{$project->name}}</td>
                  <td>
                    <img data-id="{{$project->id_project}}" data-delete="{{$project->deleted? 'true' : 'false'}}" class="ban" src="{{asset(\App\Http\Controllers\ImageController::getBanImage($project->deleted))}}" alt="Ban Icon">
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection