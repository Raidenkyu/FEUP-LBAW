<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    //

    protected $table = 'invite';
    protected $primaryKey = 'id_invite';
    public $timestamps = false;
}
