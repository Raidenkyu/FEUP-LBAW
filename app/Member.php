<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
  //

  protected $table = 'member';
  protected $primaryKey = 'id_member';
  protected $fillable = ['name', 'username', 'email', 'id_member', 'banned', 'deleted'];
  public $timestamps = false;


  public function projects()
  {
    return $this->belongsToMany('App\Project', 'project_member', 'id_member', 'id_project')->where('deleted',false);
  }

  public function my_projects()
  {
    return $this->belongsToMany('App\Project', 'project_member', 'id_member', 'id_project')->wherePivot('manager', 'true')->where('deleted',false);
  }

  public function forum_comments()
  {
    return $this->hasMany('App\ForumComment', 'id_member');
  }
}
