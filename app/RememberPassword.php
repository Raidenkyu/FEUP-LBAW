<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RememberPassword extends Model
{
    protected $table = 'remember_password';
    protected $primaryKey = 'email';
    protected $fillable = ['email', 'token', 'created_to'];
    public $timestamps = false;
}
