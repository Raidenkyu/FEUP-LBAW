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

    public static function colorToHex($color){
      switch ($color) {
        case 'Orange':
          return 'f77d13';
        case 'Yellow':
          return 'ffcc00';
        case 'Red':
          return 'e82020';
        case 'Green':
          return '2dcc71';
        case 'Lilac':
          return '9c58b6';
        case 'Sky':
          return '4894dd';
        case 'Blue':
          return '2880ba';
        case 'Purple':
          return '7f14ad';
        case 'Emerald':
          return '179f85';
        case 'Bordeaux':
          return 'c92b1a';
        case 'Golden':
          return 'c45e00';
        case 'Brown':
          return 'c45e00';
        default:
          return '4894dd';
      }
    }

}
