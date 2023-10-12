<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected function redirectTo()
    {
        $role = Auth::user()->roles()->first()->slug;
        switch ($role) {
            case AppHelper::ADMIN['slug']:
                session()->flash('success', 'You are successfully registered.');
                return '/admin/dashboard';
                break;
            case AppHelper::VENDOR['slug']:
                session()->flash('success', 'You are successfully registered.');
                return '/vendor/dashboard';
                break;
            default:
                session()->flash('success', 'You are successfully registered.');
                return '/user/dashboard';
                break;
        }
    }

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['required', 'captcha']
        ], [
            'g-recaptcha-response.required' => 'Please verify you are not a robot.',
            'g-recaptcha-response.required' => 'Please verify you are not a robot.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        unset($data['_token']);

        $user =  User::create($data);

        $user->roles()->attach(3);
        $user->permissions()->attach(1);
        return $user;
    }
}
