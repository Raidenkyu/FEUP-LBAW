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
          <h6 class="about-text py-2 m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod
            tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
            ullamco
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
            voluptate velit
            esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
            sunt in culpa
            qui officia deserunt mollit anim id est laborum.</h6>
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
          <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex
            ea commodo consequat.</h6>
        </div>
        <div id="collapseAnswer" class="card answer collapse px-3">
          <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex
            ea commodo consequat.</h6>
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