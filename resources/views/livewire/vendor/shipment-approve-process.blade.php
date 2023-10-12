@push('styles')
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body prod-mini-card-left px-0">
                    <div class="select-product-wrapper">
                        <h4 class="font-size-18 mb-3 ps-4 ">Product List</h4>
                        <table class="table table-prod-select">
                            <tbody>
                                @foreach ($this->shipment->shipmentItems as $key => $shipmentItem)
                                    <tr
                                        class="product-row {{ $selectedProductId == $shipmentItem->id ? 'selected' : '' }}">
                                        <td class="round-count">
                                            <badge class="bg-primary rounded-circle">{{ $key + 1 }}</badge>
                                        </td>
                                        <td class="product-col">
                                            <h5 class="product-title">
                                                <div class="mb-2">{{ $shipmentItem->sku->product->name }}</div>
                                                <div class="cart-product-variants">
                                                    <ul>
                                                        @foreach ($shipmentItem->sku->productAttributes as $productAttribute)
                                                            <li><span>{{ $productAttribute->attribute->name }}:</span>
                                                                {{ $productAttribute->attributeValue->value }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </h5>
                                        </td>
                                        <td class="pe-0">
                                            @if ($shipmentItem->is_verified == 'pending')
                                                <a href="javascript:;"
                                                    wire:click='selectProduct({{ $shipmentItem->id }})'>
                                                    <badge class="bg-info me-4">
                                                        Start
                                                    </badge>
                                                </a>
                                            @elseif($shipmentItem->is_verified == 'verified')
                                                <badge class="bg-success me-4">
                                                    Verified
                                                </badge>
                                            @elseif($shipmentItem->is_verified == 'rejected')
                                                <badge class="bg-danger me-4">
                                                    Rejected
                                                </badge>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr />
                    <div class="mt-3 text-center">
                        <p class="font-size-16 mb-0">Total:
                            ${{ $this->shipment->shipmentItems()->sum('price') }}</p>
                        <h5 class="fw-semibold font-size-18 mb-4">Ready to Pay:
                            ${{ $this->shipment->shipmentItems()->where('is_verified', 'verified')->sum('price') }}</h5>
                        @if ($this->shipment->shipmentItems()->where('is_verified', 'verified')->sum('price') > 0)
                            <button type="button" class="btn btn-primary w-50 mb-3 fw-medium" wire:click='payNow'>Pay
                                Now</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            @if ($selectedProductId)
                <div class="card product-detail">
                    <div class="card-body prod-mini-card">
                        <h4 class="font-size-18 mb-3">Approval Process For</h4>
                        <table class="table table-prod-select">
                            <tbody>
                                <tr class="product-row">
                                    <td>
                                        <div class="product-image-container">
                                            <div class="product-image">
                                                <img src="{{ asset('/assets/images/home/ipad-product.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-col">
                                        <h5 class="product-title">
                                            <div class="mb-2">{{ $this->shipmentItem->sku->product->name }}</div>
                                            <div class="cart-product-variants">
                                                <ul>
                                                    @foreach ($this->shipmentItem->sku->productAttributes as $productAttribute)
                                                        <li><span>{{ $productAttribute->attribute->name }}:</span>
                                                            {{ $productAttribute->attributeValue->value }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                    </td>
                                    <td class="estimated-price">
                                        <p class="mb-0 font-size-16">Estimated Payout:</p>
                                        <h1 class="mt-1 mb-0">${{ number_format($this->shipmentItem->price, 2) }}</h1>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="stepper-outer">
                        @if ($steps == 1)
                            <div class="step-1">
                                <h4 class="font-size-14 mb-3 text-center text-info">Step - 1</h4>
                                <h4 class="font-size-18 mb-3 text-center">Select Product</h4>
                                <div class="select-product-wrapper">
                                    <table class="table table-prod-select">
                                        <thead>
                                            <tr>
                                                <th class="thumbnail-col"></th>
                                                <th class="product-col">Product</th>
                                                <th class="price-col">Price</th>
                                                <th class="qty-col">Quantity</th>
                                                <th class="text-right">Subtotal</th>
                                                <th class="text-right">Verification Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="product-options">
                                            @foreach ($this->shipment->shipmentItems as $key => $shipmentItem)
                                                <tr class="product-row {{ $selectedProductId == $shipmentItem->id ? 'selected' : '' }} {{ $this->checkProductVerification($shipmentItem->id) ? 'prod-verified' : '' }}"
                                                    wire:click='selectProduct({{ $shipmentItem->id }})'>
                                                    <td>
                                                        <figure class="product-image-container">
                                                            <a href="#!" class="product-image">
                                                                <img src="{{ asset('/assets/images/home/ipad-product.png') }}"
                                                                    alt="">
                                                            </a>
                                                        </figure>
                                                    </td>
                                                    <td class="product-col">
                                                        <h5 class="product-title">
                                                            <a href="#!"
                                                                class="mb-2">{{ $shipmentItem->sku->product->name }}</a>
                                                            <div class="cart-product-variants">
                                                                <ul>
                                                                    @foreach ($shipmentItem->sku->productAttributes as $productAttribute)
                                                                        <li><span>{{ $productAttribute->attribute->name }}:</span>
                                                                            {{ $productAttribute->attributeValue->value }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </h5>
                                                    </td>
                                                    <td>${{ number_format($shipmentItem->price, 2) }}</td>
                                                    <td>
                                                        <div class="quantity-wrapper">
                                                            {{ $shipmentItem->quantity }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="subtotal-price">${{ number_format($shipmentItem->price * $shipmentItem->quantity, 2) }}</span>
                                                    </td>
                                                    <td class="text-right">
                                                        @if ($shipmentItem->is_verified == 'pending')
                                                            <badge class="bg-info">
                                                                Pending
                                                            </badge>
                                                        @elseif($shipmentItem->is_verified == 'verified')
                                                            <badge class="bg-success">
                                                                Verified
                                                            </badge>
                                                        @elseif($shipmentItem->is_verified == 'rejected')
                                                            <badge class="bg-danger">
                                                                Rejected
                                                            </badge>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @elseif($steps == 2)
                            <div class="step-2">
                                <h4 class="font-size-14 mb-3 text-center text-info">Step - 2</h4>
                                <h4 class="font-size-18 mb-3 text-center">Verify IMEI</h4>
                                <div class="form-group">
                                    <input type="text" class="form-control" wire:model='IMEINO'
                                        placeholder="Enter IMEI Number" />
                                    @error('IMEINO')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="actions mt-5 d-flex" style="float: right">
                                <button class="btn btn-primary" role="menuitem" wire:click='next("IMEINO")'>
                                    <div wire:loading wire:target="next" class="spinner-border text-gray spinner-button"
                                        role="status" aria-hidden="true"></div>
                                    <div wire:loading.remove wire:target="next">Next</div>
                                </button>
                            </div>
                        @elseif($steps == 3)
                            <div class="step-3">
                                <h4 class="font-size-14 mb-3 text-center text-info">Step - 3</h4>
                                <h4 class="font-size-18 mb-3 text-center">IMEI Lookup</h4>
                                @if ($imeiResponse['result'] == 'failed')
                                    <div class="passed-block">
                                        <i class="bx bxs-x-circle reject"></i>
                                        <div class="content-alter">
                                            <h1>Error</h1>
                                            <p>This device currently has the FMIP activation lock enabled.</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="passed-block">
                                        <i class="bx bxs-check-circle done"></i>
                                        <div class="content-alter">
                                            <h1>Passed</h1>
                                        </div>
                                    </div>
                                @endif
                                <table class="table mobile-info-table">
                                    <tr>
                                        <td>FMIP</td>
                                        <td>{{ ucfirst($imeiResponse['fmip']) }}</td>
                                        <td>CERTID</td>
                                        <td>{{ ucfirst($imeiResponse['certid']) }}</td>
                                    </tr>
                                </table>
                                @if ($imeiResponse['result'] != 'failed')
                                    <h4 class="font-size-18 mb-3 text-left make-modal-text">
                                        IMEI check recognizes this device as
                                        <span class="text-info">
                                            {{ $imeiResponse['makes'][0]['make'] . ' ' . $imeiResponse['makes'][0]['models']['0']['name'] }}.
                                        </span>
                                        Is this device you're trying to trade in?
                                    </h4>
                                @endif
                                @if ($imeiResponse['result'] == 'failed')
                                    <img class="w-100"
                                        src="{{ asset('vendor/approval-process-images/IMEI_LOOKUP_SUCCESS_IMAGE.png') }}" />
                                    <h4 class="font-size-18 mb-3 text-center">Verify IMEI</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" wire:model='IMEINO'
                                            placeholder="Enter IMEI Number" />
                                        @error('IMEINO')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="actions mt-2 d-flex justify-content-center">
                                        <button class="btn btn-primary" role="menuitem" wire:click='verify'>
                                            <div wire:loading wire:target="verify"
                                                class="spinner-border text-gray spinner-button" role="status"
                                                aria-hidden="true"></div>
                                            <div wire:loading.remove wire:target="verify">Re-Verify</div>
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <div class="actions mt-5 d-flex justify-content-between">
                                <button class="btn btn-danger" role="menuitem" wire:click='desclain'>Reject</button>
                                @if ($imeiResponse['result'] != 'failed')
                                    <button class="btn btn-success" role="menuitem"
                                        wire:click='next("IMEI","success")'>Confirm</button>
                                @endif
                            </div>
                        @elseif($steps == 4)
                            <div class="step-4">
                                <h4 class="font-size-14 mb-3 text-center text-info">Step - 4</h4>
                                <h4 class="mb-3 text-center">Can you see obvious physical damage?</h4>
                                <h5 class="font-size-18 mb-3 text-center">Is the screen shattered, cracked, or are
                                    there
                                    parts broken off? (ignore minor scratches
                                    and normal wear and tear) Check the buttons, are they suppose to make a noise but
                                    don't?
                                </h5>
                                <div class="device-lock-outer d-flex justify-content-center">
                                    <button class="btn" wire:click='next("physicalDamage","true")'>Yes</button>
                                    @if (!$this->itemCondBroken)
                                        <button class="btn" wire:click='next("physicalDamage","false")'>No</button>
                                    @endif
                                </div>
                            </div>
                        @elseif($steps == 5)
                            <div class="step-5">
                                <h4 class="font-size-14 mb-3 text-center text-info">Step - 5</h4>
                                <h4 class="mb-3 text-center">Is there any discoloration on the LCD?</h4>
                                <h5 class="font-size-18 mb-3 text-center">
                                    Can you see burn marks, pink hues, white spots, or lines in the screen that aren't
                                    suppose to be there?
                                </h5>
                                <div class="device-lock-outer d-flex justify-content-center">
                                    <button class="btn"
                                        wire:click='next("screenDiscoloration","true")'>Yes</button>
                                    @if (!$this->itemCondBroken)
                                        <button class="btn"
                                            wire:click='next("screenDiscoloration","false")'>No</button>
                                    @endif
                                </div>
                            </div>
                        @elseif($steps == 6)
                            <div class="step-6">
                                <h4 class="font-size-14 mb-3 text-center text-info">Step - 6</h4>
                                <img class="w-100"
                                    src="{{ asset('vendor/approval-process-images/popup_final.png') }}" />
                                <h4 class="font-size-18 mb-3 text-center">
                                    We don't purchase device that are iCloud or Google/Samsung locked
                                </h4>
                                <div class=" d-flex justify-content-center">
                                    <button class="btn btn-success my-3"
                                        wire:click='next("factoryReset","true")'>Factory
                                        reset
                                        complete</button>
                                </div>
                            </div>
                        @elseif($steps == 7)
                            <div class="step-7">
                                <h4 class="font-size-14 mb-3 text-center text-info">Step - 7</h4>
                                <h4 class="font-size-18 mb-3 text-center">Confirm Verification</h4>
                                <div class="user-payouts d-block w-100">
                                    <div class="text-center">
                                        <div class="mb-2">
                                            <i class="mdi mdi-check-circle-outline text-success display-1"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="device-lock-outer d-flex justify-content-center">
                                    <button class="btn" wire:click='confirm'>Confirm</button>
                                </div>
                            </div>
                        @elseif($steps == 8)
                            <div class="step-8" id="DivIdToPrint">
                                <div class="invoice-title">
                                    <div class="float-end font-size-16">
                                        <a href="javascript:;" onclick='printDiv();' role="button"
                                            class="btn btn-primary print-btn"><i class="fa fa-print"></i>
                                            Print</a>
                                    </div>
                                </div>
                                <h4 class="fw-semibold">Order Overview</h4>
                                <div class="d-flex justify-content-between w-100 mt-5 mb-3">
                                    <div class="w-30 float-start">
                                        <h5>Device</h5>
                                        <p class="font-size-13">
                                            {{ $this->shipmentItem->sku->product->name }}
                                            <br />
                                        </p>
                                        <ul class="product-variant">
                                            @foreach ($this->shipmentItem->sku->productAttributes as $productAttribute)
                                                <li><span>{{ $productAttribute->attribute->name }}:</span>
                                                    {{ $productAttribute->attributeValue->value }}
                                                </li>
                                            @endforeach
                                        </ul>
                                        <ul class="product-variant">
                                            <li><span>Price:</span> ${{ number_format($this->shipmentItem->price, 2) }}
                                            </li>
                                        </ul>
                                        <p class="mt-3 fw-bold font-size-13">
                                            IMEI #: <span class="fw-normal">{{ $IMEINO }}</span>
                                        </p>
                                    </div>
                                    <div class="w-30 float-start">
                                        <h5>Customer</h5>
                                        <p class="font-size-13">
                                            {{ $this->shipmentItem->shipment->user->name }}<br />
                                            {{ $this->shipmentItem->shipment->user->email }} <br />
                                            {{ $this->shipmentItem->shipment->user->phone }} <br />
                                        </p>
                                    </div>
                                    <div class="w-30 float-end">
                                        <h5>Address</h5>
                                        <p class="font-size-13">
                                            {{ $this->shipmentItem->shipment->location->name }}<br />
                                            {{ $this->shipmentItem->shipment->location->address }} <br />
                                            @if ($this->shipmentItem->shipment->location->address2)
                                                {{ $this->shipmentItem->shipment->location->address2 }} <br />
                                            @endif
                                            {{ $this->shipmentItem->shipment->location->city . ' ' . $this->shipmentItem->shipment->location->state . ' ' . $this->shipmentItem->shipment->location->zip }}
                                            <br />
                                            United States
                                        </p>
                                    </div>
                                </div>
                                <h4 class=""><i class="bx bx-right-arrow-alt font-size-22 pt-1"></i> Please
                                    Print
                                    and Sign</h4>
                                <p>In order to complete a Product "trade-through" via Gizmogul Recycling Service,
                                    Customer
                                    must accept the following Terms and Conditions as stated herein.
                                </p>
                                <h5 class="font-size-11">Transactions and any claims or disputes between you and
                                    Gizmogul, Inc. :</h5>
                                <ul class="list-group-numbered ps-0">
                                    <li class="mb-3">Customer is the sole owner of the Product or has been authorized
                                        by
                                        the owner of the Product to make all decisions with regard to the disposition of
                                        the
                                        Product, and there are no liens, or security interests in or attached to the
                                        Product
                                        and that no other party has a legal interest in it. Buyer may take reasonable
                                        actions, including utilizing a national lost or stolen goods database, to
                                        determine
                                        if submitted items were ever reported lost or stolen. Products provided and
                                        listed
                                        or reported as stolen may be reported to applicable law enforcement agencies,
                                        and
                                        Customer acknowledges and grants the full right and authority to release any
                                        Customer contact information provided through the Recycling Services to
                                        applicable
                                        law enforcement agencies for further investigation.</li>
                                    <li class="mb-3"> The Product is not counterfeit, lost, stolen or fraudulent.
                                    </li>

                                    <li class="mb-3"> Any item Customer seeks to recycle has not been modified by
                                        Customer and shall not infringe on any third-party intellectual property right
                                        (including copyright, trademarks, patent, trade secrets or other proprietary
                                        right).
                                    </li>

                                    <li class="mb-3">Upon physical receipt of the Product and issuance of the Visa
                                        Prepaid Gift Card, title and ownership in such Product transfers to Buyer and
                                        Customer disclaims any further right, title or interest in and to the Product or
                                        any
                                        items or data contained therein.</li>

                                    <li class="mb-3">Customer acknowledges that it is his or her responsibility to
                                        remove
                                        all personal data from his/her Product, before selling, including SIM card,
                                        removable memory cards, and must data clear the Product, to include a factory
                                        reset.
                                        Buyer is not responsible or liable for the removal of Customer’s personal data.
                                    </li>

                                    <li class="mb-3">Customer agrees that he/she has the sole responsibility, if so
                                        desired, to keep a separate back up copy of any files or data before selling the
                                        Product; and that Customer has taken reasonable steps to eliminate and delete
                                        files
                                        and data that are deemed personal or confidential. Data recovery is not a part
                                        of
                                        the Recycling Services and Buyer accept no responsibility or liability for any
                                        lost
                                        files or data leakage.</li>

                                    <li class="mb-3">This Recycling Service is provided for lawful purposes only, to
                                        the
                                        extent permitted by law, Customer agrees to indemnify Buyer and any of its
                                        directors, officers, employees, affiliates, subsidiaries or agents from and
                                        against
                                        any claims brought against any of them arising from Customer’s breach of the
                                        terms
                                        and conditions of the Recycling Services.</li>

                                    <li class="mb-3">This Recycling Service is void where prohibited or restricted by
                                        law.</li>

                                    <li class="mb-3">The Product quote provided is based on the Customer’s full,
                                        truthful
                                        and accurate responses to the qualification questions as to Product type,
                                        specifications and conditions.</li>

                                    <li class="mb-3">If an online trade initiates in store the customer will receive
                                        payment in the form of a Visa Gift Card. The Visa Gift Card will expire after
                                        two
                                        years and unused funds will be forfeited.</li>
                                </ul>
                                <p>The Recycling Service is provided to Retail Customers by Gizmogul, Inc. as an
                                    independent
                                    third party company. Retailer is not a party in the transaction between Gizmogul,
                                    Inc.
                                    and the Recycling Service Customers. Any and all transactions are solely the
                                    responsibility of Gizmogul, Inc. and Customer. YOU ACKNOWLEDGE AND AGREE THAT THE
                                    RECYCLING SERVICE IS BETWEEN YOU AND GIZMOGUL, INC. ONLY, AND RETAILER IS NOT LIABLE
                                    FOR
                                    AND DOES NOT WARRANT SUCH SERVICE. By using the Recycling Service, you hereby
                                    release
                                    Retailer and its respective directors, employees and agents from any disputes,
                                    claims,
                                    demands, and/or damages (actual or consequential) of every kind, whether known or
                                    unknown, arising out of, or relating to, your use of Gizmogul, Inc. Recycling
                                    Service,
                                    including, without limitation, incomplete or completed transactions and any claims
                                    or
                                    disputes between you and Gizmogul, Inc.
                                </p>
                                <p>
                                <h5>Questions</h5>
                                </p>
                                <p>
                                    Can you see obvious physical damage?
                                    : <strong>{{ ucfirst($data['physicalDamage']) }}</strong>
                                </p>
                                <p>
                                    Is there any discoloration on the LCD? :
                                    <strong>{{ ucfirst($data['screenDiscoloration']) }}</strong>
                                </p>
                                <div class="signature-footer my-5 d-flex">
                                    <p class="position-relative fw-medium font-size-16 ">
                                        <span style="vertical-align: super;">Signature</span>
                                        <input type="text"
                                            style="height: 1px;
                                width: 160px;
                                border:none;
                                border-bottom:1px solid #cfcfcf;
                                display: inline-block;
                                margin-bottom: -5px;"></input>
                                    </p>
                                    <p class="position-relative fw-medium font-size-16 ms-3">
                                        <span style="vertical-align: super;">Date</span>
                                        <input type="text"
                                            style="height: 1px;
                                width: 160px;
                                border:none;
                                border-bottom:1px solid #cfcfcf;
                                display: inline-block;
                                margin-bottom: -5px;"></input>
                                    </p>
                                </div>
                            </div>
                        @elseif($steps == 9)
                            <div class="step-9">
                                <h4 class="font-size-18 mb-3 text-center">How do you want to get paid?</h4>
                                <div class="user-payouts d-block w-100">
                                    <div class="form__radio-group mb-2">
                                        <input type="radio" name="payout_type" id="physical_card"
                                            wire:click='selectPayoutType("digital_payment")' value="digital_payment"
                                            class="form__radio-input">
                                        <label class="form__label-radio" for="physical_card">
                                            <span class="form__radio-button"></span> Physical Card
                                        </label>
                                        @if ($payoutType == 'digital_payment')
                                            <div class="payment-widgets my-3">
                                                <div class="payment-card-area">
                                                    <div class="card-type-img">
                                                        <img src="{{ asset('/vendor/approval-process-images/card-chip.png') }}"
                                                            class="chip" alt="cart-chip" />
                                                        <img src="{{ asset('/vendor/approval-process-images/visa.png') }}"
                                                            class="c-logo" alt="cart-logo" />
                                                    </div>
                                                    <div class="card-number-info">
                                                        <h4 class="text-white">
                                                            <p>Card Number</p>
                                                            <span>xxxx</span>
                                                            <span>xxxx</span>
                                                            <span>xxxx</span>
                                                            <span>xxxx</span>
                                                        </h4>
                                                        <div class="card-holder-area d-flex justify-content-between">
                                                            <h4 class="text-white">
                                                                <p>Cardholder Name</p>
                                                                <span></span>
                                                            </h4>
                                                            {{-- <h4 class="text-white">
                                                            <p>Valid Thru</p>
                                                            <span>{{ $cardholder['expiryMonth'] ?? '' }}/{{ $cardholder['expiryYear'] ?? '' }}</span>
                                                        </h4> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-form-wrapper">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label>Card Number</label>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    wire:model='cardNumber'
                                                                    placeholder="Card Number" />
                                                            </div>
                                                            @error('cardNumber')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    wire:model='confirmCardNumber'
                                                                    placeholder="Confirm Card Number" />
                                                            </div>
                                                            @error('confirmCardNumber')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-12">
                                                            <label>Employee Name</label>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Employee Name"
                                                                    wire:model='cardholder.name' />
                                                            </div>
                                                            @error('cardholder.name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form__radio-group mb-2">
                                        <input type="radio" name="payout_type" id="virtual_card"
                                            class="form__radio-input" value="virtual_card"
                                            wire:click='selectPayoutType("virtual_card")'>
                                        <label class="form__label-radio" for="virtual_card">
                                            <span class="form__radio-button"></span> Virtual Card
                                        </label>
                                        @if ($payoutType == 'virtual_card')
                                            <input type="email" placeholder="ie. Your email address"
                                                wire:model='virtualCard.email' class="form-control">
                                        @endif
                                    </div>
                                    @error('virtualCard.email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @error('payoutType')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="device-lock-outer d-flex justify-content-center mt-4">
                                    <button class="btn" wire:click='confirmPayoutType'>
                                        <div wire:loading wire:target="confirmPayoutType"
                                            class="spinner-border text-primary spinner-button" role="status"
                                            aria-hidden="true"></div>
                                        <div wire:loading.remove wire:target="confirmPayoutType">Confirm</div>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($this->paymentApiRes)
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body prod-mini-card-left px-0">
                        <h4 class="font-size-18 mb-3 ps-4 ">Payment API Response</h4>
                        <hr>
                        <div class="text-center">
                            {!! $paymentApiRes !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function printDiv() {
            window.print();
        }
        window.addEventListener('displayAlert', function() {
            Swal.fire({
                text: "Please print the contract and have customer sign in before issuing a payout.",
                icon: "info",
                confirmButtonColor: "#34c38f",
                confirmButtonText: "Ok",
            }).then(function(t) {

            });
        });

        window.addEventListener('displayPopup', function(event) {
            var item = event.detail;
            Swal.fire({
                text: "We need to downgrade this device to: " + item.product_name +
                    "," + item.attributes.Storage + ", Condition: " + item.attributes.Condition +
                    ". New price is $" + item.price,
                icon: "error",
                showCancelButton: !0,
                cancelButtonColor: "#f46a6a",
                cancelButtonText: "No",
                confirmButtonColor: "#34c38f",
                confirmButtonText: "Yes",
            }).then(function(t) {
                if (t.isConfirmed) {
                    @this.emit('updateShipmentItem');
                } else if (t.isDismissed && t.dismiss == "cancel") {
                    @this.emit('rejectTradeIn');
                }
            });
        });
    </script>
@endpush
