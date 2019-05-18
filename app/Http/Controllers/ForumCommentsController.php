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
}
