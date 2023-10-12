@extends('layouts.vendor.master')
@section('title', 'GIZMOGUL || Trade-ins List')
@push('styles')
    <!-- DataTables -->
    <link href="{{ asset('/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Trade-ins</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Trade-ins</a></li>
                            <li class="breadcrumb-item active">List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-hover table table-bordered data-table">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="align-middle">Trade-In #</th>
                                        <th class="align-middle">Billing Name</th>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Total</th>
                                        <th class="align-middle">Total QTY</th>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Shipping Method</th>
                                        <th scope="align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shipments as $key => $shipment)
                                        <tr>
                                            <td>
                                                <a href="{{ route('vendor.shipment.trade-ins.show', $shipment->id) }}">
                                                    {{ $shipment->shipment_no }}
                                                </a>
                                            </td>
                                            <td>{{ $shipment->user->name }}</td>
                                            <td>
                                                {{ date('m/d/Y, g:ia', strtotime($shipment->created_at)) }}
                                            </td>
                                            <td>
                                                ${{ number_format($shipment->total, 2) }}
                                            </td>
                                            <td>
                                                {{ $shipment->shipmentItems()->sum('quantity') }}
                                            </td>
                                            <td>
                                                @if ($shipment->status == 'pending')
                                                    <span class="badge badge-pill badge-soft-warning font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fas fa-people-carry"></i> Drop-off <br>
                                                @if ($shipment->location)
                                                    {{ $shipment->location->name }},
                                                    {{ $shipment->location->city }},
                                                    {{ $shipment->location->state }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="">
                                                    <a class="btn btn-info" role="button"
                                                        href="{{ route('vendor.shipment.trade-ins.show', $shipment->id) }}">View</a>
                                                    <form action="{{ route('vendor.shipment.cancel', $shipment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <a class="btn btn-danger cancel" role="button"
                                                            href="javascript:;">Cancel</a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('.data-table').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [7]
                }, {
                    "targets": [0, 1, 2, 3, 4, 5, 6],
                    "className": "text-center",
                }],
                "order": [0, "desc"],
                "dom": 'l<"toolbar">frtip',
                initComplete: function() {
                    $("div.toolbar").html(
                        '<a href="{{ route('vendor.shipment.create') }}" role="button" class="btn btn-primary new-shipment-button">New Trade-In</a>'
                    );
                }
            });

            $('.cancel').on('click', function(e) {
                var form = $(this).closest('form');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Want to cancel this shipment?",
                    icon: "error",
                    showCancelButton: !0,
                    cancelButtonColor: "#f46a6a",
                    cancelButtonText: "Cancel",
                    confirmButtonColor: "#34c38f",
                    confirmButtonText: "Submit",
                }).then(function(t) {
                    if (t.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
