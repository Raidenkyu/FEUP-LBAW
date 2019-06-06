<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{

  protected $table = 'forum_comment';
  protected $primaryKey = 'id_forum_comment';
  protected $fillable = ['id_member', 'id_forum', 'content'];
  public $timestamps = false;

  public function forum()
  {
    return $this->belongsTo('App\Forum', 'id_forum');
  }

  public function member()
  {
    return $this->belongsTo('App\Member', 'id_member');
  }
}
