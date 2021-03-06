@extends('layouts.admin')

@section('title', 'Reset Password')

@section('content')

<link rel="stylesheet" href="{{asset('css/admin.css')}}">

<div class="page-container">
    <div class="d-flex justify-content-center pt-5">
        <img class="img-fluid workpad-logo" src="{{asset('/icons/home-logo.png')}}" alt="Workpad Logo">
    </div>

    <div class="py-2 pb-5">
        <div class="login-block container mt-5 w-50 d-flex bg-white rounded">
            <div class="col">
                <div class="row py-4 justify-content-center">
                    <h1 class="register-title font-weight-bolder text-center">Reset Password</h1>
                </div>


                <div class="row justify-content-center">
                    <form class="p-0" method="POST" action="/password/reset">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group input-group-lg py-1">
                            <input class="border rounded form-control justify-content-start" name="email"
                                placeholder="E-mail" type="email">
                        </div>

                        <div class="form-group input-group-lg py-1">
                            <input class="border rounded form-control" name="password" placeholder="Password"
                                type="password">
                        </div>

                        <div class="form-group input-group-lg py-1">
                            <input class="border rounded form-control" name="password_confirmation" placeholder="Confirm Password"
                                type="password">
                        </div>

                        <div class="form-group center-block mx-auto py-1">
                            <div class="row mx-0">
                                <button type="submit" value="Submit"
                                    class="btn btn-lg btn-block btn-primary login-btn">Reset Password</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection