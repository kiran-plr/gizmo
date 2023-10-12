<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectPath()
    {
        $user = Auth::user();
        $role = $user->roles()->first()->slug ?? '';
        $user->update(['last_login_at' => Carbon::now()->toDateTimeString()]);
        switch ($role) {
            case AppHelper::ADMIN['slug']:
                session()->flash('success', 'Successfully logged in!');
                return '/admin/dashboard';
            case AppHelper::VENDOR['slug']:
                session()->flash('success', 'Successfully logged in!');
                return '/vendor/dashboard';
            default:
                session()->flash('success', 'Successfully logged in!');
                return '/';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(\Illuminate\Http\Request $request)
    {
        return ['email' => $request->email, 'password' => $request->password, 'is_verified' => '1'];
    }

    public function autoLogin(Request $request)
    {
        // $en = 'h%2C%18v%0A%9D8Pbg%9A%90%A1%5C%E1%E2p2%98%B3y%18f%19%26%EE%F1f%5D%C7%9F-t%17%2F%E6%12v%10%B5L2%EA%8E%04%8AT%9B%27HX%13%BA%B2%A4O%A4%F9WS%2C%CD+%CD%60%D9%F5%F3%0D%DCq%B9v%EE%AF%FEi%87%E5%3F';
        if (!auth()->check()) {
            try {
                $autologinKey  = env('AUTO_LOGIN_KEY');
                $autoLoginIV = env('AUTO_LOGIN_IV');
                $loginData = explode('|', openssl_decrypt(urldecode($request->login), "AES-128-CBC", $autologinKey, true, $autoLoginIV));

                if (is_array($loginData) && isset($loginData[0]) && isset($loginData[1]) && isset($loginData[2]) && isset($loginData[3])) {
                    $role = Role::where('slug', AppHelper::VENDOR['slug'])->first();
                    $user = $role->users()->where('email', $loginData[1])->first();
                    $location = Location::where('external_location_id', $loginData[0])->first();

                    if ($user) {
                        if ($location && $user->locations()->where('external_location_id', $loginData[0])->count() == 0) {
                            $user->locations()->attach($location->id);
                        }

                        Auth::login($user);
                        return redirect('/vendor/dashboard')->with('success', 'Successfully logged in!');
                    }
                    return $this->createVendor($loginData);
                }
                return redirect('/login')->with('error', 'Login data is invalid!');
            } catch (Exception $e) {
                return redirect('/login')->with('error', $e->getMessage());
            }
        }
    }

    public function createVendor($loginData)
    {
        try {
            $data = [
                'email' => $loginData[1],
                'name' => $loginData[2] . ' ' . $loginData[3],
                'password' => Hash::make('password')
            ];

            $user = User::create($data);
            $user->roles()->attach(AppHelper::VENDOR['id']);
            $vendorPermission = Permission::whereIn('slug', AppHelper::VENDORPERMISSIONS)->pluck('id');
            $user->permissions()->attach($vendorPermission);
            $location = Location::where('external_location_id', $loginData[0])->first();
            if ($location) {
                $user->locations()->attach($location->id);
            }
            Auth::login($user);
            return redirect('/vendor/dashboard')->with('success', 'Successfully logged in!');
        } catch (Exception $e) {
            return redirect('/login')->with('error', $e->getMessage());
        }
    }
}
