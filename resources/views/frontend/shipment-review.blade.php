@extends('frontend.layouts.master')
@section('content')
    <!-- shipping information -->
    <section class="shipping-info-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-5 mb-lg-0">
                    <div class="order-summary">
                        <p><i class="fas fa-people-carry"></i> Trade-in Confirmation</p>
                        <h3>Great! <span>{{ $address->user ? $address->user->name : $address->name }}</span>, everything
                            is ready to go. </h3>
                        @if ($shipmentData['shipment_type'] == 1)
                            <h4>You will receive a confirmation email soon with your device trade-in location details.
                                Please
                                confirm the location you selected is correct.</h4>
                        @else
                            <h4>You will receive a confirmation email soon with your device trade-in details. Please
                                confirm all your information is correct.</h4>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <table class="ship-info">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td><span>{{ $address->user ? $address->user->name : $address->name }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>
                                                <span>
                                                    {{ $address->address }}
                                                </span>
                                                @if ($address->address2 || $address->apartment)
                                                    <span>{{ $address->address2 ?? $address->apartment }}</span>,
                                                @endif
                                                <span>
                                                    {{ $address->city . ' ' . $address->zip }},
                                                </span>
                                                <span>
                                                    {{ $address->state . ' ' . $address->phone }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Type</td>
                                            <td>
                                                <span>{{ $shipmentData['shipment_type'] == 1 ? 'Drop Off' : 'Ship To' }}</span>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="back-btn-group">
                            <a href="{{ $shipmentData['shipment_type'] == 1 ? route('locations') : route('shipment-process') }}"
                                role="button" class="btn go-back-btn btn-default">Go
                                back</a>
                            <form method="POST" action="{{ route('confirm-location') }}" class="confirm-button m-auto">
                                @csrf
                                <button type="submit" class="btn confirm-btn btn-success w-100">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="order-summary">
                        <p><i class='bx bx-shopping-bag'></i> Shipment summary</p>
                        <livewire:frontend.order-summary :data="$data" :shipmentType="$shipmentData['shipment_type']">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
