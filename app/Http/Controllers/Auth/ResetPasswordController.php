<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;

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
}
