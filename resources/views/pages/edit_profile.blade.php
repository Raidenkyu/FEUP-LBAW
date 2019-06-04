@extends('layouts.layout')

@section('title', 'Edit Profile')

@section('content')

<link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">

<div class="page-content">
    <div class="edit-block container d-flex">
        <div class="col">
            <div class="row py-4">
                <h1 class="register-title font-weight-bolder text-center">Edit Profile</h1>
            </div>

            <form id="edit-profile-form" class="p-0 w-100" method="POST" action="/profile" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="row flex-row">
                    <div class="input-body col-lg-7 col-xs-12 px-0 mx-0">
                        <div class="form-group input-group-lg py-1">
                            <label>Name</label>
                            <input class="border rounded form-control" name="name" value="{{$user->name}}" placeholder="Name">
                        </div>

                        <div class="row pl-0">
                            <div class="form-group input-group-lg py-1 col-6">
                                <label>Location</label>
                                <input class="border rounded form-control" name="location" value="{{$user->location}}" placeholder="Location">
                            </div>

                            <div class="form-group input-group-lg py-1 col-6">
                                <label>Phone</label>
                                <input class="border rounded form-control" name="phone" value="{{$user->phone_number}}" placeholder="Phone Number">
                            </div>
                        </div>


                        <div class="form-group input-group-lg py-1">
                            <label>Brief</label>
                            <input class="border rounded form-control" name="brief" value="{{$user->about}}" placeholder="Brief">
                        </div>

                        <div class="form-group input-group-lg py-1">
                            <label>Descritption</label>
                            <textarea class="border rounded form-control" name="description" placeholder="Description" cols="10" rows="5" style="resize: none;">
                            {{$user->description}}
                            </textarea>
                        </div>


                    </div>
                    <div class="form-second-col col-lg-5 col-xs-12">
                        <div class="row justify-content-center pt-5">
                            <div class="profile-image col-lg-3 col-lg-pull justify-content-center">
                                <label>Picture</label><br>
                                <img class="image-canvas rounded-circle align-self-center" alt="Responsive image" src="{{asset(\App\Http\Controllers\ImageController::getImage($user->id_member))}}">
                            </div>
                        </div>


                        <div class="form-group center-block pl-5 mx-auto mt-2">
                            <div class="row justify-content-center">
                                <input type="file" name="image">
                            </div>

                        </div>

                        <div class=" form-group center-block mx-auto pt-5 mt-5">
                            <div class="row justify-content-center">
                                <button class="btn btn-lg btn-primary login-btn" type="submit" form="edit-profile-form">
                                    Save Changes
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>


        </div>

    </div>

</div>


@endsection