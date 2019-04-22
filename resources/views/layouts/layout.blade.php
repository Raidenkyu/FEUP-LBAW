<!DOCTYPE html>
<html lang="en">

<head>
  <title>workpad</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC|Roboto:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="./../../../html/css/bootstrap.min.css">
  <link rel="stylesheet" href="./../../../html/css/forum_project.css">
  <script src="./../../../html/js/jquery-3.2.1.slim.min.js"></script>
  <script src="./../../../html/js/bootstrap.bundle.min.js"></script>
  <script src="./../../../html/js/bootstrap.min.js"></script>
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
