@extends('layouts.layout')

@section('title', 'Projects')

@section('content')

<link rel="stylesheet" href="/css/dashboard.css">


<div class="container projects">
    <div class="container py-5">
        <div class="row">
            <h1 class="dashboard-title font-weight-bolder">Projects</h1>
            <img class="mx-2 mb-2" src="./icons/search.svg" style="width:25px;height:25px;" alt="Responsive image">
        </div>
    </div>

    <div class="container py-3">
        <h5>My Projects</h5>
    </div>

    <div class="container-fluid projects-list">

        @foreach ($my_projects as $project)
        <div class="card text-white mb-3 project-card mx-2" style="background-color:#{{\App\Http\Controllers\ProjectsController::colorToHex($project->color)}};" /*TODO: Color* />
        <div class="card-body">
            <a href="/projects/{{ $project->id_project }}" style="color:white;">
                <h5>{{ $project->name }}</h5>
            </a>
        </div>
    </div>
    @endforeach

</div>


<div class="container py-3">
    <h5>All Projects</h5>
</div>

<div class="container projects-list">

    @foreach ($projects as $project)
    <div class="card text-white mb-3 project-card mx-2" style="background-color:#{{\App\Http\Controllers\ProjectsController::colorToHex($project->color)}};" /*TODO: Color* />
    <div class="card-body">
        <a href="./dashboard_project.html" /*TODO: Link*/ style="color:white;">
            <h5>{{ $project->name }}</h5>
        </a>
    </div>
</div>
@endforeach

</div>
</div>







@endsection