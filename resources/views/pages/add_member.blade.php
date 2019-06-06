@extends('layouts.layout')

@section('title','Add Members')

@section('content')


<link rel="stylesheet" href="/css/add_member.css">
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
          @foreach (\App\ProjectMember::getManagers($id_project) as $manager)
          <container class="one-pic">
            <img id_member="{{$manager->id_member}}" src="{{asset(\App\Http\Controllers\ImageController::getImage($manager->id_member))}}" class="mr-2 rounded-circle team-profile-icon">
            <img id_member="{{$manager->id_member}}" src="/icons/delete.png" class="delete-circle mr-2 rounded-circle team-profile-icon" alt="Delete Icon">
          </container>
          @endforeach
        </container>
        <input type="text" name="content" placeholder="+" class="team-profile-add-managers">
        <div class="results managers hidden">
        </div>
      </div>
      <h6 class="pt-2 dev-title">DEVELOPERS</h6>
      <div class="py-1 container px-0">
        <container class="developers-pics pics">
          @foreach (\App\ProjectMember::getDevs($id_project) as $developer)
          <container class="one-pic">
            <img id_member="{{$developer->id_member}}" src="{{asset(\App\Http\Controllers\ImageController::getImage($developer->id_member))}}" class="mr-2 rounded-circle team-profile-icon">
            <img id_member="{{$developer->id_member}}" src="/icons/delete.png" class="delete-circle mr-2 rounded-circle team-profile-icon" alt="Delete Icon">
          </container>
          @endforeach
        </container>
        <input type="text" name="content" placeholder="+" class="team-profile-add-developers">
        <div class="results developers hidden">
        </div>
      </div>
    </div>

    <div class="container px-0 pt-4">
      <h5 class="font-weight-bolder py-2 team-title">Filters</h5>
      <h6 class="py-2 man-title">AGE (<span id="range-min-value">18</span> through <span id="range-max-value">99</span>)</h6>
      <div>
        <p class="py-2 man-title">Minimum</p>
        <span class="py-2 man-title">18</span>
        <input id="range-min" type="range" id="start" name="volume" min="18" max="99" value="18">
        <span class="py-2 man-title">99</span>
      </div>
      <div>
        <p class="py-2 man-title">Maximum</p>
        <span class="py-2 man-title">18</span>
        <input id="range-max" type="range" id="start" name="volume" min="18" max="99" value="99">
        <span class="py-2 man-title">99</span>
      </div>
      <h6 class="py-2 man-title">LOCATION</h6>
      <h6 class="py-2 man-title">LANGUAGES</h6>
    </div>

  </div>
</div>


<script>
  document.querySelector('#range-min').addEventListener('mouseup', function(event){
    if(event.target.value > rangeMax)
      event.target.value = rangeMin;
    else
      rangeMin = event.target.value;

      document.querySelector('#range-min-value').innerHTML = rangeMin;
  });


  document.querySelector('#range-max').addEventListener('mouseup', function(event){
    if(event.target.value < rangeMin)
      event.target.value = rangeMax;
    else
      rangeMax = event.target.value;

    document.querySelector('#range-max-value').innerHTML = rangeMax;
  });


  var rangeMax = 99;
  var rangeMin = 18;
  var token = '{{Session::token()}}';
  var idProject = {{ $id_project }};
  var selectedColor = 'Orange';
  var managersList = [];
  var developersList = [];
  var filters = {
    age: 0,
    location: '',
    languages: []
  };

  [].forEach.call(document.querySelectorAll('.managers-pics .one-pic .delete-circle'), function(manager) {
    managersList.push(parseInt(manager.getAttribute('id_member')));
  });

  [].forEach.call(document.querySelectorAll('.developers-pics .one-pic .delete-circle'), function(developer) {
    developersList.push(parseInt(developer.getAttribute('id_member')));
  });
</script>

@endsection
