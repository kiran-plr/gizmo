<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="position: relative;" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        h1 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 14pt;
        }

        h2 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
        }

        .p,
        p {
            color: #5e5c5c;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
            margin: 0pt;
        }

        .s1 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
            vertical-align: 2pt;
        }

        .s2 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
        }

        .s3 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .a,
        a {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        table,
        tbody {
            vertical-align: top;
            overflow: visible;
            font-family: Arial, sans-serif;
        }

        .clr-blue {
            color: rgb(52 192 193);
        }

        .address p {
            color: #999999;
            padding: 2px 0;
        }

        table p {
            color: #000;
        }

        .border-p {
            border-top: 1px solid #de1f27;
            text-align: right;
            position: relative;
            padding-right: 45px !important;
            color: #de1f27 !important;
            margin-top: 3px;
            padding-top: 3px !important;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body style="background-color: #f2f6f8;">
    <div style="margin: 50px auto; max-width: 760px; position: relative; z-index: 11;">
        <div class="template-body">

            <!-- Header -->
            @include('email.layouts.header')
            <!-- Header  End-->

            <!-- Content -->
            @yield('main-content')
            <!-- Content End -->

            <!-- Footer -->
            @include('email.layouts.footer')
            <!-- Footer End -->
            <p
                style="width: 100%;
                text-align: center;
                margin: 40px 0;
                color: #b9b9b9;
                font-size: 16px;
                letter-spacing: 1px;">
                © 2022 Gizmogul-Buyback. All right reserved.
            </p>
        </div>
    </div>
</body>

</html>
