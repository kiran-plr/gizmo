@extends('layouts.admin.master')
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
@endpush
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Cancelled Shipments</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Cancelled Shipment</a></li>
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
                                                <a href="{{ route('admin.shipment.show', $shipment->id) }}">
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
                                                        foreach ($shipments as $shipment) {
                                                            $qty += $shipment->shipmentItems->count();
                                                        }
                                                    @endphp

                                                    {{ $qty }}
                                                @else
                                                    {{ $shipment->shipmentItems()->sum('quantity') }}
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-danger font-size-11">
                                                    {{ ucfirst($shipment->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($shipment->shipment_type == 1)
                                                    <i class="fas fa-people-carry"></i> Drop-off <br>
                                                    @if ($shipment->location)
                                                        <a
                                                            href="{{ route('admin.location.show', $shipment->location_id) }}">{{ $shipment->location->name }},
                                                            {{ $shipment->location->city }},
                                                            {{ $shipment->location->state }}</a>
                                                    @endif
                                                @else
                                                    <i class="fas fa-barcode"></i> Ship
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle card-drop"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.shipment.show', $shipment->id) }}">View</a>
                                                    </div>
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
    <script type="text/javascript">
        $(function() {
            $('.data-table').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [8]
                }, {
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                    "className": "text-center",
                }],
                "order": [0, "desc"]
            });
        });
    </script>
@endpush
