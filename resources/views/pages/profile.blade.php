@extends('layouts.layout')

@section('title', 'Profile')

@section('content')

<link rel="stylesheet" href="css/profile.css">

<div class="page-content">

    <div class="profile-strap container">
      <div class="row justify-content-center">
        <img src="./icons/profile_strap.svg" alt="Responsive image">
      </div>
    </div>


    <div class="row profile-area mt-5 p-3 align-self-center">
      <div class="profile-strap-space row container align-self-center"></div>
      <div class="profile-header row container align-self-center">
        <div class="profile-image col-lg-3 col-lg-pull">
          <img class="image-canvas rounded-circle align-self-center" alt="Responsive image"
            src="images/claudio.jpg">
        </div>
        <div class="profile-info col-lg-8 col-lg-push align-self-center">
          <div class="col">
            <div class="profile-title align-self-center">
              <p>{{ $user->name }}</p>
            </div>


            <div class="row">
              <div class="col-lg-10">
                <div class="row profile-tag-location align-self-center">
                  <div class="profile-tag col col-lg-push">
                    <p><img class="profile-icon" src="./icons/at.svg" alt="Responsive image">{{ $user->username }}</p>
                  </div>
                  <div class="profile-location col col-lg-push">
                    <p><img class="profile-icon" src="./icons/location_pin.svg" alt="Responsive image">{{ $user->location }}
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-lg-10">
                <div class="row profile-tag-location align-self-center">
                  <div class="profile-tag col col-lg-push">
                    <p><img class="profile-icon" src="./icons/mail.svg" alt="Responsive image">{{ $user->email }}</p>
                  </div>
                  <div class="profile-location col col-lg-push">
                    <p><img class="profile-icon" src="./icons/phone.svg" alt="Responsive image">{{ $user->phone_number }}</p>
                  </div>
                </div>
              </div>
            </div>



            <div class="row">
              <div class="profile-brief col-12">
                <h6>{{ $user->about }}</h6>
              </div>

            </div>


          </div>


        </div>
      </div>
      <div class="profile-text row col-12 text-left pl-5 pt-3">
        <h6>{{ $user->description }}</h6>
      </div>

    </div>
  </div>


@endsection
