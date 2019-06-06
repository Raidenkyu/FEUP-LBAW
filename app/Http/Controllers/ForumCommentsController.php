<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ForumCommentsController extends Controller
{
  public function store($id_project, $id_forum)
  {
    request()->validate(['content' => 'required']);
    return \App\Forum::find($id_forum)->addComment(request('content'));
  }

  public function destroy($id_project, $id_forum, $id_forum_comment)
  {
    $comment = \App\ForumComment::find($id_forum_comment);
    if (Auth::user()->id_member == $comment->id_member) {
      $comment->delete();
      return $id_forum_comment;
    } else return back();
  }

  public function update($id_project, $id_forum, $id_forum_comment)
  {
    request()->validate(['content' => 'required']);
    $comment = \App\ForumComment::find($id_forum_comment);
    if (Auth::user()->id_member == $comment->id_member) {
      $comment->update(['content' => request('content')]);
      return response()->json(['id' => $id_forum_comment, 'content' => request('content')]);
    } else return back();
  }
}
