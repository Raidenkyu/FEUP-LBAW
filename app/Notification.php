<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //

    protected $table = 'project_member';
    protected $primaryKey = ['id_member', 'id_project'];
    // protected $fillable = ['name', 'username', 'email', 'id_member'];
    public $timestamps = false;
    public $incrementing = false;

    public static function getDevs($id_project){
        $devs = ProjectMember::where([
            ['id_project', '=', $id_project],
            ['manager', '=', 'false']
        ])->get();
        return $devs;
    }

}
