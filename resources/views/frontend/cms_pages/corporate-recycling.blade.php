<script>
    document.getElementsByTagName('body')[0].className = 'corporate-recycling'
</script>


<div class="content-container" id="corporate-home">

    <!-- Section for Secure way Start-->
    <section class="securewaysec container">
        <div class="row">
            <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6 ">
                <h1 class="sec-1-title mt-5">The <u>secure&nbsp;</u>way to sell devices in bulk.</h1>
                <h3 class="mt-3">Providing maximum value for your mobile devices, tablets and laptops.</h3>
                <div class="btnalign mt-3 mb-5">
                    <a class="btnlink font-weight-bold text-size-13">Simple</a>
                    <a class="btnlink font-weight-bold text-size-13">Secure</a>
                    <a class="btnlink font-weight-bold text-size-13">Transparent</a>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                <div class="getaquote shadow-lg bg-white rounded">
                    <form id="contact-form" method="POST" action="{{ route('corporate-recycling.submit') }}"
                        class="form-horizontal" role="form">
                        @csrf
                        <h5 class="font-weight-bold">Request a Free Quote</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="first_name" placeholder="none"
                                            value="{{ old('first_name') }}" name="first_name" value=""
                                            maxlength="50" minlength="3" required="">
                                        <label for="subject" class="form-label">First Name</label>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="last_name" placeholder="none"
                                            value="{{ old('last_name') }}" name="last_name" value=""
                                            maxlength="50" minlength="3" required="">
                                        <label for="subject" class="form-label">Last Name</label>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="Phone" placeholder="none"
                                            value="{{ old('phone') }}" name="phone" maxlength="50" minlength="5"
                                            required="">
                                        <label for="subject" class="form-label">Phone</label>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="email" class="form-input" id="email" placeholder="none"
                                            value="{{ old('email') }}" name="email" maxlength="50" minlength="5"
                                            required="">
                                        <label for="subject" class="form-label">Email</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="company_or_school_name"
                                            placeholder="none" value="{{ old('company_or_school_name') }}"
                                            name="company_or_school_name" maxlength="50" minlength="5" required="">
                                        <label for="subject" class="form-label">Company /School</label>
                                        @error('company_or_school_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="form-control">
                                        <textarea class="form-input" rows="10" placeholder="none" name="description" maxlength="500" required="">{{ old('description') }}</textarea>
                                        <label for="subject" class="form-label">Provide a brief description of the
                                            material and volume.</label>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! NoCaptcha::display() !!}
                                </div>
                                @error('g-recaptcha-response')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary btn-press mt-2" id="submit" type="submit" value="SEND">
                            Get a Free Quote
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="what-you-get-section">
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
            <div class="gizmogulwillget">
                <div class="services bg_pink">
                    <center><img class="servicesicon" src="{{ asset('/assets/images/Corporatelogo.svg') }}"
                            alt="guarantee"></center>
                </div>
                <h2 class="font-weight-bold text-black text-size-19 mt-4 text-center">Corporations </h2>
                <p class="text-secondary text-size-16 mt-4 text-center">Offering tailored solutions for IT Managers.
                </p>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
            <div class="gizmogulwillget">
                <div class="services bg_orange">
                    <center><img class="servicesicon" src="{{ asset('/assets/images/school.png') }}"
                            alt="guarantee">
                    </center>
                </div>
                <h2 class="font-weight-bold text-black text-size-19  mt-4 text-center">Schools</h2>
                <p class="text-secondary text-size-16 mt-4 text-center">Supporting device life-cycle management.</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
            <div class="gizmogulwillget">

                <div class="services bg_blue">
                    <center><img class="servicesicon" src="{{ asset('/assets/images/government.png') }}"
                            alt="guarantee"></center>
                </div>

                <h2 class="font-weight-bold text-black text-size-19  mt-4 text-center">Government</h2>
                <p class="text-secondary text-size-16 mt-4 text-center">Providing data security and a clear audit
                    trail. </p>
            </div>
        </div>
    </div>

    <div class="willget container mt-5">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                <h2 class="text-center font-weight-bold text-black font-size-28">What You'll Get</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-0 col-lg-2 col-xs-12 col-sm-12">
            </div>
            <div class="col-md-6 col-sm-6 col-lg-4 ">
                <ul class="withgetlist text-size-16">
                    <li class="text-secondary font-weight-bold">Reverse logistics, recovering value from pre-owned IT
                        equipment.</li><br>
                    <li class="text-secondary font-weight-bold">A team trained to quickly retire IT assets and work
                        around your daily schedule.</li><br>
                    <li class="text-secondary font-weight-bold">High-level security on all decommissioned media.</li>
                </ul>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-4 ">
                <ul class="withgetlist text-size-16">
                    <li class="text-secondary font-weight-bold">Provide maximum value and an extraordinary experience
                        to all we serve.</li>
                    <li class="text-secondary font-weight-bold">Long-term management of IT systems and infrastructure
                        for clients.</li>
                </ul>
            </div>
            <div class="col-md-0 col-lg-2 col-xs-12 col-sm-12">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-5">
                <center><button data-bs-toggle="modal" data-bs-target="#free-quote-modal" class="btn btn-press">Get a
                        Free Quote</button></center>
            </div>
        </div>
    </div>
</section>

<section class="satisfied-client-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
                <p class="slider_title font-weight-bold">Satisfied Clients</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-xs-12 col-sm-12 col-lg-2">
                <div class="item"><img src="{{ asset('/assets/images/client1.jpg') }}" alt=""></div>
            </div>
            <div class="col-md-2 col-xs-12 col-sm-12 col-lg-2">
                <div class="item"><img src="{{ asset('/assets/images/client2.jpg') }}" alt=""></div>
            </div>
            <div class="col-md-2 col-xs-12 col-sm-12 col-lg-2">
                <div class="item"><img src="{{ asset('/assets/images/client.jpg') }}" alt=""></div>
            </div>
        </div>
    </div>
</section>

<section class="whygizmogul mt-5 mb-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
                <p class="font-weight-bold text-size-30 text-center text-black">
                    Why trust Gizmogul ?
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                <div class="whygiz">

                    <div class="row">
                        <div class="col-4 col-md-4 col-lg-4 col-sm-4 col-xs-4">
                            <img class="img img-responsive" src="{{ asset('/assets/images/lock.png') }}"
                                alt="Data Security">
                        </div>
                        <div class="col-8 col-md-8 col-lg-8 col-sm-8 col-xs-8">
                            <span class="text-size-16 text-secondary font-weight-bold">
                                Data security and destruction.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                <div class="whygiz">

                    <div class="row">
                        <div class="col-4 col-md-4 col-lg-4 col-sm-4 col-xs-4">
                            <img class="img img-responsive" src="{{ asset('/assets/images/reporting.png') }}"
                                alt="Comprehensive">
                        </div>
                        <div class="col-8 col-md-8 col-lg-8 col-sm-8 col-xs-8">
                            <span class="text-size-16 text-secondary font-weight-bold">
                                Comprehensive serial reporting.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                <div class="whygiz">

                    <div class="row">
                        <div class="col-4 col-md-4 col-lg-4 col-sm-4 col-xs-4">
                            <img class="img img-responsive" src="{{ asset('/assets/images/account.png') }}"
                                alt="Dedicatiing account">
                        </div>
                        <div class="col-8 col-md-8 col-lg-8 col-sm-8 col-xs-8">
                            <span class="text-size-16 text-secondary font-weight-bold">
                                Dedicated account management.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                <div class="whygiz">

                    <div class="row">
                        <div class="col-4 col-md-4 col-lg-4 col-sm-4 col-xs-4">
                            <img class="img img-responsive" src="{{ asset('/assets/images/chain.png') }}"
                                alt="secure chain">

                        </div>
                        <div class="col-8 col-md-8 col-lg-8 col-sm-8 col-xs-8">
                            <span class="text-size-16 text-secondary font-weight-bold">
                                Secure chain of custody from pickup to delivery.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                <div class="whygiz">

                    <div class="row">
                        <div class="col-4 col-md-4 col-lg-4 col-sm-4 col-xs-4">
                            <img class="img img-responsive" src="{{ asset('/assets/images/price.png') }}"
                                alt="transpaent Pricing">
                        </div>
                        <div class="col-8 col-md-8 col-lg-8 col-sm-8 col-xs-8">
                            <span class="text-size-16 text-secondary font-weight-bold">
                                Transparent Pricing and maximum recovery.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-6 col-sm-12">
                <div class="whygiz">
                    <div class="row">
                        <div class="col-4 col-md-4 col-lg-4 col-sm-4 col-xs-4">
                            <img class="gizmogultrustimg mb-2" src="{{ asset('/assets/images/handshake.png') }}"
                                alt="Partner">
                        </div>
                        <div class="col-8 col-md-8 col-lg-8 col-sm-8 col-xs-8">
                            <span class="text-size-16 text-secondary font-weight-bold">
                                We will partner with you long term.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="rightplan">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                <p class="rightplan_text">Find the right plan for your retired assets.</p>
            </div>
        </div>
        <div class="row mb_20">
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                <center><button data-bs-toggle="modal" data-bs-target="#free-quote-modal"
                        class="btn fs16 btn-press">Get a Free Quote</button></center>
            </div>
        </div>
    </div>
</section>

<section class="guarantee">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-9">
                        <p class="gizmogul_ourwantee">Our Guarantee</p>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-3">
                        <img src="{{ asset('/assets/images/gizmogul_guarantee.png') }}" alt="guarantee"
                            id="waranteeimage">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                        <p class="text-size-15 text-secondary">Gizmogul’s Corporate Recycling Division is designed for
                            businesses, corporations, government agencies, schools &amp; universities along with various
                            other entities with more than 30 devices deployed, looking to recycle, retire and monetize
                            electronic devices, in large volume.</p>
                        <p class="text-size-15 text-secondary">
                            Gizmogul Inc. has emerged as a leading open market purchaser of new and used technologies.
                            The success of our program is fueled by the combination of our team's transparency, unique
                            ability to navigate secondary markets as well as our extensive network of global
                            partnerships.
                        </p>
                        <p class="text-size-15 text-secondary">
                            Gizmogul’s environmentally responsible programs are certified from the leading organizations
                            and our environmental practices have the lowest impact, with the highest yields. Our
                            experiences can help strategically, operationally, and implement planning for all your
                            device life-cycle management needs. We look forward to servicing your organization. </p>
                        <p class="text-size-15 text-secondary">
                            For additional information please click get a free quote.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-6">
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                        <div class="step2 stepalign">
                            <div class="row">
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 ">
                                    <center>
                                        <img src="{{ asset('/assets/images/shipping.png') }}" alt="guarantee">
                                    </center>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                    <p class="text-size-14 text-secondary font-weight-bold text-center mt-4">Don't Pay
                                        for Shipping</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                        <div class="step2 stepalign">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <img src="{{ asset('/assets/images/get_paid.png') }}" alt="guarantee">
                                    </center>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                    <p class="text-size-14 text-secondary font-weight-bold text-center mt-4">Get Paid
                                        Quickly</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                        <div class="step2">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <img src="{{ asset('/assets/images/payout.png') }}" alt="guarantee">
                                    </center>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                    <p class="text-size-14 text-secondary font-weight-bold text-center mt-4">Highest
                                        Payout <br>Guaranteed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                        <div class="step2">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <img src="{{ asset('/assets/images/devices.png') }}" alt="guarantee">
                                    </center>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                    <p class="text-size-14 text-secondary font-weight-bold text-center mt-4">Gizmogul
                                        Handles Millions of <br> Devices Annually</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="gizmogulgives">
            <div class="col-md-2 col-xs-12 col-lg-2 col-sm-12 align_center">
                <div class="gizmogulgivesimgdiv">
                    <center><img src="{{ asset('/assets/images/news-abc.png') }}" alt="guarantee"
                            class="stepimages imgpadd_12px"></center>
                </div>
            </div>
            <div class="col-md-2 col-xs-12 col-lg-2 col-sm-12">
                <p class="text-size-13 font-weight-bold"> «Startup Gizmogul gives you cash for&nbsp;trash»</p>
                <p class="text-size-12 font-weight-bold text-secondary"> — ABC News</p>
            </div>
            <div class="col-md-2 col-xs-12 col-lg-2 col-sm-12 align_center">
                <div class="gizmogulgivesimgdiv">
                    <center><img src="{{ asset('/assets/images/news-gizmodo.png') }}" alt="guarantee"
                            class="stepimages imgpadd_12px"></center>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-2 col-sm-12">
                <p class="text-size-13 font-weight-bold"> «The dirty truth about where your old electronics go»</p>
                <p class="text-size-12 font-weight-bold text-secondary"> — Gizmodo</p>
            </div>
            <div class="col-md-2 col-xs-12 col-lg-2 col-sm-12 align_center">
                <div class="gizmogulgivesimgdiv">
                    <center><img src="{{ asset('/assets/images/news-buzzfeed.png') }}" alt="guarantee"
                            class="stepimages imgpadd_12px"></center>
                </div>
            </div>
            <div class="col-md-2 col-xs-12 col-lg-2 col-sm-12">
                <p class="text-size-13 font-weight-bold">«Find out what really happens to our old electronics»</p>
                <p class="text-size-12 font-weight-bold text-secondary">— BuzzFeed</p>
            </div>
        </div>
    </div>
</section>

<section class="nextstep">
    <div class="container">
        <h1 class="gizmogulnextsteptext">Next Steps</h1>
        <div class="container">
            <div class="row">
                <div class=" col-md-4 col-xs-12 col-sm-4 col-lg-4">
                    <div class="step1">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                                <p class="giztextcolor">Step 1</p>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 align_right">
                                <img src="{{ asset('/assets/images/step1.png') }}" alt="guarantee" class="img"
                                    width="35px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 mt_50">
                                <h2 class="ftsize_28">Get a Free Quote</h2>
                                <p class="text-size-14 text-secondary font-weight-bold mt-4">What are your assets
                                    worth?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-4 col-xs-12 col-sm-4 col-lg-4">
                    <div class="step1">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                                <p class="giztextcolor">Step 2</p>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 align_right">
                                <img src="{{ asset('/assets/images/step2.png') }}" alt="guarantee" class="img"
                                    width="50px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 mt_50">
                                <h2 class="ftsize_28">Asset Recovery</h2>
                                <p class="text-size-14 text-secondary font-weight-bold mt-4">Full audit reporting and
                                    value</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-4 col-xs-12 col-sm-4 col-lg-4">
                    <div class="step1">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                                <p class="giztextcolor">Step 3</p>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 align_right">
                                <img src="{{ asset('/assets/images/step3.png') }}" alt="guarantee" class="img"
                                    width="40px">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 mt_50">
                                <h2 class="ftsize_28">Buyback</h2>
                                <p class="text-size-14 text-secondary font-weight-bold mt-4">Make the sale</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                </div>
                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4 mt-4 mb-5">
                    <center><button data-bs-toggle="modal" data-bs-target="#free-quote-modal" class="btn btn-press">
                            Get a Free Quote</button></center>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gizqueation">
    <div class="container">
        <h1 class="ft38">Have a question?</h1>
        <div class="row mt40">
            <div class="col-sm-12 getaquote shadow-lg bg-white rounded ">
                <form id="contact-form" method="POST" action="{{ route('corporate-recycling.submit') }}"
                    class="form-horizontal" role="form">
                    @csrf
                    <h5 class="font-weight-bold ft24 mb-3">Drop Us A Line</h5>
                    <div class="row">
                        <div class="col-sm-6 ">
                            <div class="form-group">
                                <div class="form-control">
                                    <input type="text" class="form-input" id="first_name" placeholder="none"
                                        name="first_name" maxlength="50" minlength="3"
                                        value="{{ old('first_name') }}" required="">
                                    <label for="subject" class="form-label">First Name</label>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control">
                                    <input type="text" class="form-input" id="last_name" placeholder="none"
                                        name="last_name" maxlength="50" minlength="3"
                                        value="{{ old('last_name') }}" required="">
                                    <label for="subject" class="form-label">Last Name</label>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control">
                                    <input type="text" class="form-input" id="phone" placeholder="none"
                                        name="phone" maxlength="20" value="{{ old('phone') }}" minlength="5"
                                        required="">
                                    <label for="subject" class="form-label">Phone</label>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-control">
                                    <input type="email" class="form-input" id="email" placeholder="none"
                                        name="email" value="{{ old('email') }}" maxlength="50" minlength="5"
                                        required="">
                                    <label for="subject" class="form-label">Email</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-control">
                                    <input type="text" class="form-input" id="company_or_school_name"
                                        placeholder="none" value="{{ old('company_or_school_name') }}"
                                        name="company_or_school_name" maxlength="50" minlength="5" required="">
                                    <label for="subject" class="form-label">Company /School</label>
                                    @error('company_or_school_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-control">
                                    <textarea class="form-input" rows="10" placeholder="none" name="description" maxlength="500" required="">{{ old('description') }}</textarea>
                                    <label for="subject" class="form-label">Provide a brief description of the
                                        material and volume.</label>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                {!! NoCaptcha::display() !!}
                            </div>
                            @error('g-recaptcha-response')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary btn-press mt-2" id="submit" type="submit" value="SEND">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade free-quote-modal" id="free-quote-modal" tabindex="-1" aria-labelledby="free-quote-modal"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="getaquote bg-white rounded ">
                    <form id="contact-form" method="POST" action="{{ route('corporate-recycling.submit') }}"
                        class="form-horizontal" role="form">
                        @csrf
                        <h5 class="font-weight-bold ft24 mb-3">Request a Free Quote</h5>
                        <div class="row">
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="first_name" placeholder="none"
                                            name="first_name" value="{{ old('first_name') }}" maxlength="50"
                                            minlength="3" required="">
                                        <label for="subject" class="form-label">First Name</label>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="last_name" placeholder="none"
                                            name="last_name" value="{{ old('last_name') }}" maxlength="50"
                                            minlength="3" required="">
                                        <label for="subject" class="form-label">Last Name</label>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="phone" placeholder="none"
                                            name="phone" maxlength="50" minlength="5"
                                            value="{{ old('phone') }}" required="">
                                        <label for="subject" class="form-label">Phone</label>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="email" class="form-input" id="email" placeholder="none"
                                            name="email" maxlength="50" minlength="5"
                                            value="{{ old('email') }}" required="">
                                        <label for="subject" class="form-label">Email</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="company_or_school_name"
                                            placeholder="none" name="company_or_school_name" maxlength="50"
                                            minlength="5" value="{{ old('company_or_school_name') }}"
                                            required="">
                                        <label for="subject" class="form-label">Company /School</label>
                                        @error('company_or_school_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="form-control">
                                        <textarea class="form-input" rows="10" placeholder="none" name="description" maxlength="500" required="">{{ old('description') }}</textarea>
                                        <label for="subject" class="form-label">Provide a brief description of the
                                            material and volume.</label>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! NoCaptcha::display() !!}
                                </div>
                                @error('g-recaptcha-response')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary btn-press mt-4" id="submit" type="submit" value="SEND">
                            Get a Free Quote
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {!! NoCaptcha::renderJs() !!}
@endpush
