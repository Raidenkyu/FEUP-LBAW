<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{

  public function index()
  {
    if (!Auth::check()) return redirect('/');

    $id = Auth::user()->id_member;
    $member = \App\Member::find($id);

    $my_projects = $member->my_projects;
    $projects = $member->projects;

    return view('pages.all_projects', ['projects' => $projects, 'my_projects' => $my_projects]);
  }

  public function dashboard($id)
  {
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

  public function create()
  {
    if (!Auth::check()) return redirect('/');

    return view('pages.create_project');
  }

  public function search(Request $request)
  {
    $search_array = array(request('content'));
    $where_query = "WHERE search.info1 @@ plainto_tsquery(?)";

    if (request('languages') != '') {
      array_push($search_array, request('languages'));
      $where_query = $where_query . "and search.info2 @@ plainto_tsquery(?)";
    }

    if (request('location') != '') {
      array_push($search_array, request('location'));
      $where_query = $where_query . "and search.info3 @@ plainto_tsquery(?)";
    }

    if (request('ageMin') != '') {
      array_push($search_array, request('ageMin'));
      $where_query = $where_query . "and age >= ?";
    }

    if (request('ageMax') != '') {
      array_push($search_array, request('ageMax'));
      $where_query = $where_query . "and age <= ?";
    }

    array_push($search_array, request('content'));


    $results = DB::select(
      "SELECT *
          FROM (SELECT *,
          	  to_tsvector('english', member.name) || to_tsvector('english', member.username) AS info1,
          	  to_tsvector('english', member.about) || to_tsvector('english', member.description) AS info2,
          	  to_tsvector('english', member.location) AS info3
          	  FROM member) search
          " . $where_query . "
          ORDER BY ts_rank(search.info1, plainto_tsquery('english', ?)) DESC
          ",
      $search_array
    );

    return response()->json($results);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required',
      'color' => 'required'
    ]);

    $project = \App\Project::create($data);

    foreach (json_decode(stripslashes(request('managers'))) as $manager) {
      DB::table('invite')->insert(['id_project' => $project->id_project, 'id_member' => $manager, 'manager' => 'true']);
    }

    foreach (json_decode(stripslashes(request('developers'))) as $developer) {
      DB::table('invite')->insert(['id_project' => $project->id_project, 'id_member' => $developer, 'manager' => 'false']);
    }

    return response()->json('/projects/' . $project->id_project);
  }

  public function leave($id_project)
  {
    $id_member = Auth::user()->id_member;
    \App\ProjectMember::where([
      ['id_member', '=', $id_member],
      ['id_project', '=', $id_project]
    ])->delete();
    return redirect('/projects');
  }

  public function destroy($id_project)
  {
    $project = \App\Project::find($id_project);
    $project->delete();
    return redirect('/projects');
  }

  public static function colorToHex($color)
  {
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
