@extends('layouts.layout')

@section('title','Homepage')

@section('content')
<!-- Sign In Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="ModalLabel">Log in</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-0">
        <form id="login-form" class="p-0 justify-content-center" method="POST" action="/login">
          {{ csrf_field() }}

          <div class="form-group input-group-lg py-1">
            <input id="email" type="email" name="email"
              class="border rounded form-control {{ $errors->has('email') ? 'border-danger' : '' }}" placeholder="Email"
              value="{{ old('email') }}" required>
          </div>

          <div class="form-group input-group-lg py-1">
            <input id="password" type="password" name="password"
              class="border rounded form-control {{ $errors->has('password') ? 'border-danger' : '' }}"
              placeholder="Password" type="password" required>
          </div>

        </form>

        @if ($errors->any())
        <div class="errors alert alert-danger pb-1">
          <h5>Errors:</h5>
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

      </div>
      <div class="modal-footer pt-0 pl-0">
        <div class="col">
          <div class="row">
            <div class="col-6">
              <button type="submit" form="login-form" class="btn btn-lg btn-primary">
                Sign In
              </button>
            </div>
            <div class="col-6 text-right pr-0">
              <button class="btn ">Forgot Password?</button>
            </div>

          </div>
          <div class="register-callout mt-3 pt-1">
            Need an account? <button class="btn pl-1 pt-0" data-dismiss="modal" aria-label="Close" data-toggle="modal"
              data-target="#registerModal">Sign up now!</button>
          </div>


        </div>


      </div>
    </div>
  </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="ModalLabel2">Create a workpad account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-0">
        <form id="register-form" class="p-0 justify-content-center" method="POST" action="/register">
          {{ csrf_field() }}

          <div class="form-group input-group-lg py-1">
            <input id="username" type="text" name="username"
              class="border rounded form-control {{ $errors->has('username') ? 'border-danger' : '' }}"
              placeholder="Username" value="{{ old('username') }}" required>
          </div>
          <div class="form-group input-group-lg py-1">
            <input id="name" type="text" name="name"
              class="border rounded form-control {{ $errors->has('name') ? 'border-danger' : '' }}" placeholder="Name"
              value="{{ old('name') }}" required>
          </div>
          <div class="form-group input-group-lg py-1">
            <input id="email2" type="email" name="email"
              class="border rounded form-control {{ $errors->has('email') ? 'border-danger' : '' }}" placeholder="Email"
              value="{{ old('email') }}" required>
          </div>

          <div class="form-group input-group-lg py-1">
            <input id="password2" type="password" name="password"
              class="border rounded form-control {{ $errors->has('password') ? 'border-danger' : '' }}"
              placeholder="Password" required>
          </div>

          <div class="form-group input-group-lg py-1">
            <input id="password-confirm" type="password" name="password_confirmation"
              class="border rounded form-control {{ $errors->has('password_confirmation') ? 'border-danger' : '' }}"
              placeholder="Confirm password" required>
          </div>

          <!--<input name="is-reg" hidden>-->
        </form>

        @if ($errors->any())
        <div class="errors alert alert-danger pb-1">
          <h5>Errors:</h5>
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif


      </div>
      <div class="modal-footer pt-0 pl-0">
        <div class="col">
          <div class="row">
            <div class="col-6">
              <button type="submit" form="register-form" class="btn btn-lg btn-primary">
                Create account
              </button>
            </div>

          </div>
          <div class="register-callout mt-3 pt-1">
            Already have an account? <button class="btn pl-1 pt-0" data-dismiss="modal" aria-label="Close"
              data-toggle="modal" data-target="#loginModal">Sign in now!</button>
          </div>


        </div>


      </div>
    </div>
  </div>
</div>


<div class="container mt-5">
  <div class="row">
    <div class="col-12 mr-auto logo-container">
      <img class="workpad-logo" src="./icons/home-logo.png" alt="Workpad Logo">
    </div>
  </div>

  <div class="row mt-5">
    <div class="motivation col-12 text-center">
      <h4>We are an online project management platform where you can manage and discuss the progress of all your
        projects
        with other team members. Our platform helps you manage the projects you are involved in, in a way that
        increases
        your efficiency and promotes your cooperation with the team.</h4>
    </div>
  </div>

</div>


<div class="container py-5 mt-5">
  <div class="row second-section">
    <div class="col-sm align-self-center">
      <div class="row px-5 second-container">
        <h1 class="font-weight-bold">Work with your team. Anywhere!</h1>
      </div>
      <div class="row motivation px-5 py-5 second-container">
        <h4>Whether it’s for work, a side project, workpad helps your development team stay organized. Dive into the
          details by adding comments, attachments, due dates, and more directly to workpad cards. Collaborate on
          projects from beginning to end.</h4>
      </div>
    </div>
    <div class="col-sm align-self-center">
      <img class="workpad-homepage" src="./images/homepage1.png" alt="Workpad Logo">
    </div>
  </div>
</div>

</div>



@endsection