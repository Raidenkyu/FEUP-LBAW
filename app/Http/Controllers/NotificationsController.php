<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use App\ProjectMember;

class NotificationsController extends Controller
{
    //

    public function index(){

        if (!Auth::check()) return redirect('/');

        $id_member = Auth::user()->id_member;

        $notifications = \App\Notification::getNotifications($id_member);

        $proj_names = [];

        foreach($notifications as $notify){
            $id_proj = $notify->id_project;
            if($id_proj == null){
                array_push($proj_names, null);
            }
            else{
                $project = \App\Project::find($id_proj);
                array_push($proj_names, $project->name);
            }
            
        }

        return ['notifications' => $notifications, 'names' => $proj_names];
    }

    public function destroy($id_notify){

        $notification = Notification::find($id_notify);

        if($notification->id_member != Auth::user()->id_member){
            return redirect('/');
            //TODO: maybe send error
        }
         
        $notification->delete();
    }

    public function refuse($id_notify){

        $notification = Notification::find($id_notify);

        if($notification->id_member != Auth::user()->id_member){
            return redirect('/');
            //TODO: maybe send error
        }
        
        //delete ProjectMember entry
        ProjectMember::where([
            ['id_member', '=', $notification->id_member],
            ['id_project', '=', $notification->id_project]
        ])->delete();

        $notification->delete();
    }
}
