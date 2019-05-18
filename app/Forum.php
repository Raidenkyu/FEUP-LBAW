<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class Forum extends Model
{

    protected $table = 'forum';
    protected $primaryKey = 'id_forum';
    protected $fillable = ['id_project', 'topic'];
    public $timestamps = false;

    public function project(){
      return $this->belongsTo('App\Project', 'id_project');
    }

    public function comments(){
        return $this->hasMany('App\ForumComment', 'id_forum');
    }

    public function addComment($content){
      return ForumComment::create([
        'id_member' => Auth::user()->id_member,
        'id_forum' => $this->id_forum,
        'content' => $content,
        'date' => Carbon::now()
      ]);
    }
}
