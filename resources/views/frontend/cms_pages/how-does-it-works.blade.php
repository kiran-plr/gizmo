<section class="how-it-works">
    <div class="quote-devices">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <img src="{{ asset('/assets/images/home/howitworks_Consumer.png') }}">
                </div>
                <div class="col-md-8 col-lg-8 col-sm-12">
                    <div class="quote-content p-5">
                        <h1>Get Instant Quotes for your Old Devices</h1>
                        <p>Gizmogul makes it easy for you to sell your old device.</p>
                        <h2>Get Paid. Upgrade.</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="services-row">
        <div class="service-steps">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="card steps-info shadow rounded text-center">
                            <div class="steps-img">
                                <span class="step-number">Step 1</span>
                                <img src="{{ asset('/assets/images/home/howitworks_connectivity.png') }}">
                            </div>
                            <div class="steps-content">
                                <h2 class="">Trade</h2>
                                <p class="mt-4 text-secondary font-14">Select the device you are selling through a few
                                    simple steps for an instant quote.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="card steps-info shadow rounded text-center">
                            <div class="steps-img">
                                <span class="step-number">Step 2</span>
								<img src="{{ asset('/assets/images/home/howitworks_senddevice.png') }}">
                                
                            </div>
                            <div class="steps-content">
                                <h2 class="">Ship</h2>
                                <p class="mt-4 text-secondary font-14">Package and ship us your old device, or visit a partner location today. You help save the environment a little more and we help save your wallet. Pretty cool trade!</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="card steps-info shadow rounded text-center">
                            <div class="steps-img">
                                <span class="step-number">Step 3</span>
                                <img src="{{ asset('/assets/images/home/howitworks_getpaid.png') }}">
                            </div>
                            <div class="steps-content">
                                <h2 class="">Get Paid</h2>
                                <p class="mt-4 text-secondary font-14">With retail partners nationwide get paid the same day, or we will send you payment after we receive and verify your trade.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fast-secure-privacy">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="card padd-40 policy-info shadow rounded">
                            <img src="{{ asset('/assets/images/home/howitworks_getfreequotre.png') }}">
                            <h2>Fast &amp; Secure</h2>
                            <p>We move quickly, and want to make sure you're taken care of.</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="card padd-40 shadow rounded text-center middle-card">
                            <img src="{{ asset('/assets/images/home/icons-datasecurity.png') }}">
                            <h3>Your Privacy Matters</h3>
                            <p class="font-15">We will make sure your device is wiped clean and sanitized of any data,
                                using the industry standard erasure software.</p>
                        </div>
                        <div class="card padd-40 shadow rounded text-center middle-card">
                            <img src="{{ asset('/assets/images/home/icons-pricing.png') }}">
                            <h3>Competitive Offers</h3>
                            <p class="font-15">Get the highest price for your device.</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="card  policy-info shadow rounded">
                            <img src="{{ asset('/assets/images/home/howitworks_fastsecure.png') }}">
                            <div class="cards-content padd-40">
                                <h2>Same Day Buyback</h2>
                                <p class="font-15">With retail partners nationwide you can sell and get paid, the same
                                    day. Download our application below to find out more.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('frontend.partials.offer-appstore')
    </div>
</section>
