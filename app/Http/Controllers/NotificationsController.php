<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use App\ProjectMember;

class NotificationsController extends Controller
{
    //

    public function index()
    {
        if (!Auth::check()) return redirect('/');
        $id_member = Auth::user()->id_member;
        $notifications = \App\Notification::getNotifications($id_member);
        $proj_names = [];

        foreach ($notifications as $notify) {
            $id_proj = $notify->id_project;
            if ($id_proj == null) {
                array_push($proj_names, null);
            } else {
                $project = \App\Project::find($id_proj);
                array_push($proj_names, $project->name);
            }
        }

        return ['notifications' => $notifications, 'names' => $proj_names];
    }

    public function destroy($id_notify)
    {

        $notification = Notification::find($id_notify);

        if ($notification->id_member != Auth::user()->id_member) {
            return redirect('/');
            //TODO: maybe send error
        }

        $notification->delete();

        return Notification::where('id_member', $notification->id_member)->count();
    }

    public function interact($id_notify)
    {

        $notification = Notification::find($id_notify);

        if ($notification->id_member != Auth::user()->id_member) {
            return redirect('/');
            //TODO: maybe send error
        }

        //get Invite entry
        $invite = \App\Invite::where([
            ['id_member', '=', $notification->id_member],
            ['id_project', '=', $notification->id_project]
        ])->get()[0];

        //if accept, create ProjectMember
        if (request('action') == "accept") {
            $projMember = new ProjectMember();
            $projMember->id_member = $invite->id_member;
            $projMember->id_project = $invite->id_project;
            $projMember->manager = $invite->manager;
            $projMember->save();
        }

        //delete the notification and the invite
        //TODO: delete invite, not necessary but would be nice
        $notification->delete();

        return Notification::where('id_member', $notification->id_member)->count();
    }
}
