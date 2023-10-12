<footer style="background: linear-gradient(90deg, rgba(79,31,255,1) 0%, rgba(112,31,255,1) 100%);" class="pb-2 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 pt-5 footer-col-1">
                <div class="text-center footer-logo-wrapper">
                    <a href="/" class="d-block mb-3 link-dark text-decoration-none footer-logo-icon">
                        <img src="{{ asset('/assets/images/logos/gizmogul-logo-g-light.png') }}" alt=""
                            width="66.15" height="60">
                    </a>
                    <a href="/" class="d-block mb-3 link-dark text-decoration-none pt-2">
                        <img src="{{ asset('/assets/images/logos/gizmogul-logo-light.png') }}" alt=""
                            width="133" height="17"></a>
                    <a style="background-color: #00000050;" href="tel:855-773-8685"
                        class="px-4 mt-2 py-2 text-white rounded-pill d-inline-block fs-5 fw-bold">{{ AppHelper::SITE_MOBILE }}</a>
                </div>
            </div>
            <div
                class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 ps-5 pt-5 d-flex justify-content-center about-wrapper">
                <div class="text-left mobile-dropdown open">
                    <div class="about-title-btn">
                        <h5 class="text-white fs-5 fw-bold">About Gizmogul</h5>
                        <button class="btn p-0 dropdown">
                            <i class='bx bx-plus text-white fs-4'></i>
                        </button>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('cms-page', ['our-story']) }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Our
                                Story</a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('cms-page', ['do-good']) }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Do
                                good </a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('cms-page', ['press']) }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Press
                            </a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('contact-us') }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div
                class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 ps-5 pt-5 d-flex justify-content-center about-wrapper">
                <div class="text-left mobile-dropdown open">
                    <div class="about-title-btn">
                        <h5 class="text-white fs-5 fw-bold">Services</h5>
                        <button class="btn p-0 dropdown">
                            <i class='bx bx-plus text-white fs-4'></i>
                        </button>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="{{ route('cms-page', ['corporate-recycling']) }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Corporate
                                recycling</a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('cms-page', ['buy-a-device']) }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Buy
                                a
                                Device </a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('sell-your-device') }}"
                                class="nav-link p-0 text-white fs-6 fw-light">
                                Sell Device </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 ps-5 pt-5 d-flex justify-content-center about-wrapper">
                <div class="text-left mobile-dropdown open">
                    <div class="about-title-btn">
                        <h5 class="text-white fs-5 fw-bold">Support</h5>
                        <button class="btn p-0 dropdown">
                            <i class='bx bx-plus text-white fs-4'></i>
                        </button>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="{{ route('cms-page', ['retail-partners']) }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Retail
                                Partners</a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('track-shipment') }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Track
                                Shipment </a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('cms-page', ['help-center']) }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Help
                                Center </a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('cms-page', ['terms-condition']) }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Terms
                                &
                                conditions</a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('cms-page', ['privacy-policy']) }}"
                                class="nav-link p-0 text-white fs-6 fw-light">Privacy
                                Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between py-4 my-4 mb-0 pb-0 border-top footer-bottom">
            <p class="text-white fs-5 copy-right-text">© 2021 Gizmogul.com. All Right Reserved.</p>
            <ul class="list-unstyled d-flex social-media-wrapper">
                <li>
                    <a style="background-color: #00000050; height: 45px; width: 45px"
                        class="link-dark rounded-circle d-flex align-items-center justify-content-center"
                        href="{{ AppHelper::FACEBOOK_LINK }}">
                        <i class="bx bxl-facebook text-white fs-2"></i>
                    </a>
                </li>
                <li class="ms-3">
                    <a style="background-color: #00000050; height: 45px; width: 45px"
                        class="link-dark rounded-circle d-flex align-items-center justify-content-center"
                        href="{{ AppHelper::TWITTER_LINK }}">
                        <i class="bx bxl-twitter text-white fs-2"></i>
                    </a>
                </li>
                <li class="ms-3">
                    <a style="background-color: #00000050; height: 45px; width: 45px"
                        class="link-dark rounded-circle d-flex align-items-center justify-content-center"
                        href="{{ AppHelper::VIMEO_LINK }}">
                        <i class="bx bxl-vimeo text-white fs-2"></i>
                    </a>
                </li>
                <li class="ms-3">
                    <a style="background-color: #00000050; height: 45px; width: 45px"
                        class="link-dark rounded-circle d-flex align-items-center justify-content-center"
                        href="{{ AppHelper::LINKEDIN_LINK }}">
                        <i class="bx bxl-linkedin text-white fs-2"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<script src="{{ asset('/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- owl.carousel js -->
<script src="{{ asset('/assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>
<script>
    var newWindowWidth = $(window).width();
    if (newWindowWidth < 767) {
        $(".dropdown").off("click").on("click", function() {
            $(this).parent().parent().toggleClass("open");
            if ($(this).parent().parent().hasClass("open")) {
                $(this).html("<i class='bx bx-plus text-white fs-4'></i>");
            } else {
                $(this).html("<i class='bx bx-minus text-white fs-4'></i>");
            }
        });
    }
</script>
