<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DefaultAuth extends Authenticatable
{
    //

    protected $table = 'default_auth';
    protected $primaryKey = 'id_member';
    protected $fillable = ['id_member', 'email', 'password'];
    public $timestamps = false;
}
