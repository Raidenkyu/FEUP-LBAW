<!DOCTYPE html>
<html lang="en">

<head>
  <title>@yield('title','workpad')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC|Roboto:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
  <script type="text/javascript">
    // Fix for Firefox autofocus CSS bug
    // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
  </script>
  <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.slim.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>



</head>

<body>

  <nav class="navbar navbar-dark navbar-right shadow-sm sticky-top">
    <div id="logo" class="logo-container mr-auto">
      <a href="./index.html"><img src="./icons/logo.png" style="width:50px;" alt="Responsive image"></a>
    </div>

    <div id="sign" class="login-container">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Log In</button>
      <button class="btn btn-secondary" data-toggle="modal" data-target="#registerModal">Sign Up</button>
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