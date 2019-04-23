<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Member;
use App\DefaultAuth;
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
    protected $redirectTo = '/cards';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
/*
    public function register(Request $request){
        echo '<script>console.log("Overload")</script>';

        echo '<script>console.log('.json_encode($request->name).')</script>';
        echo '<script>console.log('.json_encode($request->email).')</script>';
        echo '<script>console.log('.json_encode($request->password).')</script>';

/*
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            //TODO: username
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $validatedData->create();

        /*
        try {
            $validatedData['password']        = bcrypt(array_get($validatedData, 'password'));
            $member                           = app(Member::class)->create($validatedData);
            $defaultArgs = ['id_member' => $member->id_member]

            $def_auth                         = app(De::class)->create($validatedData);
        } catch (\Exception $exception) {
            logger()->error($exception);
            return redirect()->back()->with('message', 'Unable to create new user.');
        }
        
        

        # return redirect()->back()->with('message', 'Successfully created a new account. Please check your email and activate your account.');


    }
    */

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        echo '<script>console.log("Validator")</script>';
        
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            //TODO: username
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
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
        echo '<script>console.log("Hi")</script>';

        $temp = 'Something';

        $data['username'] = $temp;

        echo '<script>console.log('.json_encode($data['name']).')</script>';
        echo '<script>console.log('.json_encode($data['username']).')</script>';
        echo '<script>console.log('.json_encode($data['email']).')</script>';
        
        $member = Member::create([
            'name' => $data['name'],
            'username' => $data['username'], //TODO: change to not be hardcoded
            'email' => $data['email']
        ]);

        
        echo '<script>console.log("Hi2")</script>';

        DefaultAuth::create([
            'id_member' => $member->id_member,
            'password' => bcrypt($data['password'])
        ]);

        return $member; //TODO: change to defaultAuth?


    }
}
