@extends('layouts.admin.master')
@section('title', 'GIZMOGUL || Shipment Details')
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Shipment Detail</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Shipment</a></li>
                            <li class="breadcrumb-item active">Detail</li>
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
                        <div class="invoice-title">
                            <h4 class="float-end font-size-16">Shipment # {{ $shipment->shipment_no }}</h4>
                            <div class="mb-4">
                                <img src="{{ asset('/assets/images/logos/gizmogul-logo.png') }}" alt="logo"
                                    height="20">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <address class="mt-2 mt-sm-0">
                                    @if ($shipment->shipment_type != '1')
                                        <strong>Shipped To:</strong><br />
                                        <span>{{ $shipment->user->name }}</span><br />
                                        <span>{{ $shipment->address->address }}</span><br />
                                        @if ($shipment->address->apartment)
                                            <span>{{ $shipment->address->apartment }}</span><br />
                                        @endif
                                        <span>{{ $shipment->address->city . ', ' . $shipment->address->state . ' ' . $shipment->address->zip }}</span><br />
                                    @else
                                        <strong>Drop off to:</strong><br />
                                        <span>{{ $shipment->location->name }}</span><br />
                                        <span>{{ $shipment->location->address }}</span><br />
                                        @if ($shipment->location->address2)
                                            <span>{{ $shipment->location->address2 }}</span><br />
                                        @endif
                                        <span>{{ $shipment->location->city . ', ' . $shipment->location->state . ' ' . $shipment->location->zip }}</span><br />
                                    @endif
                                </address>
                            </div>
                            @if ($shipment->shipment_type == '1')
                                <div class="col-sm-3">
                                    <address class="mt-2 mt-sm-0">
                                        <strong>Customer Info:</strong><br />
                                        <span>{{ $shipment->user->name }}</span><br />
                                        @if ($shipment->address)
                                            <span>{{ $shipment->address->address }},</span><br />
                                            @if ($shipment->address->apartment)
                                                <span>{{ $shipment->address->apartment }},</span><br />
                                            @endif
                                            <span>{{ $shipment->address->city . ', ' . $shipment->address->state . ' ' . $shipment->address->zip }}</span><br />
                                        @endif
                                    </address>
                                </div>
                            @endif
                            <div class="col-sm-3">
                                @if ($shipment->userPayout)
                                    <address class="mt-2 mt-sm-0">
                                        <strong>Payout Info:</strong><br />
                                        <span>Payout Method <strong>:</strong>
                                            {{ $shipment->userPayout->userPayoutMethod->name }}</span><br />
                                        <span>Amount <strong>:</strong> ${{ $shipment->userPayout->amount }}</span><br />
                                    </address>
                                @endif
                            </div>
                            <div class="col-sm-3 text-sm-end">
                                <address>
                                    <strong>Shipment Date:</strong><br>
                                    {{ \Carbon\Carbon::parse($shipment->created_at)->format('F d, Y') }}<br><br>
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">
                                <address>
                                    <strong>Payment Method:</strong><br>
                                    @if ($shipment->userPayoutMethod)
                                        {{ $shipment->userPayoutMethod->name }}<br>
                                    @else
                                        Visa ending **** 4242<br>
                                        {{ $shipment->user->email }}
                                    @endif
                                </address>
                            </div>
                            <div class="col-sm-3 mt-3">
                                <address>
                                    <strong>Status:</strong><br>
                                    @if ($shipment->status == 'pending')
                                        <span class="badge badge-pill badge-soft-warning font-size-11">
                                            {{ ucfirst($shipment->status) }}
                                        </span>
                                    @elseif($shipment->status == 'approved')
                                        <span class="badge badge-pill badge-soft-success font-size-11">
                                            {{ ucfirst($shipment->status) }}
                                        </span>
                                    @elseif($shipment->status == 'shipped')
                                        <span class="badge badge-pill badge-soft-secondary font-size-11">
                                            {{ ucfirst($shipment->status) }}
                                        </span>
                                    @elseif($shipment->status == 'delivered')
                                        <span class="badge badge-pill badge-soft-info font-size-11">
                                            {{ ucfirst($shipment->status) }}
                                        </span>
                                    @elseif($shipment->status == 'received')
                                        <span class="badge badge-pill badge-soft-info font-size-11">
                                            {{ ucfirst($shipment->status) }}
                                        </span>
                                    @elseif($shipment->status == 'completed')
                                        <span class="badge badge-pill badge-soft-success font-size-11">
                                            {{ ucfirst($shipment->status) }}
                                        </span>
                                    @elseif($shipment->status == 're-packaged')
                                        <span class="badge badge-pill badge-soft-primary font-size-11">
                                            {{ ucfirst($shipment->status) }}
                                        </span>
                                    @elseif($shipment->status == 'please-ship')
                                        <span class="badge badge-pill badge-soft-pink font-size-11">
                                            {{ ucfirst($shipment->status) }}
                                        </span>
                                    @elseif($shipment->status == 'cancel')
                                        <span class="badge badge-pill badge-soft-danger font-size-11">
                                            {{ ucfirst($shipment->status) }}
                                        </span>
                                    @endif
                                </address>
                            </div>
                            @if ($shipment->shipment_status)
                                <div class="col-sm-3 mt-3">
                                    <address>
                                        <strong>Shipment Status:</strong><br>
                                        <span class="badge badge-pill badge-soft-info font-size-11">
                                            {{ ucfirst($shipment->shipment_status) }}
                                        </span>
                                    </address>
                                </div>
                            @endif
                        </div>
                        <div class="py-2 mt-3">
                            <h3 class="font-size-15 fw-bold">Shipment summary</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($shipment->notes != '')
                                        @php
                                            $shipments = App\Models\Shipment::whereIn('id', explode(',', $shipment->notes['shipment_id']))->get();
                                            $count = 1;
                                        @endphp
                                        @foreach ($shipments as $key => $value)
                                            @foreach ($value->shipmentItems as $key => $shipmentItem)
                                                <tr>
                                                    <td>{{ $count }}</td>
                                                    <td>{{ $shipmentItem->sku->product->name }}</td>
                                                    <td>
                                                        ${{ $shipmentItem->price }}
                                                    </td>
                                                    <td>{{ $shipmentItem->quantity }}</td>
                                                    <td class="text-end">
                                                        ${{ number_format($shipmentItem->price * $shipmentItem->quantity, 2) }}
                                                    </td>
                                                </tr>
                                                @php $count++; @endphp
                                            @endforeach
                                        @endforeach
                                    @else
                                        @foreach ($shipment->shipmentItems as $key => $shipmentItem)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $shipmentItem->sku->product->name }}</td>
                                                <td>
                                                    ${{ $shipmentItem->price }}
                                                </td>
                                                <td>{{ $shipmentItem->quantity }}</td>
                                                <td class="text-end">
                                                    ${{ number_format($shipmentItem->price * $shipmentItem->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td colspan="4" class="text-end">Total</td>
                                        <td class="text-end">${{ $shipment->sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="border-0 text-end">
                                            <strong>Commission</strong>
                                        </td>
                                        <td class="border-0 text-end">${{ $shipment->commission }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="border-0 text-end">
                                            <strong>Grand Total</strong>
                                        </td>
                                        <td class="border-0 text-end">
                                            <h4 class="m-0">${{ $shipment->total }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-print-none">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light me-1"><i
                                        class="fa fa-print"></i></a>
                                @if ($shipment->status == 'pending')
                                    <a href="{{ route('admin.shipment.change-status', ['id' => $shipment->id, 'status' => 'shipped']) }}"
                                        class="btn btn-success w-md waves-effect waves-light">Mark as Shipped</a>
                                @elseif($shipment->status == 'shipped')
                                    <a href="{{ route('admin.shipment.change-status', ['id' => $shipment->id, 'status' => 'delivered']) }}"
                                        class="btn btn-success w-md waves-effect waves-light">Mark as Delivered</a>
                                @elseif($shipment->status == 'delivered')
                                    <a href="{{ route('admin.shipment.change-status', ['id' => $shipment->id, 'status' => 'cancel']) }}"
                                        class="btn btn-danger w-md waves-effect waves-light">Deny</a>
                                    <a href="{{ route('admin.shipment.change-status', ['id' => $shipment->id, 'status' => 'received']) }}"
                                        class="btn btn-success w-md waves-effect waves-light">Approve </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div>
@endsection
