<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //

    public function index(){
        $user = \App\Member::first(); //TODO - Change to Auth()

        //return $projects;
        return view('pages.profile', ['user' => $user]);
    }
}
