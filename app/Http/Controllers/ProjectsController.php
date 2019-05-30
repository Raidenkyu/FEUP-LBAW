<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{

    public function index(){

        if (!Auth::check()) return redirect('/');

        $id = Auth::user()->id_member;
        $member = \App\Member::find($id);

        $my_projects = $member->my_projects;
        $projects = $member->projects;

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

    public function create(){

        if (!Auth::check()) return redirect('/');

        return view('pages.create_project');
    }

    public function store(Request $request){
      $data = $request->validate([
        'name' => 'required',
        'color' => 'required',
      ]);

      $project = \App\Project::create($data);

      return redirect('/projects/' . $project->id_project);


    }

    public static function colorToHex($color){
      $colors = array(
        'Orange' => 'f77d13',
        'Yellow' => 'ffcc00',
        'Red' => 'e82020',
        'Green' => '2dcc71',
        'Lilac' => '9c58b6',
        'Sky' => '4894dd',
        'Brown' => 'c45e00',
        'Golden' => 'f39c13',
        'Bordeaux' => 'c92b1a',
        'Emerald' => '179f85',
        'Purple' => '7f14ad',
        'Blue' => '2880ba',
      );

      return $colors[$color];
    }

}
