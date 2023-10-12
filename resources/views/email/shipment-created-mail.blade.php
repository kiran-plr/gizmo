@extends('email.layouts.master')
@section('detail-section')
    <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:700; margin:0; ">
        Order Details:
    </p>
    <table style="width:100%;">
        <tbody>
            <tr>
                <td>
                    <table style="margin-top:15px; width:100%; font-size:14px; border-collapse: collapse;" border="0">
                        <thead>
                            <tr style="background:#531eff26;">
                                <th style="padding: 5px; text-align:left;">
                                    #
                                </th>
                                <th style="padding: 5px; text-align:left;">
                                    Product name
                                </th>
                                <th style="padding: 5px; text-align:left;">
                                    QTY
                                </th>
                                <th style="padding: 5px; text-align:right;">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shipment->shipmentItems as $key => $shipmentItem)
                                <tr style="border-bottom:1px solid #d5d5d5;">
                                    <td style="padding: 5px;">{{ $key + 1 }}</td>
                                    <td style="padding: 5px;">{{ $shipmentItem->sku->product->name }}</td>
                                    <td style="padding: 5px;">{{ $shipmentItem->quantity }}</td>
                                    <td style="padding: 5px; text-align:right;">${{ $shipmentItem->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%; text-align: left; margin-top: 10px; font-size: 14px;" cellspacing="0">
        <tbody>
            <tr style="vertical-align: middle;">
                <td>
                    <table style="width: 100%; border-spacing: 0; " cellspacing="0">

                        <tr cellspacing="0">
                            <td style="padding-top: 10px; padding-bottom: 5px; margin-top: 5px; text-align: right;">
                                <strong>Grand Total</strong>
                            </td>
                            <td style="width: 105px; padding-top: 5px; text-align: right;">
                                <strong>${{ number_format($shipment->shipmentItems->sum('price'), 2) }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="font-size:16px; color:#586578; font-weight:500; margin:10px 0; line-height:1.3; ">❤️ Gizmogul</p>
    <p style=" margin:10px 0; line-height:1.3; ">
        <a href="mailto:{{ AppHelper::SITE_EMAIL }}"
            style="font-size:16px; color:#586578; font-weight:500; text-decoration:none;">{{ AppHelper::SITE_EMAIL }}</a>
    </p>
    <p style="font-size:16px; color:#586578; font-weight:500; margin:10px 0; line-height:1.3;">
        <a href="tel:{{ AppHelper::SITE_MOBILE }}"
            style="font-size:16px; color:#586578; font-weight:500; text-decoration:none;">{{ AppHelper::SITE_MOBILE }}</a>
    </p>
@endsection
@section('main-content')
    <div style="padding: 30px;  box-shadow: 0px 0px 8px 0px #f1f1f1; border-radius: 5px; background-color:#fff;">
        <h1 style="padding-top: 4pt; font-size: 24px; color: #3d4852; margin-bottom:25px;">Hey!</h1>
        @php
            $productsName = $shipment->shipmentItems
                ->unique('sku_id')
                ->map(function ($item) {
                    return $item->sku->product->name;
                })
                ->implode(', ');
        @endphp
        <div>
            <p style="font-size:18px; line-height:1.4; color: #3d4852; font-weight:500; margin:15px 0; text-align:center; ">
                <b>Thanks for placing your order 😊</b>
            </p>
            @if ($shipment->shipment_type == '2')
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    <b>{{ $shipment->user->name }}</b>, okay, we’re gonna make this super easy. Here is your free shipping
                    label for your <b> {{ $productsName }}. </b>
                </p>
                <a href="{{ $shipment->label_url }}" target="_blank"
                    style="max-width: 40%; width:100%; display:block; margin:20px auto; text-align:center; color:#fff; font-weight:700; background-color: #531effb8; padding:10px 8px; border-radius:8px; text-decoration:none;">
                    CLICK HERE To print your shipping label
                </a>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    Once you download it, pack it up and ship it out.
                </p>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    The shipping is all paid for. The package is insured and you can track it the whole way, so no worries.
                    Once
                    we
                    receive it, We will make sure you get paid quickly.
                </p>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    If you need anything or have questions, please feel free to send us an email.
                </p>

                @yield('detail-section')

                <hr />
                <p style="font-size:19px; color:#586578; font-weight:700; margin:20px 0 0 0; line-height:1.3;">Helpful Stuff
                </p>
                <p style="font-size:16px; color:#586578; font-weight:700; margin:10px 0 0 0; line-height:1.3; ">
                    Your tracking number:
                    <span style="font-size:14px; color:#586578; font-weight:500;">#{{ $shipment->tracking_no }}</span>
                </p>
                <p style="font-size:16px; color:#586578; font-weight:700; margin:10px 0; line-height:1.3; ">Track here:
                    <a href="{{ route('track-shipment') }}" target="_blank"
                        style="font-size:14px; color:#586578; font-weight:500; color: #531eff; text-decoration:none;">LINK!</a>
                </p>
            @else
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    <b>{{ $shipment->user->name }}</b>, okay, we’re gonna make this super easy. Bring your
                    <b> {{ $productsName }}</b> to:
                </p>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; text-align:center;">
                    <span>{{ $shipment->location->name }}</span><br />
                    <span>{{ $shipment->location->address }}</span>,<br />
                    @if ($shipment->location->address2)
                        <span>{{ $shipment->location->address2 }}</span>,<br />
                    @endif
                    <span>{{ $shipment->location->city . ', ' . $shipment->location->state . ' ' . $shipment->location->zip }}</span><br />
                </p>
                <a href="{{ route('user.dashboard') }}"
                    style="max-width: 40%; width:100%; display:block; margin:20px auto; text-align:center; color:#fff; font-weight:700; background-color: #531effb8; padding:10px 8px; border-radius:8px; text-decoration:none;">
                    CLICK HERE To open your order detail
                </a>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    Once you’re there, let the team know your trading in your device. Here is your order number :
                    <b>#{{ $shipment->shipment_no }}</b>
                </p>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    After we confirm and verify your trade dropoff, We will make sure you get paid <b>THE SAME DAY.</b>
                </p>
                <p style="font-size:16px; line-height:1.4; color:#586578; font-weight:500; margin:15px 0; ">
                    If you need anything or have questions, please feel free to send us an email.
                </p>

                @yield('detail-section')

                <hr />
                <p style="font-size:19px; color:#586578; font-weight:700; margin:20px 0 0 0; line-height:1.3;">Helpful Stuff
                </p>

                <p style="font-size:16px; color:#586578; font-weight:700; margin:10px 0; line-height:1.3; ">
                    <a href="{{ $shipment->label_url }}" target="_blank"
                        style="font-size:14px; color:#586578; font-weight:500; color: #531eff; text-decoration:none;">Print
                        a shipping label instead</a>
                </p>
            @endif
        </div>
    </div>
@endsection
