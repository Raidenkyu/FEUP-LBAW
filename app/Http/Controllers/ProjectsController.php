<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    //

    public function index(){
        $my_projects = \App\Project::all();  //TODO: Get só dos projects em o user é manager
        $projects = \App\Project::all();    //TODO: Get de todos projects em que o user participa

        return view('pages.projects', ['projects' => $projects, 'my_projects' => $my_projects]);
    }


    public function colorToHex(){
        //TODO: Don't know if this function goes here, but will convert the Color name to Hex
    }

}
