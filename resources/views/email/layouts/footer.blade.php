<table style="width: 100%; background-color: #531eff; padding: 45px; border-radius: 0px 0 5px 5px;">
    <tbody>
        <tr style="vertical-align: middle;">
            <td style="padding-left: 10px;"> <img src="{{ asset('/assets/images/email/gm-logo.png') }}" width="130px"
                    alt="logo" /></td>
            <td>
                <a style="background-color: #00000050;
                color: #fff;
                padding: 15px;
                display: block;
                max-width: 120px;
                font-weight: 600;
                font-size: 16px;
                border-radius: 50px;
                text-decoration: none;
                text-align: center;"
                    href="tel:{{ AppHelper::SITE_MOBILE }}">{{ AppHelper::SITE_MOBILE }}</a>
            </td>
            <td style="width: 225px;">
                <a style="height: 45px; width: 45px; margin:0 5px;text-decoration: none;"
                    href="{{ AppHelper::FACEBOOK_LINK }}">
                    <img src="{{ asset('/assets/images/email/fb-ic.png') }}" width="40px" alt="logo" />
                </a>
                <a style="height: 45px; width: 45px; margin:0 5px;text-decoration: none;"
                    href="{{ AppHelper::TWITTER_LINK }}">
                    <img src="{{ asset('/assets/images/email/twitter-ic.png') }}" width="40px" alt="logo" />
                </a>
                <a style="height: 45px; width: 45px; margin:0 5px;text-decoration: none;"
                    href="{{ AppHelper::VIMEO_LINK }}">
                    <img src="{{ asset('/assets/images/email/v-ic.png') }}" width="40px" alt="logo" />
                </a>
                <a style="height: 45px; width: 45px; margin:0 5px;text-decoration: none;"
                    href="{{ AppHelper::LINKEDIN_LINK }}">
                    <img src="{{ asset('/assets/images/email/linkdin-ic.png') }}" width="40px" alt="logo" />
                </a>
            </td>

        </tr>
        <tr style="padding-top: 40px;">
            <td style="color:#fff; padding:0 15px;">
                <h5 style="font-weight: 600; margin-top:40px; font-size: 14px;">About Gizmogul</h5>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('cms-page', ['our-story']) }}">Our Story</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('cms-page', ['do-good']) }}">Do Good</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('cms-page', ['press']) }}">Press</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('contact-us') }}">Contact</a>
            </td>
            <td style="color:#fff; padding:0 15px;">
                <h5 style="font-weight: 600; margin-top:40px; font-size: 14px;">Services</h5>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('cms-page', ['corporate-recycling']) }}">Corporate recycling</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('cms-page', ['buy-a-device']) }}">Buy a Device</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('sell-your-device') }}">Sell Device</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="javascript:;">Enterprise Bulk Purchasing</a>
            </td>
            <td style="color:#fff; padding:0 15px;">
                <h5 style="font-weight: 600; margin-top:40px; font-size: 14px;">Support</h5>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('cms-page', ['retail-partners']) }}">Retail Partners</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('track-shipment') }}">Track Shipment</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('cms-page', ['help-center']) }}">Help Center</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('cms-page', ['terms-condition']) }}">Terms & conditions</a>
                <a style="color:#fff; display:block; width: fit-content; margin-top:10px;text-decoration: none;"
                    href="{{ route('cms-page', ['privacy-policy']) }}">Privacy Policy</a>
            </td>
        </tr>
    </tbody>
</table>
