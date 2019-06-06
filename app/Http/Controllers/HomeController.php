<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        # return view('auth.login');
        # return redirect('login');
        # echo '<script>console.log('.json_encode(Auth::user()).')</script>';
        return view('pages.homepage');
    }
}
