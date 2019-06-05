<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    //

    public function index(){

        if (!Auth::check()) return redirect('/');

        $id_member = Auth::user()->id_member;

        $notifications = \App\Notification::getNotifications($id_member);

        return $notifications;
    }
}
