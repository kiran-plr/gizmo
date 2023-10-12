<form id="shipping-from">
    <h2>Contact informations</h2>
    <div class="form-group">
        <input type="email" class="form-control" placeholder="Email" wire:model.lazy='shipping.email' id="email"
            autocomplete="off" maxlength="30" minlength="10">
        @error('shipping.email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <h2>Shipping informations</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="First name"
                    wire:model.lazy='shipping.first_name' autocomplete="off" maxlength="30" minlength="3"
                    id="first_name">
                @error('shipping.first_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Last name" wire:model.lazy='shipping.last_name'
                    id="last_name" autocomplete="off" maxlength="30" minlength="3">
                @error('shipping.last_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" wire:model.lazy='shipping.address' placeholder="Address"
            id="address" autocomplete="off" maxlength="70" minlength="10">
        @error('shipping.address')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <input type="text" class="form-control" wire:model.lazy='shipping.apartment'
            id="apartment autocomplete="off"" placeholder="Apartment, suite, etc (optional)" maxlength="70">
        @error('shipping.apartment')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <input type="text" class="form-control" wire:model.lazy='shipping.city' id="city" placeholder="City"
            autocomplete="off" maxlength="30">
        @error('shipping.city')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" class="form-control" wire:model.lazy='shipping.state' placeholder="State"
                    id="state" autocomplete="off" maxlength="30">
                @error('shipping.state')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="number" class="form-control" wire:model.lazy='shipping.zip' placeholder="Zip code"
                    id="zip_code" autocomplete="off">
                @error('shipping.zip')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="country-select-wrapper">
            <div class="btn-group flag-select">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="defaultDropdown"
                    data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                    <img class="flag-img" src="{{ asset('/assets/images/flags/png/' . $this->country->flag) }}">
                    <span>{{ $this->country->phone_code }}</span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="defaultDropdown" style="">
                    @foreach ($this->countries as $country)
                        @if ($country->iso3 == 'USA')
                            <a href="javascript:;" class="flag-item" wire:click="setCountry('{{ $country->id }}')">
                                <li class="{{ $country->id == $this->country->id ? 'active' : '' }}">
                                    <img class="flag-img"
                                        src="{{ asset('/assets/images/flags/png/' . $country->flag) }}">{{ $country->name }}
                                    <span>{{ $country->phone_code }}</span>
                                </li>
                            </a>
                        @endif
                    @endforeach
                </ul>
            </div>
            <input type="text" id="mobile_code" class="form-control" wire:model.lazy='shipping.phone'
                placeholder="Phone Number" autocomplete="off">
        </div>
        @error('shipping.phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <button type="button" class="btn btn-primary" wire:loading.class='disable-button'
        wire:click.prevent='storeShippingData'>
        <div wire:loading wire:target="storeShippingData" class="spinner-border text-primary spinner-button"
            role="status" aria-hidden="true"></div>
        <div wire:loading.remove wire:target="storeShippingData">Continue</div>
    </button>
</form>
