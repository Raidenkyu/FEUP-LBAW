<?php

namespace App\Http\Controllers\Auth;

use App\Member;
use App\DefaultAuth;
use App\RememberPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/projects';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        return Validator::make($data, [
            'username' => 'required|string|min:3|max:20|unique:member', //TODO: username unique
            'name' => 'required|string|min:3|max:255', 
            'email' => 'required|string|email|min:3|max:255|unique:member',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\DefaultAuth
     */
    protected function create(array $data)
    {        
        $member = Member::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email']
        ]);

        $remember_password = Member::create([
            'email' => $data['email']
        ]);

        return DefaultAuth::create([
            'id_member' => $member->id_member,
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
    }
}
