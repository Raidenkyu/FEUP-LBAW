<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectSettingsController extends Controller
{
    //

    public function show($id){
        $project = \App\Project::where('id_project', $id)->first();
        return ['project' => $project];
    }

    public function update($id){
    }
}
