<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    //

    public function index(){

        if (!Auth::check()) return redirect('/');

        $id_member = Auth::user()->id_member;

        Notifications::getNotifications($id_member);


    }
}
