<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{

    public function index(){
        if (!Auth::check()) return redirect('/');

        $id = Auth::user()->id_member;
        $member = \App\Member::find($id);

        $my_projects = $member->my_projects;
        $projects = $member->projects;

        return view('pages.all_projects', ['projects' => $projects, 'my_projects' => $my_projects]);
    }

    public function dashboard($id){
      if (!Auth::check()) return redirect('/');
      $user = Auth::user();
      $todo = \App\Task::whereIdProject($id)->whereListName('To Do')->get();
      $in_progress = \App\Task::whereIdProject($id)->whereListName('In Progress')->get();
      $pending = \App\Task::whereIdProject($id)->whereListName('Pending Approval')->get();
      $done = \App\Task::whereIdProject($id)->whereListName('Done')->get();
      $project = \App\Project::where('id_project', $id)->first();

      $isManager = \App\ProjectMember::isManager($user->id_member, $id);

      return view('pages.project', ['todo' => $todo, 'in_progress' => $in_progress, 'pending' => $pending, 'done' => $done, 'project' => $project, 'isManager' => $isManager]);
    }

    public function create(){
        if (!Auth::check()) return redirect('/');

        return view('pages.create_project');
    }

    public function search(Request $request){
      $results = DB::select("SELECT *
                            FROM (SELECT *, to_tsvector('english', member.name) || to_tsvector('english', member.username) AS document
                                  FROM member) search
                            WHERE search.document @@ plainto_tsquery(?)
                            ORDER BY ts_rank(search.document, plainto_tsquery('english', ?)) DESC
                            ", [request('content'), request('content')]);

      return response()->json($results);
    }

    public function store(Request $request){
      $data = $request->validate([
        'name' => 'required',
        'color' => 'required'
      ]);

      $project = \App\Project::create($data);

      foreach (json_decode(stripslashes(request('managers'))) as $manager) {
        DB::table('project_member')->insert(['id_project' => $project->id_project, 'id_member' => $manager, 'manager' => 'true']);
      }

      foreach (json_decode(stripslashes(request('developers'))) as $developer) {
        DB::table('project_member')->insert(['id_project' => $project->id_project, 'id_member' => $developer, 'manager' => 'false']);
      }

      return response()->json('/projects/' . $project->id_project);


    }

    public function leave($id_project) {
      $id_member = Auth::user()->id_member;
      \App\ProjectMember::where([
          ['id_member', '=', $id_member],
          ['id_project', '=', $id_project]
      ])->delete();
      return redirect('/projects');
  }

  public function destroy($id_project) {
      $project = \App\Project::find($id_project);
      $project->delete();
      return redirect('/projects');
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
