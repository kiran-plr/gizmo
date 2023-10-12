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
        width: 300px;
        margin: 0 auto;
        border: solid 5px #000;
    }

    .priority-header .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        border-right: solid 3px #000;
    }

    .priority-header .whight {
        align-items: flex-end;
        margin-top: 40px;
        margin-left: 5px;
        font-weight: 500;
    }

    .priority-header .logo h1 {
        font-size: 30px;
        font-weight: 900;
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
        margin: 10px 0;
        text-transform: uppercase;
        font-size: 12px;
        color: #000;
        line-height: 1;
    }

    .priority-header .whight p {
        font-size: 12px;
        font-weight: 500;
        color: #000;
        margin: 0;
    }

    .address-wrapper {
        padding-right: 10px;
        padding-left: 10px;
        padding-bottom: 5px;
        padding-top: 5px;
        border-bottom: solid 3px #000;
    }

    .address-tow {
        margin-top: 20px;
        display: flex;
    }

    .address-tow span {
        margin-right: 5px;
        font-size: 12px;
        font-weight: 500;
        color: #000;
    }

    .address-one p,
    .address-tow p {
        font-size: 12px;
        font-weight: 500;
        color: #000;
    }

    .footer-bar-code p {
        text-align: center;
        color: #000;
        font-size: 17px;
        font-weight: 500;
        margin-top: 10px;
    }

    .footer-bar-code {
        padding: 10px;
    }

    .footer-bar-code img {
        display: block;
        margin: 0 auto;
        height: 50px;
        width: 200px;
    }

    .tracking-wrapper {
        text-align: center;
        padding: 5px 0;
        border-top: solid 3px #000;
    }

    .tracking-wrapper p {
        font-size: 12px;
        color: #000;
    }

    .right-image img {
        margin-left: 157px;
        width: 60px;
    }

    @media (max-width: 767px) {
        .priority-wrapper {
            max-width: 260px;
        }

        .priority-header .logo h1 {
            font-size: 12px;
        }

        .priority-header .whight p {
            font-size: 12px;
        }

        .priority-center-text h2 {
            margin: 15px 0;
            font-size: 12px;
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
            font-size: 12PX;
        }

        .footer-bar-code {
            margin-top: 5px;
            padding: 15px;
        }

        .tracking-wrapper p {
            font-size: 12px;
        }

        .tracking-wrapper {
            padding: 10px 0;
        }
    }
</style>
<section class="priority-mail-bg">
    <div class="priority-wrapper">
        <div class="priority-header">
            <div class="logo">
                <h1>P</h1>
            </div>
            <div class="right-image">
                <img src="{{ $shipment->qrcode }}" alt="qrcode">
            </div>
        </div>
        <div class="priority-center-text">
            <h2>Priority Mail</h2>
        </div>
        <div class="address-wrapper">
            <div class="address-one">
                <p>
                    {{ $address->user->name }}<br />
                    {{ $address->address }} <br />
                    {{ $address->apartment ? $address->apartment . '<br />' : '' }}
                    {{ $address->city }}, {{ $address->state }} {{ $address->zip }}</p>
            </div>
            <div class="address-tow">
                <span>Ship to:</span>
                <p>GIZMOGUL<br /> 15 Dan Rd, #150 <br /> Canton, MA 02021</p>
            </div>
        </div>
        <div class="footer-bar-code">
            <img src="data:image/png;base64,{!! $shipment->barcode !!}" alt="barcode" />
        </div>
        <div class="tracking-wrapper">
            <p>Tracking #: {{ $shipment->tracking_no }}</p>
        </div>
    </div>
</section>
