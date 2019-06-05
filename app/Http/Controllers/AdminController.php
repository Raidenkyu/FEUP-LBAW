<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function index(){
      $users = \App\Member::all();
      $projects = \App\Project::all();

      return view('pages.admin', [
        'users' => $users,
        'projects' => $projects,
      ]);
  }
}
