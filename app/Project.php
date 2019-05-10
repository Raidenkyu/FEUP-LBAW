<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //

    protected $table = 'project';
    protected $primaryKey = 'id_project';
    protected $fillable = ['name', 'color', 'end_date', 'deleted'];
    public $timestamps = false;

    public function members() {
      return $this->belongsToMany('App\Member');
    }
}
