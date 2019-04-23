<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //

    protected $table = 'member';
    protected $primaryKey = 'id_member';
    protected $fillable = ['name', 'username', 'email', 'id_member'];
    public $timestamps = false;
}
