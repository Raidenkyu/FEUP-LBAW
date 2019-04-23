<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    //

    protected $table = 'member';
    protected $primaryKey = 'id_member';
    protected $fillable = ['name', 'username', 'email', 'id_member'];
    public $timestamps = false;
}
