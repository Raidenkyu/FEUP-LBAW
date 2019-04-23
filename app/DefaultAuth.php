<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultAuth extends Model
{
    //

    protected $table = 'default_auth';
    protected $primaryKey = 'id_member';
    protected $fillable = ['id_member', 'password'];
    public $timestamps = false;
}
