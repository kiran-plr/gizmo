@extends('email.layouts.master')
@section('title', 'User Mail')
@section('main-content')
    <div style="padding: 30px;  box-shadow: 0px 0px 8px 0px #f1f1f1; border-radius: 5px; background-color:#fff;">
        <h1 style="padding-top: 4pt; font-size: 24px; color: #3d4852; margin-bottom:25px;">Hello!</h1>
        <div>
            <p style="font-size:16px; color:#586578; font-weight:500; margin:15px 0; ">You can now login to your account
                using the following credentials:</p>
            <p style="font-size:16px; color:#586578; font-weight:500; margin:15px 0; ">Email: {{ $user->email }}</p>
            <p style="font-size:16px; color:#586578; font-weight:500; margin:15px 0; ">Password: {{ $pass }}</p>

            <p style="font-size:16px; color:#586578; font-weight:500; margin:15px 0; line-height:1.3; ">
                Regards,<br />
                Gizmogul-Buyback
            </p>
        </div>
    </div>
@endsection
