@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<link rel="stylesheet" href="css/admin.css">

<div class="page-container">
  <div class="container py-5">
    <h1 class="dashboard-title font-weight-bolder">Admin dashboard</h1>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm users-table">
        <div class="row m-2">
          <h4 class="dashboard-menu-title font-weight-bolder">Users</h4>
          <img class="mx-2 mb-2" src="./icons/search.svg" style="width:25px;height:25px;" alt="Responsive image">
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
                <tr>
                  <td><img class="ban rounded-circle" src="./images/{{$user['username']}}.jpg"></td>
                  <td>{{$user['name']}}</td>
                  <td>{{$user['email']}}</td>
                  <td>
                    <img class="ban" src="./icons/ban.svg">
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
          <img class="mx-2 mb-2" src="./icons/search.svg" style="width:25px;height:25px;" alt="Responsive image">
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
                  <td>{{$project['name']}}</td>
                  <td>
                    <img class="ban" src="./icons/ban.svg">
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
