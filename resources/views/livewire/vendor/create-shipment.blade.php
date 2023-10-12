<form wire:id="LmqWElgyiTiDVihMu4ED" id="msform" wire:submit.prevent="submitForm">
    <!-- progressbar -->
    @if (!$customerInfo)
        <div class="progresbar-wrapper">
            <button type="button" name="previous" wire:click="previous" class="previous action-button-previous"
                value="Previous"><i class="bx bx-left-arrow-alt"></i></button>
        </div>
    @endif
    @if ($this->sectionId == 1)
        <fieldset wire:loading.class.add="disabled" id="sec1" class="product-info">
            <div class="form-card">
                <h3>What category is your device? <i class="bx bx-info-circle"></i></h3>
                <div class="shipment-create-info">
                    @foreach ($categories as $category)
                        <button type="button" name="category_id" wire:click='next("category",{{ $category->id }})'
                            data-id="{{ $category->id }}"
                            class="next action-button  {{ $category->id == $categoryId ? 'active' : '' }}"
                            value="Next">{{ $category->name }}</button>
                    @endforeach
                </div>
        </fieldset>
    @elseif ($this->sectionId == 2)
        <fieldset wire:loading.class.add="disabled" id="sec2" class="product-info">
            <div class="form-card">
                <h3>What brand is your device? <i class='bx bx-info-circle'></i></h3>
                <div class="shipment-create-info">
                    @foreach ($this->brands as $brand)
                        <button type="button" name="brand_id" wire:click='next("brand",{{ $brand->id }})'
                            data-id="{{ $brand->id }}"
                            class="next action-button brand {{ $brand->id == $brandId ? 'active' : '' }}"
                            value="Next">{{ $brand->name }}</button>
                    @endforeach
                </div>
            </div>
        </fieldset>
    @elseif ($this->sectionId == 3)
        <fieldset wire:loading.class.add="disabled" id="sec3" class="product-info">
            <div class="form-card">
                <h3>What model is your device? <i class='bx bx-info-circle'></i></h3>
                <div class="shipment-create-info products">
                    @foreach ($this->products as $product)
                        <button type="button" name="product_id" wire:click='next("product",{{ $product->id }})'
                            data-id="{{ $product->id }}"
                            class="next action-button product {{ $product->id == $productId ? 'active' : '' }}"
                            value="Next">{{ $product->name }}</button>
                    @endforeach
                </div>
            </div>
        </fieldset>
    @elseif ($customerInfo)
        <div class="m-auto d-block text-center shipinfo-stepper">

            <div class="row justify-content-center">
                <div class="col-md-6 text-start">
                    <h2>Customer informations</h2>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-md-3">
                    <div class="mb-3 text-start">
                        <input type="text" class="form-control" placeholder="First name"
                            wire:model.lazy='customer.first_name' autocomplete="off" maxlength="30" minlength="3"
                            id="first_name">
                        @error('customer.first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3 text-start">
                        <input type="text" class="form-control" placeholder="Last name"
                            wire:model.lazy='customer.last_name' id="last_name" autocomplete="off" maxlength="30"
                            minlength="3">
                        @error('customer.last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="mb-3 text-start">
                        <input type="email" class="form-control" placeholder="Email" wire:model='customer.email'
                            id="email" autocomplete="off" maxlength="30" minlength="10">
                        @error('customer.email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6 text-start my-3">
                    <h2>Shipping informations</h2>
                </div>
            </div>

            @if ($this->address)
                <div class="row justify-content-center">
                    <div class="col-md-6 text-start">
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
                    </div>
                </div>
            @endif

            @if ($this->address)
                <div class="row justify-content-center">
                    <div class="col-md-6 text-start">
                        <div class="form__radio-group mb-2">
                            <input type="radio" class="form__radio-input" name="address" value="new_address"
                                id="new_address" @if ($this->addressType == 'new') checked @endif
                                wire:click='setAddressType("new")'>
                            <label class="form__label-radio" for="new_address">
                                <span class="form__radio-button"></span>Add new address
                            </label>
                        </div>
                    </div>
                </div>
            @endif

            @if ($this->addressType == 'new')
                <div class="new-address">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="mt-3 text-start">
                                <input type="text" class="form-control" wire:model.lazy='shipping.address'
                                    placeholder="Address" id="address" autocomplete="off" maxlength="70"
                                    minlength="10">
                                @error('shipping.address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="mt-3 text-start">
                                <input type="text" class="form-control" wire:model.lazy='shipping.apartment'
                                    id="apartment autocomplete="off"" placeholder="Apartment, suite, etc (optional)"
                                    maxlength="70">
                                @error('shipping.apartment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="mt-3 text-start">
                                <input type="text" class="form-control" wire:model.lazy='shipping.city'
                                    id="city" placeholder="City" autocomplete="off" maxlength="30">
                                @error('shipping.city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <div class="mt-3 text-start">
                                <input type="text" class="form-control" wire:model.lazy='shipping.state'
                                    placeholder="State" id="state" autocomplete="off" maxlength="30">
                                @error('shipping.state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mt-3 text-start">
                                <input type="number" class="form-control" wire:model.lazy='shipping.zip'
                                    placeholder="Zip code" id="zip_code" autocomplete="off">
                                @error('shipping.zip')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="mt-3 text-start">
                                <div class="country-select-wrapper">
                                    <div class="btn-group flag-select">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="defaultDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true"
                                            aria-expanded="false">
                                            <img class="flag-img"
                                                src="{{ asset('/assets/images/flags/png/' . $this->country->flag) }}">
                                            <span>{{ $this->country->phone_code }}</span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="defaultDropdown" style="">
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

            <button type="button" class="btn btn-primary w-25 mb-5 mt-3 cust-info-btn"
                wire:loading.class='disable-button' wire:click.prevent='storeUserInformation'>
                <div wire:loading wire:target="storeUserInformation"
                    class="spinner-border text-primary spinner-button" role="status" aria-hidden="true"></div>
                <div wire:loading.remove wire:target="storeUserInformation">Continue</div>
            </button>
        </div>
    @elseif (!empty($this->productId) && !empty($this->attributes))
        <fieldset wire:loading.class.add="disabled" id="sec{{ $this->sectionId }}" class="product-info">
            <div class="form-card">
                @if ($this->attributes['slug'] == 'condition')
                    <h3>What condition is your device in? <i class='bx bx-info-circle'></i></h3>
                @else
                    <h3>{{ $this->attributes['attribute_question'] }} <i class='bx bx-info-circle'></i></h3>
                @endif
                <div class="shipment-create-info">

                    @foreach ($this->attributes['variants'] as $key => $value)
                        <button type="button" name="next"
                            wire:click='next("{{ $this->attributes['slug'] }}",{{ $key }},"{{ $value }}", "{{ $this->attributes['id'] }}")'
                            class="next action-button  @if ($this->attributes['description']) action-list-btn @endif  {{ isset($attributeValueIds[$cartQty][$this->sectionId]) && $attributeValueIds[$cartQty][$this->sectionId] == $key ? 'active' : '' }}"
                            value="Next">
                            @if ($this->attributes['slug'] == 'condition')
                                <div class="sell-ul-list">
                                    <h5 class="sell-title-text text-start">{{ $value }}</h5>
                                    @if ($value == 'Excellent')
                                        <ul>
                                            <li>Device is like new and in flawless condition</li>
                                            <li>Device is working properly with no functional problems</li>
                                            <li>No Chips or Cracks on front or back of device</li>
                                            <li>No LCD damage or defects (no missing pixels, burns or aftermarket LCD)
                                            </li>
                                            <li>Devices must be free of any lock or financial obligations</li>
                                        </ul>
                                    @elseif($value == 'Good')
                                        <ul>
                                            <li>Device has normal signs of use but no major cosmetic damage</li>
                                            <li>Device is working properly with no functional problems</li>
                                            <li>No Chips or Cracks on front or back of device</li>
                                            <li>No LCD damage or defects (no missing pixels, burns or aftermarket LCD)
                                            </li>
                                            <li>Devices must be free of any lock or financial obligations</li>
                                        </ul>
                                    @elseif($value == 'Broken')
                                        <ul>
                                            <li>Device has heavy signs of use and/or cosmetic damage</li>
                                            <li>Device has Functional Issues (broken buttons, speakers, microphone)</li>
                                            <li>Device may have small dents, cracks, chips and or excessive scratching
                                            </li>
                                            <li>Device may have LCD damage (discoloration, missing pixels or not
                                                working)
                                            </li>
                                            <li>Devices must be free of any lock or financial obligations</li>
                                        </ul>

                                        <span>Please note: we do not purchase devices with extreme damage or missing
                                            components.</span>
                                    @endif
                                </div>
                            @else
                                {{ $value }}
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </fieldset>
    @else
        <fieldset id="sec-{{ $this->sectionId }}" class="product-info">
            @if ($this->attributeIds && $this->filterSku)
                <div class="form-card shipment-create-info-wrapper">
                    <h3>You’ve got <span>${{ $grandTotal }}</span> in trade-in
                        value</h3>
                    @foreach ($this->data as $key => $sku)
                        <div class="shipment-create-product-info">
                            <div class="shipment-create-product-img">
                                <img src="{{ asset('/assets/images/home/ipad-product.png') }}" alt="">
                                @if (count($data) > 1)
                                    <a href="javascript:;" class="btn-remove icon-cancel remove-product"
                                        wire:click='removeProduct({{ $key }})' title="Remove Product"></a>
                                @endif
                            </div>
                            <div class="shipment-create-product-content">
                                <ul>
                                    <li><span>Device:</span>
                                        {{ $sku['product_name'] }}
                                    </li>
                                    @foreach ($sku['attributes'] as $carrier => $value)
                                        <li><span>{{ ucfirst($carrier) }}:</span>
                                            {{ !empty($value['value']) ? $value['value'] : '' }}</li>
                                    @endforeach
                                    <li>
                                        <div class="quantity-wrapper">
                                            <label>Quantity</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-number"
                                                        wire:click='removeQuantity({{ $key }})'>
                                                        <span class="bx bx-minus"></span>
                                                    </button>
                                                </span>
                                                <input type="text" name="quant"
                                                    class="form-control input-number" value="{{ $sku['quantity'] }}"
                                                    min="8" max="30">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-number"
                                                        wire:click='addQuantity({{ $key }})'>
                                                        <span class="bx bx-plus"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-card shipment-create-info-wrapper">
                    <div class="shipment-create-product-info">
                        <button type="submit" class="action-button" value="Next">Continue</button>
                    </div>
                </div>
            @endif
        </fieldset>
        <hr />
        <div class="form-card shipment-create-info-wrapper">
            <div class="shipment-create-product-info">
                <button type="button" class="action-button add-more-devices" wire:click='addMoreDevices'>Add more
                    devices</button>
            </div>
        </div>
    @endif
</form>
