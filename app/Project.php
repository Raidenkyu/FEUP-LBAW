<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'project';
    protected $primaryKey = 'id_project';

    public function forums(){
        return $this->hasMany('App\Forum', 'id_project');
    }

    public function addForum($topic){
      return Forum::create([
        'id_project' => $this->id_project,
        'topic' => $topic
      ]);
    }
}
