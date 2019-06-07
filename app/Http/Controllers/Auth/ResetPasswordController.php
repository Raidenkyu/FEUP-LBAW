<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\DefaultAuth as DefaultAuth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(){
        $pass = request('password');
        $conf = request('password_confirmation');
        $email = request('email');
        $auth = DefaultAuth::where('email',$email)->get()[0];
        if($pass == $conf){
            $auth->password = bcrypt($pass);
            $auth->save();
            return redirect('/');
        }
        dd(request());
        return back();

    }

    protected function guard()
    {
        return Auth::guard('def_auth');
    }
 
    public function broker()
    {
         return Password::broker('def_auths');
    }

}