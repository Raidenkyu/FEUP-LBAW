<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //

    public function index(){

        if (!Auth::check()) return redirect('/');

        $user = (\App\Member::where('id_member',Auth::user()->id_member)->get())[0];

        //return $projects;
        return view('pages.profile', ['user' => $user]);
    }
}
