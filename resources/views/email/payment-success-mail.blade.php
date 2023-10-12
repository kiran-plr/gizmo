@extends('email.layouts.master')
@section('main-content')
    <div style="padding: 30px;  box-shadow: 0px 0px 8px 0px #f1f1f1; border-radius: 5px; background-color:#fff;">
        <!-- <h1 style="padding-top: 4pt; font-size: 24px; color: #3d4852; margin-bottom:25px;">Hey!</h1> -->
        @if ($transaction->shipment->shipment_type == '2')
            <div>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    We’re finished with your order and your check’s in the mail. First class. Treat yourself to something
                    nice.
                </p>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    Thanks so much for your business.
                </p>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    And if you are happy with our service, please tell one person about us.</br>
                    Just one. 😊
                </p>
            </div>
        @else
            <div>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    Thanks so much for your business.
                </p>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    And if you are happy with our service, please tell one person about us.</br>
                    Just one. 😊
                </p>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    Now go treat yourself to something nice 😊
                </p>
            </div>
        @endif
        <div>
            <p style="font-size:16px; color:#586578; font-weight:500; margin:30px 0 10px 0; line-height:1.3; ">❤️
                Gizmogul</p>
            <p style=" margin:10px 0; line-height:1.3; ">
                <a href="mailto:{{ AppHelper::SITE_EMAIL }}"
                    style="font-size:16px; color:#586578; font-weight:500;">{{ AppHelper::SITE_EMAIL }}</a>
            </p>
            <p style="font-size:16px; color:#586578; font-weight:500; margin:10px 0; line-height:1.3;">
                <a href="tel:{{ AppHelper::SITE_MOBILE }}"
                    style="font-size:16px; color:#586578; font-weight:500;">{{ AppHelper::SITE_MOBILE }}</a>
            </p>
        </div>
    </div>
@endsection
