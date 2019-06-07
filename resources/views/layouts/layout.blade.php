<!DOCTYPE html>
<html lang="en">

<head>
  <title>@yield('title','workpad')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC%7CRoboto:100,200,300,400,500,600,700,800,900"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/index.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/footer.css') }}">
  <link rel="stylesheet" type="text/css" media="print" href="{{ asset('/css/print.css') }}">
  <script src="{{ asset('/js/jquery-3.2.1.slim.min.js') }}"></script>
  <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/js/navbar.js') }}" defer></script>

</head>

<body>

  <nav class="navbar navbar-dark navbar-right shadow-sm sticky-top">
    <div id="logo" class="logo-container mr-auto">
      <a href="{{ url('/') }}"><img src="/icons/logo.png" style="width:50px;" alt="Workpad logo"></a>
    </div>

    <div id="sign" class="login-container">
      @if (Auth::check())
      <div id="isLogged" style="display:none;" data-isLogged="true"></div>
      <div class="center-group" style="display:inline">
        <div class="btn-group">
          <button id="notification-icon" type="button"
            class="btn btn-primary dropdown-toggle dropdown-toggle-split px-0" data-toggle="dropdown">
            @if (\App\Notification::existsNotifications(Auth::user()))
            <img src="/icons/notification_center_on.svg" class="mx-1" style="width:45px" alt="There are notifications">
            @else
            <img src="/icons/notification_center.svg" class="mx-1" style="width:45px" alt="No notifications">
            @endif
          </button>
          <div class="dropdown-menu container" style="width: 420px">
            <div class="notify-box"><a class="dropdown-item" href="#">Link 1</a></div>
            <div class="notify-box"><a class="dropdown-item" href="#">Link 2</a></div>
          </div>
        </div>
        <a href="{{ url('/projects') }}"><img src="/icons/dashboard.svg" class="mx-1" style="width:45px"
            alt="Dashboard Icon"></a>
        <a href="{{ url('/projects/new') }}"><img src="/icons/create_project.svg" class="mx-1" style="width:45px"
            alt="Create Project"></a>
        <a href="{{ url('/profile') }}"><img
            src="{{asset(\App\Http\Controllers\ImageController::getImage(Auth::user()->id_member))}}"
            class="rounded-circle mx-2" style="width:35px;" alt="User Image"></a>
        <a href="{{ url('/profile') }}"><span class="user-name"
            style="color:white; margin-right:7px">{{ (\App\Member::where('id_member',Auth::user()->id_member)->get())[0]->name }}</span></a>
      </div>
      <button class="button btn btn-secondary logout" onclick="location.href = '/logout';">
        Logout
      </button>
      @else
      <div id="isLogged" style="display:none;" data-isLogged="false"></div>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Log In</button>
      <button class="btn btn-secondary" data-toggle="modal" data-target="#registerModal">Sign Up</button>
      @endif

    </div>
  </nav>
  @yield('content')
  <footer class="container-fluid py-2 footer">
    <div class="container d-flex justify-content-center">
      <div class="row workpad-copyright">
        workpad &copy; 2019
      </div>
    </div>
    <div class="container d-flex justify-content-center">
      <div class="row">
        <a class="mr-3 footer-link" href="{{ url('/info') }}#about">About</a>
        <a class="mr-3 footer-link" href="{{ url('/info') }}#help">Help</a>
        <a class="footer-link" href="{{ url('/info') }}#contact">Contact</a>
      </div>
    </div>
  </footer>

</body>

</html>
