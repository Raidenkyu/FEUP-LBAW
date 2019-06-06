<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    //

    public function index()
    {

        if (!Auth::check()) return redirect('/');

        $user = (\App\Member::where('id_member', Auth::user()->id_member)->get())[0];

        //return $projects;
        return view('pages.profile', ['user' => $user, 'canEdit' => true]);
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

        if (request()->image != null) {
            request()->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $matchingFiles = glob('images/profiles/' . $user->id_member . '.*');

            if (count($matchingFiles) > 0) {
                File::delete($matchingFiles[0]);
            }

            $extension = request()->image->getClientOriginalExtension();
            $imageName = $user->id_member . '.'  . $extension;

            request()->image->move(public_path('images/profiles'), $imageName);
            \App\Http\Controllers\ImageController::resizeImage($imageName, $extension);
        }



        $user->save();
        return view('pages.profile', ['user' => $user, 'canEdit' => true]);
    }

    public function show($id_member)
    {

        if (!Auth::check()) return redirect('/');

        $canEdit = false;

        if (Auth::user()->id_member == $id_member) {
            $canEdit = true;
        }

        $user = \App\Member::find($id_member);

        //return $projects;
        return view('pages.profile', ['user' => $user, 'canEdit' => $canEdit]);
    }

    public function delete($id_member)
    {
        if (!Auth::check()) return redirect('/');

        if (Auth::user()->id_member == $id_member) {
            $user = \App\Member::find($id_member);
            $user->deleted = true;
            $user->save();
        }

        return redirect('/');
    }
}
