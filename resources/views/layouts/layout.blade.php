<!DOCTYPE html>
<html lang="en">

<head>
  <title>workpad</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC|Roboto:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/forum_project.css') }}">
  <script type="text/javascript">
    // Fix for Firefox autofocus CSS bug
    // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
</script>
  <script type="text/html" src={{ asset('js/jquery-3.2.1.slim.min.js') }}></script>
  
  <!--<script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  -->
  
  <script src={{ asset('js/bootstrap.bundle.min.js') }} ></script>
  <script src={{ asset('js/bootstrap.min.js') }} ></script>


</head>

<body>

  <nav class="navbar navbar-dark shadow-sm sticky-top">
    <div id="logo" class="logo-container mr-auto">
      <a href="./index.html"><img src="./icons/logo.png" style="width:50px;"</a>
    </div>

    <div id="sign" class="login-container">
      <a href="./create_project.html"><img src="./icons/create_project.svg" style="width:35px;"
          alt="Responsive image"></a>
      <img src="./icons/notification_center.svg" style="width:35px;" alt="Responsive image">
      <a href="./profile_page.html"><span style="color:white;">claudiolemos</span></a>
      <a href="./profile_page.html"><img src="./images/claudio.jpg" class="rounded-circle" style="width:35px;"</a>
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
