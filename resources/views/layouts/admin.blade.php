<!DOCTYPE html>
<html lang="en">

<head>
  <title>@yield('title','workpad')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet href="{{ asset('/css/roboto.css') }}">
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



</head>

<body>

  <nav class="navbar navbar-dark shadow-sm sticky-top">
    <div id="logo" class="logo-container mr-auto">
      <a href="./index.html"><img src="./icons/logo.png" style="width:50px;" alt="Workpad logo"></a>
    </div>

    <div id="sign" class="login-container">
      <a href="./admin_login.html"><button class="btn btn-secondary">Log out</button></a>
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
        <a class="mr-3 footer-link" href="./info.html#about">About</a>
        <a class="mr-3 footer-link" href="./info.html#help">Help</a>
        <a class="footer-link" href="./info.html#contact">Contact</a>
      </div>
    </div>
  </footer>

</body>

</html>
