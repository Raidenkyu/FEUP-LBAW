<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ForumsController extends Controller
{
  public function store($id)
  {
    request()->validate(['topic' => 'required']);
    return \App\Project::find($id)->addForum(request('topic'));
  }

  public function forums($id)
  {
    if (!Auth::check()) return redirect('/');
    $forums = \App\Project::find($id)->forums;
    $isManager = \App\ProjectMember::isManager(Auth::user()->id_member, $id);
    $project = \App\Project::where('id_project', $id)->first();

    return view('pages.forums', compact('forums', 'isManager', 'project'));
  }

  public function forum($id, $forum_id)
  {
    if (!Auth::check()) return redirect('/');
    $forums = \App\Project::find($id)->forums;
    $selectedForum = \App\Project::find($id)->forums->find($forum_id);
    $isManager = \App\ProjectMember::isManager(Auth::user()->id_member, $id);
    $project = \App\Project::where('id_project', $id)->first();

    return view('pages.forum', compact('forums', 'selectedForum', 'isManager', 'project'));
  }
}
