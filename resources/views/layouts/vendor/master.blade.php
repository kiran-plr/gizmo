<!doctype html>
<html lang="en">

<!-- Head Start -->
@include('layouts.vendor.head')
<!-- Head End -->

<body data-topbar="light" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Header Start -->
        @include('layouts.vendor.header')
        <!-- Header Start -->

        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                    @if (auth()->check() && count(auth()->user()->locations) > 0)
                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none"
                                        href="{{ route('vendor.dashboard') }}" id="topnav-dashboard" role="button">
                                        <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboards</span>
                                    </a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none"
                                        href="{{ route('vendor.shipment.trade-ins') }}" id="topnav-uielement"
                                        role="button">
                                        <i class="fas fa-people-carry"></i>
                                        <span key="t-ui-elements"> Trade-ins</span>
                                    </a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none"
                                        href="{{ route('vendor.shipment.index') }}" id="topnav-uielement"
                                        role="button">
                                        <i class="bx bxs-truck me-2"></i>
                                        <span key="t-ui-elements"> Shipments</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </nav>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                @yield('main-content')
            </div>
        </div>

        <!-- end main content-->

        @include('layouts.vendor.footer')

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->

    <script src="{{ asset('/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('/assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('/assets/js/pages/datatables.init.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    @stack('scripts')

    @livewireScripts
</body>

</html>
