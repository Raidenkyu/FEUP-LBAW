<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = \App\Member::all();
        $projects = \App\Project::all();

        return view('pages.admin', [
            'users' => $users,
            'projects' => $projects,
        ]);
    }

    public function ban($id_user)
    { 
        $user = \App\Member::find($id_user);
        $user->banned = true;
        $user->save();
        return $user;
    }

    public function unban($id_user)
    { 
        $user = \App\Member::find($id_user);
        $user->banned = false;
        $user->save();
        return $user;
    }

    public function deleteProject($id_project)
    { 
        $project = \App\Project::find($id_project);
        $project->deleted = true;
        $project->save();
        return $project;
    }

    public function restoreProject($id_project)
    { 
        $project = \App\Project::find($id_project);
        $project->deleted = false;
        $project->save();
        return $project;
    }
}
