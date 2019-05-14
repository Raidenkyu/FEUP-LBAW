<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ForumsController extends Controller
{
  public function store($id){
    request()->validate(['topic' => 'required']);
    $forum = \App\Project::find($id)->addForum(request('topic'));
    return redirect('/projects/' . $id . '/forums/' . $forum->id_forum);
  }

  public function forums($id){
    if (!Auth::check()) return redirect('/');
    $forums = \App\Project::find($id)->forums;
    return view('pages.forums', compact('forums'));
  }

  public function forum($id, $forum_id){
    if (!Auth::check()) return redirect('/');
    $forums = \App\Project::find($id)->forums;
    $selectedForum = \App\Project::find($id)->forums->find($forum_id);
    return view('pages.forum', compact('forums', 'selectedForum'));
  }
}
