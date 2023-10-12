@extends('email.layouts.master')
@section('title', 'Request a free quote')
@section('main-content')
    <div style="padding: 30px;  box-shadow: 0px 0px 8px 0px #f1f1f1; border-radius: 5px; background-color:#fff;">
        @if ($mailType == 'admin')
            <h1 style="padding-top: 4pt; font-size: 24px; color: #3d4852; margin-bottom:25px;">Hello Admin,</h1>
            <h1 style="padding-top: 4pt; font-size: 18px; color: #3d4852; margin-bottom:15px;">Subject :
                <span style="font-weight:500;">Request a Free Quote</span>
            </h1>
            <div>
                <p style="font-size:16px; color:#586578; font-weight:700; margin:10px 0; ">You received an email from :
                    <span style="font-weight:500;">{{ $data['email'] }}</span>
                </p>
                <hr />
                <p style="font-size:16px; color:#586578; font-weight:700; margin:15px 0; ">Name:
                    <span style="font-weight:500;">{{ $data['first_name'] . ' ' . $data['last_name'] }}</span>
                </p>
                <p style="font-size:16px; color:#586578; font-weight:700; margin:15px 0; ">Phone:
                    <span style="font-weight:500;">{{ $data['phone'] }}</span>
                </p>
                <p style="font-size:16px; color:#586578; font-weight:700; margin:15px 0; ">Company/School:
                    <span style="font-weight:500;">{{ $data['company_or_school_name'] }}</span>
                </p>
                <p style="font-size:16px; color:#586578; font-weight:700; margin:15px 0; ">Description:
                    <span style="font-weight:500;">{{ $data['description'] }}</span>
                </p>
                <p style="font-size:16px; color:#586578; font-weight:500; margin:15px 0; line-height:1.3; ">
                    Regards,<br />
                    Gizmogul-Buyback
                </p>
            </div>
        @else
            <h1 style="padding-top: 4pt; font-size: 24px; color: #3d4852; margin-bottom:25px;">Hey
                <span style="font-weight: 500;">{{ $data['first_name'] . ' ' . $data['last_name'] }}</span>
            </h1>
            <div>
                <p style="font-size:18px; line-height:1.4; color: #3d4852; font-weight:500; margin:15px 0;">
                    <b>Thanks for reaching out! 😊</b>
                </p>
                <p style="font-size:18px; line-height:1.4; color: #3d4852; font-weight:500; margin:15px 0;">
                    Our company Gizmogul Inc.is happy to provide mobile device recovery for your organization.
                </p>

                <p style="font-size:18px; line-height:1.4; color: #3d4852; font-weight:500; margin:15px 0;">
                    We work with small and large businesses, schools, universities and other organizations helping recover
                    value from used and obsolete technology while ensuring all data is sanitized and wiped appropriately.
                </p>

                <p style="font-size:18px; line-height:1.4; color: #3d4852; font-weight:500; margin:15px 0;">
                    Our process is very simple. We will provide the necessary shipping labels, and perform a full analysis
                    and data wipe on each device once received at our facility. After processing we will provide a detailed
                    audit report and value of the material which will be paid back to your organization based on model
                    specifications, cosmetic and functionality.
                </p>

                <p style="font-size:18px; line-height:1.4; color: #3d4852; font-weight:500; margin:15px 0;">
                    If you are looking for an estimate before sending to our processing facility, please send us a manifest
                    of the devices you have with their specifications. You can use the spreadsheet attached or we can work
                    with one you may have already created.
                </p>

                <p style="font-size:18px; line-height:1.4; color: #3d4852; font-weight:500; margin:15px 0;">
                    We look forward to working with you.
                </p>
                <p style="font-size:16px; color:#586578; font-weight:500; margin:10px 0; line-height:1.3; ">❤️ Gizmogul
                </p>
                <p style=" margin:10px 0; line-height:1.3;">
                    <a href="mailto:{{ AppHelper::SITE_EMAIL }}"
                        style="font-size:16px; color:#586578; font-weight:500; text-decoration:none;">{{ AppHelper::SITE_EMAIL }}</a>
                </p>
                <p style="font-size:16px; color:#586578; font-weight:500; margin:10px 0; line-height:1.3;">
                    <a href="tel:{{ AppHelper::SITE_MOBILE }}"
                        style="font-size:16px; color:#586578; font-weight:500; text-decoration:none;">{{ AppHelper::SITE_MOBILE }}</a>
                </p>
            </div>
        @endif
    </div>
@endsection
