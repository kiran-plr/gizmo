<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    // /**
    //  * Display the form to request a password reset link.
    //  *
    //  * @return \Illuminate\View\View
    //  */
    // public function showLinkRequestForm()
    // {
    //     Session::put('previous_url', url()->previous());
    //     return view('auth.passwords.email');
    // }

    // /**
    //  * Get the response for a successful password reset link.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  string  $response
    //  * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    //  */
    // protected function sendResetLinkResponse(Request $request, $response)
    // {
    //     if ($request->wantsJson()) {
    //         return new JsonResponse(['message' => trans($response)], 200);
    //     } else {
    //         if (Session::has('previous_url')) {
    //             $prevURL = Session::get('previous_url');
    //             Session::forget('previous_url');
    //             AppHelper::notify('success',trans($response));
    //             return redirect($prevURL)->with('status', trans($response));
    //         }
    //         return back()->with('status', trans($response));
    //     }
    // }
}
