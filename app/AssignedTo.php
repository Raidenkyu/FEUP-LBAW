<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedTo extends Model
{

    protected $table = 'assigned_to';
    protected $primaryKey = 'id_mem_task';
    protected $fillable = ['id_member', 'id_task'];
    public $timestamps = false;
}
