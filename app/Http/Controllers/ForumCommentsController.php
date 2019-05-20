<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ForumCommentsController extends Controller
{
  public function store($id_project, $id_forum){
    request()->validate(['content' => 'required']);
    return \App\Forum::find($id_forum)->addComment(request('content'));
  }

  public function destroy($id_project, $id_forum, $id_forum_comment){
    \App\ForumComment::find($id_forum_comment)->delete();
    return $id_forum_comment;
  }

  public function update($id_project, $id_forum, $id_forum_comment){
    request()->validate(['content' => 'required']);
    \App\ForumComment::find($id_forum_comment)->update(['content' => request('content')]);
    return back();
  }
}
