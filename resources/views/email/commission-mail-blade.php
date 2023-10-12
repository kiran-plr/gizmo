@extends('email.layouts.master')
@section('title', 'Commission Sent Email')
@section('main-content')
<div style="padding: 30px;  box-shadow: 0px 0px 8px 0px #f1f1f1; border-radius: 5px; background-color:#fff;">
    <h1 style="padding-top: 4pt; font-size: 24px; color: #3d4852; margin-bottom:25px;">Hello John Smith,</h1>

    <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:0 0 15px 0; ">
        Your Pak <b>9288595</b> was received and your commission check is on its way for <b>$500</b> You should be receiving
        this within <b>3-5</b> business days, nice work!
    </p>
    <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
        For details on the pak and the commission, please view your <b>"buy-back summary"</b> section on the buy-back
        dashboard!
    </p>

    <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
        If you have any questions or concerns, please feel free to email us back. Thanks
    </p>

    <p style="font-size:16px; color:#586578; font-weight:500; margin:30px 0 10px 0; line-height:1.3; ">❤️ Gizmogul</p>
    <p style=" margin:10px 0; line-height:1.3; ">
        <a href="mailto:cservice@gizmogul.com" style="font-size:16px; color:#586578; font-weight:500;">cservice@gizmogul.com</a>
    </p>
    <p style="font-size:16px; color:#586578; font-weight:500; margin:10px 0; line-height:1.3;">
        <a href="tel:800-925-5958" style="font-size:16px; color:#586578; font-weight:500;">800-925-5958</a>
    </p>
</div>
@endsection