<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    //

    protected $table = 'project_member';
    protected $primaryKey = ['id_member', 'id_project'];
    // protected $fillable = ['name', 'username', 'email', 'id_member'];
    public $timestamps = false;
    public $incrementing = false;

    public static function isManager($id_member, $id_project){
        $relation = ProjectMember::where([
            ['id_member', '=', $id_member],
            ['id_project', '=', $id_project],
            ['manager', '=', 'true']
        ])->exists();
        return $relation;
    }

    public static function getDevs($id_project){
        $devs = ProjectMember::where([
            ['id_project', '=', $id_project],
            ['manager', '=', 'false']
        ])->get();
        return $devs;
    }

    public static function getManagers($id_project){
        $devs = ProjectMember::where([
            ['id_project', '=', $id_project],
            ['manager', '=', 'true']
        ])->get();
        return $devs;
    }
}
