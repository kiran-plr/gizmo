@extends('layouts.user.master')
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
                            <div class="col-sm-8">
                                <address class="mt-2 mt-sm-0">
                                    @if ($shipment->shipment_type != '1')
                                        <strong>Shipped To:</strong><br />
                                        <span>{{ $shipment->user->name }}</span><br />
                                        <span>{{ $shipment->address->address }}</span><br />
                                        @if ($shipment->address->apartment)
                                            <span>{{ $shipment->address->address }}</span><br />
                                        @endif
                                        <span>{{ $shipment->address->city . ', ' . $shipment->address->state . ' ' . $shipment->address->zip }}</span><br />
                                        <span>{{ $shipment->address->country->iso3 }}</span><br />
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
                            <div class="col-sm-4 text-sm-end">
                                <address>
                                    <strong>Shipment Date:</strong><br>
                                    {{ \Carbon\Carbon::parse($shipment->created_at)->format('F d, Y') }}<br><br>
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-3">
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
                                    @foreach ($shipment->shipmentItems as $key => $shipmentItem)
                                        <tr>
                                            <td>{{ $shipmentItem->id }}</td>
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
                                    <tr>
                                        <td colspan="4" class="text-end">Total</td>
                                        <td class="text-end">${{ $shipment->sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="border-0 text-end">
                                            <strong>Tax</strong>
                                        </td>
                                        <td class="border-0 text-end">${{ $shipment->tax }}</td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
@endsection
