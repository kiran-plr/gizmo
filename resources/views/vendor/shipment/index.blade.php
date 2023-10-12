@extends('layouts.vendor.master')
@section('title', 'GIZMOGUL || Shipments List')
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
                    <h4 class="mb-sm-0 font-size-18">Shipments</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Shipments</a></li>
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
                            <table
                                class="table align-middle table-nowrap table-hover table table-bordered data-table shipment-list-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input check_all" name="check_all" type="checkbox">
                                            </div>
                                        </th>
                                        <th scope="align-middle">Shipment No #</th>
                                        <th class="align-middle">Billing Name</th>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Commission</th>
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
                                                @if ($shipment->status != 're-packaged' && $shipment->notes != '')
                                                    <div class="form-check">
                                                        <input class="form-check-input shipment_id" name="shipment_id"
                                                            value="{{ $shipment->id }}" type="checkbox">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('vendor.shipment.show', $shipment->id) }}">
                                                    {{ $shipment->shipment_no }}
                                                </a>
                                            </td>
                                            <td>{{ $shipment->user->name }}</td>
                                            <td>
                                                {{ date('m/d/Y, g:ia', strtotime($shipment->created_at)) }}
                                            </td>
                                            <td>
                                                ${{ number_format($shipment->commission, 2) }}
                                            </td>
                                            <td>
                                                ${{ number_format($shipment->total, 2) }}
                                            </td>
                                            <td>
                                                @if ($shipment->notes != '')
                                                    @php
                                                        $shipments = App\Models\Shipment::whereIn('id', explode(',', $shipment->notes['shipment_id']))->get();
                                                        $qty = 0;
                                                        foreach ($shipments as $item) {
                                                            $qty += $item->shipmentItems->count();
                                                        }
                                                    @endphp

                                                    {{ $qty }}
                                                @else
                                                    {{ $shipment->shipmentItems()->sum('quantity') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($shipment->status === 'pending')
                                                    <span class="badge badge-pill badge-soft-warning font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status === 'approved')
                                                    <span class="badge badge-pill badge-soft-success font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status === 'shipped')
                                                    <span class="badge badge-pill badge-soft-secondary font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status === 'delivered')
                                                    <span class="badge badge-pill badge-soft-info font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status === 'received')
                                                    <span class="badge badge-pill badge-soft-info font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status === 'completed')
                                                    <span class="badge badge-pill badge-soft-success font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status === 're-packaged')
                                                    <span class="badge badge-pill badge-soft-primary font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status === 'please-ship')
                                                    <span class="badge badge-pill badge-soft-pink font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status === 'cancel')
                                                    <span class="badge badge-pill badge-soft-danger font-size-11">
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
                                                        href="{{ route('vendor.shipment.show', $shipment->id) }}">View</a>
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
    <form method="POST" action="{{ route('vendor.shipment.group-shipments') }}" id="group_shipments">
        @csrf
        <input type="hidden" name="shipment_ids" id="shipment_ids" />
    </form>
@endsection
@push('scripts')
    <script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('.data-table').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 9]
                }, {
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    "className": "text-center",
                }],
                "dom": 'l<"toolbar">frtip',
                initComplete: function() {
                    $("div.toolbar").html(
                        '<a href="javascript:;" role="button" class="btn btn-primary group-shipments-button">Group Shipments</a>'
                    );
                }
            });

            $('.group-shipments-button').on('click', function() {
                var shipmentId = [];
                $.each($("input[name='shipment_id']:checked"), function() {
                    shipmentId.push($(this).val());
                });

                var arrToStr = shipmentId.toString();
                var newShipmentNo = "{{ $newShipmentNo }}";
                $('#shipment_ids').val(arrToStr);
                if (parseInt(shipmentId.length) < 2) {
                    Swal.fire({
                        title: "Shipment is not selected",
                        text: "Please select atleast two record",
                        icon: "warning",
                        confirmButtonColor: "#34c38f",
                        confirmButtonText: "Ok",

                    })
                } else {
                    Swal.fire({
                            title: "Are you sure ?",
                            text: "Want to group selected shipments ?",
                            icon: "warning",
                            confirmButtonColor: "#34c38f",
                            confirmButtonText: "Ok",

                        })
                        .then((willGroup) => {
                            if (willGroup.isConfirmed) {
                                Swal.fire({
                                        title: "Device grouped successfully ",
                                        html: "Group Shipment No # " + newShipmentNo +
                                            " <br /> Please ship devices together",
                                        icon: "info",
                                        confirmButtonColor: "#34c38f",
                                        confirmButtonText: "Ok",

                                    })
                                    .then((willGroup) => {});
                                setTimeout(function() {
                                    $('#group_shipments').submit();
                                }, 1000);
                            }
                        });
                }
            });

            $('.check_all').on('click', function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });
    </script>
@endpush
