<!DOCTYPE html>
<html lang="en">

<head>
  <title>@yield('title','workpad')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('/css/roboto.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/index.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/footer.css') }}">
  <script type="text/javascript">
    // Fix for Firefox autofocus CSS bug
    // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
  </script>
  <script type="text/javascript" src="{{ asset('/js/jquery-3.2.1.slim.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/navbar.js') }}" defer></script>

</head>

<body>

  <nav class="navbar navbar-dark navbar-right shadow-sm sticky-top">
    <div id="logo" class="logo-container mr-auto">
      <a href="{{ url('/') }}"><img src="/icons/logo.png" style="width:50px;" alt="Responsive image"></a>
    </div>

    <div id="sign" class="login-container">
      @if (Auth::check())
      <div class="btn-group">
        <button id="notification-icon" type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split px-0" data-toggle="dropdown">
          @if (\App\Notification::existsNotifications(Auth::user()))
            <img src="/icons/ban.svg" class="mx-1" style="width:45px" alt="There are notifications">
          @else
            <img src="/icons/notification_center.svg" class="mx-1" style="width:45px" alt="No notifications">
          @endif
        </button>
        <div class="dropdown-menu container" style="width: 420px">
          <div class="notify-box"><a class="dropdown-item" href="#">Link 1</a></div>
          <div class="notify-box"><a class="dropdown-item" href="#">Link 2</a></div>
        </div>
      </div> 
      <a href="{{ url('/projects') }}"><img src="/icons/due_date.svg" class="mx-1" style="width:45px" alt="Responsive image"></a>
      <a href="{{ url('/projects/new') }}"><img src="/icons/create_project.svg" class="mx-1" style="width:45px" alt="Responsive image"></a>
      <a href="{{ url('/profile') }}"><img src="{{asset(\App\Http\Controllers\ImageController::getImage(Auth::user()->id_member))}}" class="rounded-circle mx-2" style="width:35px;" alt="Responsive image"></a>
      <a href="{{ url('/profile') }}"><span style="color:white; margin-right:7px">{{ (\App\Member::where('id_member',Auth::user()->id_member)->get())[0]->name }}</span></a>
      <button class="button btn btn-secondary">
        <a class="button" href="{{ url('/logout') }}"> Logout </a>
      </button>
      @else
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
        <a class="mr-3 footer-link" href="/info.html#about">About</a>
        <a class="mr-3 footer-link" href="/info.html#help">Help</a>
        <a class="footer-link" href="/info.html#contact">Contact</a>
      </div>
    </div>
  </footer>

</body>

</html>