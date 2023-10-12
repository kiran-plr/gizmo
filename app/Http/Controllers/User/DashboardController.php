<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\UserPayout;
use App\Rules\ValidateOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Return View.
     *
     * @return void
     */
    public function index()
    {
        $tradeIns = Shipment::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->limit(5)->get();
        $totalAmountReceived = UserPayout::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->sum('amount');
        $tradeInsCount = Shipment::where('user_id', auth()->user()->id)->where('status', '!=', 'pending')->orderBy('id', 'desc')->count();
        return view('users.dashboard', compact('tradeIns', 'tradeInsCount', 'totalAmountReceived'));
    }

    public function changePasswordIndex()
    {
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', new ValidateOldPassword()],
            'new_password' => ['required'],
            'password_confirmation' => ['same:new_password'],
        ]);
        $user = auth()->user();
        $status = $user->update(['password' => Hash::make($request->new_password)]);

        if ($status) {
            return redirect()->route('login')->with('success', "Your password has been changed successfully");
        } else {
            return redirect()->back()->with('error', "Error occurred while changing password");
        }
    }
}
