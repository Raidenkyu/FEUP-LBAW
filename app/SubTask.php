<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    protected $table = 'subtask';
    protected $primaryKey = 'id_subtask';


    protected $fillable = ['id_task', 'brief'];
    public $timestamps = false;
}
