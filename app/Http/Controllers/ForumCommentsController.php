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

  public function delete($id_project, $id_forum, $id_forum_comment){
    return \App\ForumComment::find($id_forum_comment)->delete();
    return $id_forum_comment;
  }
}
