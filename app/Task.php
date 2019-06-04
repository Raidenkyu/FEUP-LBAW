<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\SubTask as SubTask;

class Task extends Model
{
    //

    protected $table = 'task';
    protected $primaryKey = 'id_task';

    protected $fillable = ['id_project', 'name', 'list_name'];
    public $timestamps = false;

    public function checklist()
    {
        return $this->hasMany(SubTask::class, 'id_task')->get();
    }

    public function checklistIds()
    {
        return $this->hasMany(SubTask::class, 'id_task')->get('id_subtask');
    }

    public function members()
    {
        return $this->belongsToMany('App\Member', 'assigned_to', 'id_member', 'id_task')->get();
    }
}
