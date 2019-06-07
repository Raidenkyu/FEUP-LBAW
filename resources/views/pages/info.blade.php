@extends('layouts.layout')

@section('title','Help Page')

@section('content')

<link rel="stylesheet" href="css/info.css">

<div class="page-content container mt-5">

  <h1 class="text-center">workpad</h1>

  <div class="row mt-1 px-5 justify-content-center">
    <div class="row flex-row">
      <div class="about col-lg-6 col-xs-12 flex text-center mt-5">
        <h3 id="about">About Us</h3>
        <div class="text-left py-4">
          <h6 class="about-text py-2 m-0">We are a team of students, aiming to create a platform for
            all teams from all over the world. Uniting developers and giving them an instrument to take 
          their projects to the next level is our motto. We hope to continue to extend our platform to everyone
        who seeks the best for their projects. Expect our best efforts to evolve our functionalities over time
      to ensure the best experience to our users. Thank you for sticking with us on this adventure!</h6>
        </div>
      </div>
      <div class="col-lg-6 col-xs-12 flex mt-5 justify-content-center">
        <div class="about col-12 text-center">
          <h3 id="contact">Contact</h3>
        </div>
        <div class="py-4 text-center">

          <form class="p-0 justify-content-center">

            <div class="form-group input-group-lg py-1">
              <input class="border rounded form-control" placeholder="Name" type="text">
            </div>

            <div class="form-group input-group-lg py-1">
              <input class="border rounded form-control" placeholder="Email" type="email">
            </div>

            <div class="form-group input-group-lg py-1">
              <textarea class="border rounded form-control" placeholder="Message"></textarea>
            </div>
            <button type="button" class="btn btn-lg btn-block btn-primary">Submit</button>
          </form>
        </div>

      </div>
    </div>

    <div class="row mt-5">
      <div class="about col-12 text-center">
        <h3 id="help">FAQ</h3>
      </div>

      <div class="container faq p-5">
        <div class="question card px-3" data-toggle="collapse" href="#collapseAnswer" role="button"
          aria-expanded="false" aria-controls="collapseAnswer">
          <h6>How can I access all my projects?</h6>
        </div>
        <div id="collapseAnswer" class="card answer collapse px-3">
          <h6>By accessing the Dashboard Icon (2nd Icon) on the Top Navigation Bar, you can access your personal
            dashboard, which contains all your projects: the ones you own, and the ones that you participate in.</h6>
        </div>
      </div>

      <div class="container faq p-5">
          <div class="question card px-3" data-toggle="collapse" href="#collapseAnswer2" role="button"
            aria-expanded="false" aria-controls="collapseAnswer2">
            <h6>How can I access my notifications?</h6>
          </div>
          <div id="collapseAnswer2" class="card answer collapse px-3">
            <h6>By accessing the Notification Icon (1st Icon) on the Top Navigation Bar, you can access your notifications, which include
              invitations to projects or tasks from the projects you already participate in.</h6>
          </div>
      </div>

      <div class="container faq p-5">
          <div class="question card px-3" data-toggle="collapse" href="#collapseAnswer3" role="button"
            aria-expanded="false" aria-controls="collapseAnswer3">
            <h6>How can I access my Profile?</h6>
          </div>
          <div id="collapseAnswer3" class="card answer collapse px-3">
            <h6>By clicking your username OR your profile image, on the Top Navigation Bar, you can access your profile page, where you can
              see your informations and edit your profile.</h6>
          </div>
      </div>

    </div>

    <div class="row py-4 text-center">
      <div class="about col-12 text-center">
        <h3 id="team">Team</h3>
      </div>
      <div class="devs-pics row my-3">
        <div class="col">
          <img class="rounded-circle border" src="./images/claudio.jpg" style="width:100px;" alt="Responsive image">
          <h6 class="pt-3">Cláudio Lemos</h6>
        </div>
        <div class="col">
          <img class="rounded-circle border" src="./images/fernando.jpg" style="width:100px;" alt="Responsive image">
          <h6 class="pt-3">Fernando Alves</h6>
        </div>
        <div class="col">
          <img class="rounded-circle border" src="./images/joao.jpg" style="width:100px;" alt="Responsive image">
          <h6 class="pt-3">João Carlos Maduro</h6>
        </div>
        <div class="col">
          <img class="rounded-circle border" src="./images/pedro.jpg" style="width:100px;" alt="Responsive image">
          <h6 class="pt-3">Pedro Gonçalves</h6>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection