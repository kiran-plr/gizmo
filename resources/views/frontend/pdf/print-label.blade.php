<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        p {
            margin: 0;
            padding: 0;
        }

        .priority-header {
            display: grid;
            grid-template-columns: 25% auto 25%;
        }

        .priority-wrapper {
            max-width: 800px;
            margin: 0 auto;
            border: solid 8px #000;
        }

        .priority-header .right-image img {
            /* width: 1%; */
        }

        .priority-header .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            border-right: solid 3px #000;
        }

        .priority-header .whight {
            display: flex;
            align-items: flex-end;
            padding: 15px;
            font-weight: 500;
        }

        .priority-header .logo h1 {
            font-size: 96px;
            padding: 0;
            margin: 0;
            color: #000;
        }

        .priority-center-text {
            padding: 0px 0;
            border-top: solid 3px #000;
            border-bottom: solid 3px #000;
            text-align: center;
        }

        .priority-center-text h2 {
            margin: 30px 0;
            text-transform: uppercase;
            font-size: 40px;
            color: #000;
            line-height: 1;
        }

        .priority-header .whight p {
            font-size: 20px;
            font-weight: 500;
            color: #000;
            margin: 0;
        }

        .address-wrapper {
            padding: 30px;
            border-bottom: solid 3px #000;
        }

        .address-tow {
            margin-top: 60px;
            display: flex;
        }

        .address-tow span {
            margin-right: 5px;
            font-size: 20px;
            font-weight: 500;
            color: #000;
        }

        .address-one p,
        .address-tow p {
            font-size: 20px;
            font-weight: 500;
            color: #000;
        }

        .footer-bar-code p {
            text-align: center;
            color: #000;
            font-size: 56px;
            font-weight: 500;
            margin-top: 10px;
        }

        .footer-bar-code {
            padding: 30px;
        }

        .footer-bar-code img {
            width: 100%;
        }

        .tracking-wrapper {
            text-align: center;
            padding: 25px 0;
            border-top: solid 3px #000;
        }

        .tracking-wrapper p {
            font-size: 28px;
            color: #000;
        }

        @media (max-width: 767px) {
            .priority-wrapper {
                max-width: 260px;
            }

            .priority-header .logo h1 {
                font-size: 40px;
            }

            .priority-header .whight p {
                font-size: 11px;
            }

            .priority-center-text h2 {
                margin: 15px 0;
                font-size: 16px;
            }

            .address-one p,
            .address-tow p {
                font-size: 12px;
            }

            .address-tow span {
                font-size: 12PX;
            }

            .address-tow {
                margin-top: 30PX;
            }

            .footer-bar-code p {
                font-size: 16PX;
            }

            .footer-bar-code {
                margin-top: 5px;
                padding: 15px;
            }

            .tracking-wrapper p {
                font-size: 16px;
            }

            .tracking-wrapper {
                padding: 10px 0;
            }
        }
    </style>
</head>

<body>
    @include('frontend.partials.label')
</body>
