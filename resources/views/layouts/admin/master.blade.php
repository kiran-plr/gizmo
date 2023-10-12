<!doctype html>
<html lang="en">

<!-- Head Start -->
@include('layouts.admin.head')

<link href="{{ asset('/admin/css/custom.css') }}" rel="stylesheet" type="text/css" />
<!-- Head End -->

<body data-topbar="light" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Header Start -->
        @include('layouts.admin.header')
        <!-- Header Start -->

        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('admin.dashboard') }}"
                                    id="topnav-dashboard" role="button">
                                    <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboards</span>
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="javascript:;" id="topnav-pages"
                                    role="button">
                                    <i class="bx bxs-user me-2"></i><span key="t-apps">User Management</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                    <a href="{{ route('admin.user.index') }}" class="dropdown-item" key="t-chat">User
                                        List</a>
                                    <a href="{{ route('admin.user.createOrEdit') }}" class="dropdown-item"
                                        key="t-chat">Add User</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none"
                                    href="{{ route('admin.location.index') }}" id="topnav-pages" role="button">
                                    <i class="fas fa-map-marker-alt me-2"></i><span key="t-apps">Location
                                        Management</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                    <a href="{{ route('admin.location.index') }}" class="dropdown-item"
                                        key="t-chat">Location List</a>
                                    <a href="{{ route('admin.location.edit') }}" class="dropdown-item"
                                        key="t-chat">Location Add</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('admin.product.index') }}"
                                    id="topnav-pages" role="button">
                                    <i class='bx bxl-product-hunt me-2'></i><span key="t-apps">Products</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                    <a href="{{ route('admin.product.index') }}" class="dropdown-item"
                                        key="t-chat">Products List</a>
                                    <a href="{{ route('admin.product.createOrEdit') }}" class="dropdown-item"
                                        key="t-chat">Product Add</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none"
                                    href="{{ route('admin.shipment.index') }}" id="topnav-pages" role="button">
                                    <i class='bx bxs-package me-2'></i><span key="t-apps">Shipments</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                    <a href="{{ route('admin.shipment.index') }}" class="dropdown-item"
                                        key="t-chat">Shipment List</a>
                                    <a href="{{ route('admin.shipment.cancelShipments') }}" class="dropdown-item"
                                        key="t-chat">Cancelled Shipment List</a>
                                </div>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0);"
                                    id="topnav-pages" role="button">
                                    <i class='bx bxl-wallet me-2'></i><span key="t-apps">Payouts</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                    <a href="{{ route('admin.payout.index', 'draft') }}" class="dropdown-item"
                                        key="t-chat">Pending List</a>
                                    <a href="{{ route('admin.payout.index', 'completed') }}" class="dropdown-item"
                                        key="t-chat">Completed List</a>
                                </div>
                            </li>

                        </ul>
                    </div>
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

        @include('layouts.admin.footer')

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @include('layouts.admin.scripts')

    <!-- Required datatable js -->
    <script src="{{ asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('/assets/js/pages/datatables.init.js') }}"></script>

    @stack('scripts')

    @livewireScripts
</body>

</html>
