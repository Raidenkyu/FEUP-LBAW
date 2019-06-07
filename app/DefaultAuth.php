<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\LarashopResetPassword as LarashopResetPassword;

class DefaultAuth extends Authenticatable
{

    use Notifiable;
    //

    protected $table = 'default_auth';
    protected $primaryKey = 'id_member';
    protected $fillable = ['id_member', 'email', 'password'];
    public $timestamps = false;

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new LarashopResetPassword($token));
    }
}
