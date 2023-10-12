<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">

                <a href="{{ route(request()->user()->role->slug . '.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('/assets/images/logos/gizmogul-logo-g.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('/assets/images/logos/gizmogul-logo.png') }}" alt="" height="17">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('/assets/images/logo-light.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('/assets/images/logos/gizmogul-logo-light.png') }}" alt=""
                            height="19">
                    </span>
                </a>
            </div>
            @if (auth()->check() && count(auth()->user()->locations) > 0)
                <button type="button"
                    class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                    data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-block me-4">
                    <div class="position-relative">
                        <input type="text" class="form-control" name="search" value="{{ request()->search }}"
                            placeholder="Search...">
                        <span class="bx bx-search-alt"></span>
                    </div>
                </form>
                <form class="select-location d-lg-block me-4">
                    @php
                        $user = auth()->user();
                        $locations = $user->locations;
                        $selectedLocation = $locations->where('id', isset($user->settings['selectedLocation']) ? $user->settings['selectedLocation'] : '')->first();
                    @endphp
                    <div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="defaultDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="true">
                            @if ($selectedLocation && $selectedLocation->name)
                                {{ $selectedLocation->name }}<span
                                    style="font-size: 10px">{{ ', ' . $selectedLocation->address . ', ' . $selectedLocation->city . ', ' . $selectedLocation->state }}</span>
                            @else
                                Select Location
                            @endif
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="defaultDropdown" data-popper-placement="bottom-start"
                            style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 39px);">
                            @foreach ($locations as $key => $location)
                                <li
                                    class="{{ $user->settings && $user->settings['selectedLocation'] == $location->id ? 'active' : '' }}">
                                    <a class="dropdown-item"
                                        href="{{ route('vendor.location.change', $location->id) }}">{{ $location->name }}<span
                                            class="address-font">{{ ', ' . $location->address . ', ' . $location->city . ', ' . $location->state }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </form>
                <div class="app-search d-none d-lg-block">
                    <a href="{{ route('vendor.shipment.create') }}" role="button"
                        class="btn btn-primary d-lg-block">New
                        Trade-In</a>
                </div>
            @endif
        </div>


        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..."
                                    aria-label="Search input">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (auth()->user()->avatar && \File::exists(public_path('/users/avatar/' . auth()->user()->avatar)))
                        <img class="rounded-circle header-profile-user"
                            src="{{ asset('/users/avatar/' . auth()->user()->avatar) }}" alt="Avatar">
                    @else
                        <img class="rounded-circle header-profile-user"
                            src="{{ asset('/assets/images/users/avatar-1.jpg') }}" alt="Avatar">
                    @endif
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ auth()->user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="javascript:;"><i
                            class="bx bx-user font-size-16 align-middle me-1"></i>
                        <span key="t-profile">Profile</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                        <span key="t-logout">{{ __('Logout') }}</span></a>
                </div>
            </div>
        </div>
    </div>
</header>
