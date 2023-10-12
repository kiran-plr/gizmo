<div class="payment-method-list">
    <h2>How do you want to get paid?</h2>
    <form id="shipment-type">
        <ul>
            <li wire:click='selectShipmentType(1)' class="{{ $shipmentType == 1 ? 'active' : '' }}">
                <div class="list-img">
                    <img src="{{ asset('/assets/images/home/instant.png') }}" alt="">
                </div>
                <div class="list-content">
                    <span>Instant Pay</span>
                    <p>Drop off your item and get paid the very same day.</p>
                </div>
                <div class="list-price">
                    <span>${{ number_format(AppHelper::getGrandTotal($this->data, 1), 2) }}</span>
                </div>
            </li>
            <li wire:click='selectShipmentType(2)' class="{{ $shipmentType == 2 ? 'active' : '' }}">
                <div class="list-img">
                    <img src="{{ asset('/assets/images/home/regular.png') }}" alt="">
                </div>
                <div class="list-content">
                    <span>Regular Pay</span>
                    <p>Ship your item and get paid after we received it.</p>
                </div>
                <div class="list-price">
                    <span>${{ number_format(AppHelper::getGrandTotal($this->data, 2), 2) }}</span>
                </div>
                <div class='user-payouts d-block w-100'>
                    <hr>
                    <label class="form-check-label mb-4 fs-4" for="userPayouts">How do you want to receive
                        money?</label>
                    <div class="form__radio-group mb-2">
                        <input type="radio" name="size" id="paypal" class="form__radio-input"
                            wire:click='selectUserPayoutMethod("paypal")'>
                        <label class="form__label-radio" for="paypal" class="form__radio-label">
                            <span class="form__radio-button"></span> Paypal
                        </label>
                    </div>
                    @if ($payoutMethod == 'paypal')
                        <div class="form__radio-group mb-4">
                            <input type="email" class="form-control" wire:model='email' placeholder="Email Address">
                            @error('email')
                                <div class='text-danger mt-2'>{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <div class="form__radio-group mb-2">
                        <input type="radio" name="size" id="digital_payment" class="form__radio-input"
                            wire:click='selectUserPayoutMethod("digital_payment")'>
                        <label class="form__label-radio" for="digital_payment" class="form__radio-label">
                            <span class="form__radio-button"></span> Digital Payment
                        </label>
                    </div>
                    <div class="form__radio-group mb-2">
                        <input type="radio" name="size" id="check" class="form__radio-input"
                            wire:click='selectUserPayoutMethod("check")'>
                        <label class="form__label-radio" for="check" class="form__radio-label">
                            <span class="form__radio-button"></span> Check
                        </label>
                    </div>
                    @error('payoutMethod')
                        <div class='text-danger mt-2'>{{ $message }}</div>
                    @enderror
                    {{-- @foreach ($payoutMethods as $key => $method)
                        <div class="form__radio-group mb-2">
                            <input type="radio" name="size" id="{{ $method->type }}" class="form__radio-input"
                                wire:click='selectUserPayoutMethod({{ $method->id }})'>
                            <label class="form__label-radio" for="{{ $method->type }}" class="form__radio-label">
                                <span class="form__radio-button"></span> {{ $method->name }}
                            </label>
                        </div>
                    @endforeach --}}
                </div>
            </li>
        </ul>
        <button type="button" class="btn btn-primary" wire:loading.class='disable-button'
            wire:click.prevent='submitShipmentType'>
            <div wire:loading wire:target="submitShipmentType" class="spinner-border text-primary spinner-button"
                role="status" aria-hidden="true"></div>
            <div wire:loading.remove wire:target="submitShipmentType">Continue</div>
        </button>
    </form>
</div>
