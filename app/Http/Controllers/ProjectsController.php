<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    //


    public function index(){

        if (!Auth::check()) return redirect('/');

        $user = Auth::user();

        echo '<script>console.log('.json_encode($user).')</script>';

        #$this->authorize('list', Card::class);

        #$cards = Auth::user()->cards()->orderBy('id')->get();

        $my_projects = \App\Project::all();  //TODO: Get só dos projects em o user é manager
        $projects = \App\Project::all();    //TODO: Get de todos projects em que o user participa

        return view('pages.projects', ['projects' => $projects, 'my_projects' => $my_projects]);
    }

    public function dashboard($id){
      // if (!Auth::check()) return redirect('/');
      // $user = Auth::user();
      $todo = \App\Task::whereIdProject($id)->whereListName('To Do')->get();
      $in_progress = \App\Task::whereIdProject($id)->whereListName('In Progress')->get();
      $pending = \App\Task::whereIdProject($id)->whereListName('Pending Approval')->get();
      $done = \App\Task::whereIdProject($id)->whereListName('Done')->get();
      $project = \App\Project::where('id_project', $id)->first();
      return view('pages.dashboard', ['todo' => $todo, 'in_progress' => $in_progress, 'pending' => $pending, 'done' => $done, 'project' => $project]);
    }

    // public function settings(Project $project){
    //   return ['project' => $project];
    // }

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
