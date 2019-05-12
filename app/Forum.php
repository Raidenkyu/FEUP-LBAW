<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{

    protected $table = 'forum';
    protected $primaryKey = 'id_forum';
    // protected $fillable = [''];
    public $timestamps = false;

    public function project(){
      return $this->belongsTo('App\Project', 'id_project');
    }

    public function comments(){
        return $this->hasMany('App\ForumComment', 'id_forum_comment');
    }
}
