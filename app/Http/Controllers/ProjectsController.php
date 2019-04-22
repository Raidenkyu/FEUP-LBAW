<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    //

    public function index(){
        $projects = \App\Project::all();

        //return $projects;
        return view('pages.projects', ['projects' => $projects]);
    }

}
