<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //

    public function index()
    {

        if (!Auth::check()) return redirect('/');

        $user = (\App\Member::where('id_member', Auth::user()->id_member)->get())[0];

        //return $projects;
        return view('pages.profile', ['user' => $user]);
    }


    public function edit()
    {
        if (!Auth::check()) return redirect('/');

        $user = (\App\Member::where('id_member', Auth::user()->id_member)->get())[0];

        return view('pages.edit_profile', ['user' => $user]);
    }

    public function update()
    {
        if (!Auth::check()) return redirect('/');

        $user = (\App\Member::where('id_member', Auth::user()->id_member)->get())[0];

        if ($user->name != request('name') && request('name') != "") {
            $user->name = request('name');
        }

        if ($user->location != request('location') && request('location') != "") {
            $user->location = request('location');
        }

        if ($user->phone_number != request('phone') && request('phone') > 0 && request('phone') < 1000000000) {
            $user->phone_number = request('phone');
        }

        if ($user->about != request('brief') && request('brief') != "") {
            $user->about = request('brief');
        }

        if ($user->description != request('description') && request('description') != "") {
            $user->description = request('description');
        }

        $user->save();
        return view('pages.profile', ['user' => $user]);
    }
}
