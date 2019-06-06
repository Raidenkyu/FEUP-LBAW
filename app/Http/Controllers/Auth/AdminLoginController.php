<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Admin as Admin;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;
    protected $guard = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        return view('pages.admin_login');
    }

    public function login(){

        if (auth()->guard('admin')->attempt(['username' => request('username'), 'password' => request('password')])) {

            return redirect('admin');
        }

        return back();

    }

    public function logout(){
        auth('admin')->logout();

        return redirect('admin\login');
    }

}
