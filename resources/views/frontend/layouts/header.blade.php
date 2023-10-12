<header class="header-wrapper">
    <nav class="navbar navbar-expand-lg bg-white" aria-label="Offcanvas navbar large">
        <div class="container-fluid ps-4 pe-4">
            <button class="navbar-toggler text-black btn-outline-none mobile-navbar-btn" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
                <i class="text-black bx bx-menu"></i>
            </button>
            <a href="/"
                class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none header-logo">
                <img src="{{ asset('/assets/images/logos/gizmogul-logo.png') }}" alt="" height="17">
            </a>
            <div class="mobile-cart-user-wrapper">
                <div class="d-flex text-end align-items-center">
                    <a href="{{ route('login') }}" class="me-2 text-black fs-4"> <i class="bx bx-user"></i></a>
                    <a href="#" class="text-black fs-4"><i class="bx bx-shopping-bag"></i></a>
                </div>
            </div>
            <div class="offcanvas offcanvas-end text-black mobile-menu-wrapper" tabindex="-1" id="offcanvasNavbar2"
                aria-labelledby="offcanvasNavbar2Label">
                <div class="offcanvas-header border-bottom">
                    <a href="/"
                        class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none header-logo">
                        <img src="{{ asset('/assets/images/logos/gizmogul-logo.png') }}" alt="" height="17">
                    </a>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                        aria-label="Close"><i class="bx bx-x"></i></button>
                </div>
                <div class="offcanvas-body mobile-menu-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-5">
                        <li><a href="{{ route('cms-page', ['how-does-it-works']) }}" class="nav-link px-2 text-black">How does it works?</a></li>
                        <li><a href="{{ route('cms-page', ['corporate-recycling']) }}"
                                class="nav-link px-2 text-black">Enterprise Bulk Purchasing</a></li>
                        <li><a href="{{ route('cms-page', ['buy-a-device']) }}" class="nav-link px-2 text-black">Buy a
                                Device</a></li>
                        <a href="{{ route('sell-your-device') }}" role="button"
                            class="btn btn-primary text-white px-4 rounded-pill ms-lg-3 fw-bold">
                            Sell Your Device
                        </a>
                    </ul>
                    <div class="d-flex text-end align-items-center desktop-show-cart">
                        @if (!auth()->check())
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-1 sign-in-link">
                                <li><a href="{{ route('login') }}" class="nav-link px-2 text-black">Sign In</a></li>
                            </ul>
                        @endif
                        <div class="user-login-wrapper user-logged-in-links">
                            @if (auth()->check())
                                <a href="javascript:;" class="me-2 text-black fs-4 user-login-toggle"> <i
                                        class="bx bx-user"></i></a>
                                <ul class="user-select-menu">
                                    <li>
                                        <a href="{{ route('user.dashboard') }}">
                                            <i class="fas fa-home fa-sm fa-fw mr-2 orange-color"></i>
                                            {{ __('Dashboard') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.password.change.index') }}">
                                            <i class="fas fa-key fa-sm fa-fw mr-2 orange-color"></i>
                                            {{ __('Change Password') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 orange-color"></i>
                                            {{ __('Logout') }}
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <a href="{{ route('login') }}" class="me-2 text-black fs-4"> <i
                                        class="bx bx-user"></i></a>
                            @endif
                        </div>
                        <a href="{{ route('cart') }}" class="text-black fs-4 cart-icon">
                            <i class="bx bx-shopping-bag"></i>
                            <span class="count-cartQty">{{ AppHelper::getCartQty() }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="mobile-search">
        <form action="">
            <div class="p-1 bg-light rounded mt-3">
                <div class="input-group">
                    <input type="search" placeholder="Search your product" aria-describedby="button-addon1"
                        class="form-control border-0 bg-light">
                    <div class="input-group-append">
                        <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</header>
