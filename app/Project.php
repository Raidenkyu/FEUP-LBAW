<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //

    protected $table = 'project';
    protected $primaryKey = 'id_project';

    public function members() {
      return $this->belongsToMany('App\Member');
    }
}
