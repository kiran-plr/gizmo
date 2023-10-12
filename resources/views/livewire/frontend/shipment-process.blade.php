<div>
    <!------------------------ Personal Information Section Start ------------------------>
    @if ($personalInformationDisplay)
        <form id="shipping-from" wire:key='shipping-form'>
            @if (!$this->loginForm)
                <h2>Personal informations</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="First name"
                                wire:model.lazy='user.first_name' autocomplete="off" maxlength="30" minlength="3"
                                {{ AppHelper::isUser() ? 'disabled' : '' }} id="first_name">
                            @error('user.first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Last name"
                                wire:model.lazy='user.last_name' id="last_name" autocomplete="off" maxlength="30"
                                {{ AppHelper::isUser() ? 'disabled' : '' }} minlength="3">
                            @error('user.last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" wire:model='user.email'
                                {{ AppHelper::isUser() ? 'disabled' : '' }} id="email" autocomplete="off"
                                maxlength="30" minlength="10">
                            @error('user.email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @elseif ($this->loginForm && !$this->shippingInfoForm)
                <div class="shipping-info-from login-form p-0" wire:key='login-form'>
                    <h2>Login</h2>
                    <span class="text-danger">
                        Your entered email address is already exist, Please sign in.
                    </span>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="email" class="form-control @error('loginArr.email') is-invalid @enderror"
                                    name="email" id="login_email" placeholder="Enter email" disabled readonly
                                    wire:model='loginArr.email' required>
                                @error('loginArr.email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="float-end">
                                    <a href="{{ route('password.request') }}" class="text-muted">
                                        Forgot password?</a>
                                </div>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password"
                                        class="form-control @error('loginArr.password') is-invalid @enderror"
                                        wire:model='loginArr.password' name="password" placeholder="Enter password"
                                        aria-label="Password" aria-describedby="password-addon" autocomplete="off"
                                        autofocus required>
                                    <button class="btn btn-light" type="button" id="password-addon"
                                        style="box-shadow: 0px 2px 2px #ddd;">
                                        <i class="mdi mdi-eye-outline"></i></button>
                                    @error('loginArr.password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($this->shippingInfoForm)
                <h2>Shipping informations</h2>
                @if ($this->address)
                    <div class="form__radio-group mb-2">
                        <input type="radio" class="form__radio-input" name="address" value="old_address"
                            id="old_address" @if ($this->addressType == 'old') checked @endif
                            wire:click='setAddressType("old")'>
                        <label class="form__label-radio" for="old_address">
                            <span class="form__radio-button"></span> Use exisitng address
                        </label>
                        @if ($this->addressType == 'old')
                            <div class="saved-address">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul>
                                            <li><strong>Name</strong>: {{ $this->address->name }}</li>
                                            <li><strong>Address</strong>:
                                                <span>{{ $this->address->address }},</span><br />
                                                @if ($this->address->apartment)
                                                    <span>{{ $this->address->apartment }},</span><br />
                                                @endif
                                                <span>{{ $this->address->city }},</span>
                                                <span>{{ $this->address->state . ' ' . $this->address->zip }}</span>
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="form__radio-group mb-2">
                    @if ($this->address)
                        <input type="radio" class="form__radio-input" name="address" value="new_address"
                            id="new_address" @if ($this->addressType == 'new') checked @endif
                            wire:click='setAddressType("new")'>
                        <label class="form__label-radio" for="new_address">
                            <span class="form__radio-button"></span>Add new address
                        </label>
                    @endif
                    @if ($this->addressType == 'new')
                        <div class="new-address">
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="First name"
                                            wire:model.lazy='shipping.first_name' autocomplete="off" maxlength="30"
                                            minlength="3" id="shipping_first_name">
                                        @error('shipping.first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Last name"
                                            wire:model.lazy='shipping.last_name' id="shipping_last_name"
                                            autocomplete="off" maxlength="30" minlength="3">
                                        @error('shipping.last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email"
                                            wire:model.lazy='shipping.email' id="shipping_email" autocomplete="off"
                                            maxlength="30" minlength="10">
                                        @error('shipping.email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" wire:model.lazy='shipping.address'
                                            placeholder="Address" id="address" autocomplete="off" maxlength="70"
                                            minlength="10">
                                        @error('shipping.address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                            wire:model.lazy='shipping.apartment' id="apartment autocomplete="off""
                                            placeholder="Apartment, suite, etc (optional)" maxlength="70">
                                        @error('shipping.apartment')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" wire:model.lazy='shipping.city'
                                            id="city" placeholder="City" autocomplete="off" maxlength="30">
                                        @error('shipping.city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" wire:model.lazy='shipping.state'
                                            placeholder="State" id="state" autocomplete="off" maxlength="30">
                                        @error('shipping.state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="number" class="form-control" wire:model.lazy='shipping.zip'
                                            placeholder="Zip code" id="zip_code" autocomplete="off">
                                        @error('shipping.zip')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="country-select-wrapper">
                                            <div class="btn-group flag-select">
                                                <button class="btn btn-secondary dropdown-toggle checkout-btn"
                                                    type="button" id="defaultDropdown" data-bs-toggle="dropdown"
                                                    data-bs-auto-close="true" aria-expanded="false">
                                                    <img class="flag-img"
                                                        src="{{ asset('/assets/images/flags/png/' . $this->country->flag) }}">
                                                    <span>{{ $this->country->phone_code }}</span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="defaultDropdown"
                                                    style="">
                                                    @foreach ($this->countries as $country)
                                                        @if ($country->iso3 == 'USA')
                                                            <a href="javascript:;" class="flag-item"
                                                                wire:click="setCountry('{{ $country->id }}')">
                                                                <li
                                                                    class="{{ $country->id == $this->country->id ? 'active' : '' }}">
                                                                    <img class="flag-img"
                                                                        src="{{ asset('/assets/images/flags/png/' . $country->flag) }}">{{ $country->name }}
                                                                    <span>{{ $country->phone_code }}</span>
                                                                </li>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <input type="text" id="mobile_code" class="form-control"
                                                wire:model.lazy='shipping.phone' placeholder="Phone Number"
                                                autocomplete="off">
                                        </div>
                                        @error('shipping.phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            @if ($this->loginForm || ($this->shippingInfoForm && !auth()->check()))
                <div class="row" wire:key='recaptcha'>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div wire:ignore>
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display(['data-callback' => 'callback']) !!}
                            </div>
                            @error('recaptcha')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
            @if ($this->loginForm)
                <button class="btn btn-primary waves-effect waves-light checkout-btn" wire:click='login'
                    type="button">
                    <div wire:loading wire:target="login" class="spinner-border text-primary spinner-button"
                        role="status" aria-hidden="true">
                    </div>
                    <div wire:loading.remove wire:target="login">Log In</div>
                </button>
            @else
                <button type="button" class="btn btn-primary checkout-btn" wire:loading.class='disable-button'
                    wire:click.prevent='storeUserInformation'>
                    <div wire:loading wire:target="storeUserInformation"
                        class="spinner-border text-primary spinner-button" role="status" aria-hidden="true"></div>
                    <div wire:loading.remove wire:target="storeUserInformation">Continue</div>
                </button>
            @endif
        </form>
    @endif
    <!------------------------ Personal Information Section End------------------------>

    <!------------------------ Shipment Type Section Start ------------------------>
    @if ($shipmentTypeDisplay)
        <x-frontend.shipment-type :shipmentType="$shipmentType" :payoutMethod="$payoutMethod" />
    @endif
    <!------------------------ Shipment Type Section End------------------------>
</div>
@push('scripts')
    <!-- auth-2-carousel init -->
    <script type="text/javascript">
        function callback() {
            return new Promise(function(resolve, reject) {
                if (grecaptcha === undefined) {
                    alert('Recaptcha non definito');
                    reject();
                }
                var response = grecaptcha.getResponse();
                @this.set('recaptcha', response);
            });
        }
        $(document).on("click", "#password-addon", function() {
            0 < $(this).siblings("input").length && ("password" == $(this).siblings("input").attr("type") ? $(this)
                .siblings("input").attr("type", "input") : $(this).siblings("input").attr("type", "password"));
        });

        window.addEventListener('loginSuccess', function(e) {
            $('.sign-in-link').hide();
            $('.user-logged-in-links').html(
                '<a href="javascript:;" class="me-2 text-black fs-4 user-login-toggle">\
                            <i class="bx bx-user"></i></a>\
                                <ul class="user-select-menu">\
                                    <li>\
                                        <a href="{{ route('user.dashboard') }}">\
                                            <i class="fas fa-home fa-sm fa-fw mr-2 orange-color"></i>\
                                            Dashboard\
                                        </a>\
                                    </li>\
                                    <li>\
                                        <a href="{{ route('user.password.change.index') }}">\
                                            <i class="fas fa-key fa-sm fa-fw mr-2 orange-color"></i>\
                                            Change Password\
                                        </a>\
                                    </li>\
                                    <li>\
                                        <a href="{{ route('logout') }}">\
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 orange-color"></i>\
                                            Logout\
                                        </a>\
                                    </li>\
                                </ul>');
        });
    </script>
@endpush
