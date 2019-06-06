<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table = 'notification';
    protected $primaryKey = 'id_notification';
    // protected $fillable = ['name', 'username', 'email', 'id_member'];
    public $timestamps = false;

    public static function getNotifications($id_member)
    {
        $notifications = Notification::where('id_member', $id_member)->get();
        return $notifications;
    }

    public static function existsNotifications($user)
    {
        if (!Auth::check()) return redirect('/');
        return Notification::where('id_member', $user->id_member)->exists();
    }
}
