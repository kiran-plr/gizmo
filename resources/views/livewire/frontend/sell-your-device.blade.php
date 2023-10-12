<form id="msform" wire:submit.prevent="submitForm">
    <!-- progressbar -->
    <div class="progresbar-wrapper">
        <button type="button" name="previous" wire:click="previous" class="previous action-button-previous"
            value="Previous"><i class='bx bx-left-arrow-alt'></i></button>
        <div class="progress">
            {{-- <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0"
                aria-valuemax="100" style="width:{{ $progress }}%"></div> --}}
        </div>
    </div>

    @if ($this->sectionId == 1)
        <fieldset wire:loading.class.add="disabled" id="sec1" class="product-info">
            <div class="form-card">
                <h3>What category is your device? <i class='bx bx-info-circle'></i></h3>
                <div class="sell-device-info">
                    @foreach ($categories as $category)
                        <button type="button" name="category_id" wire:click='next("category",{{ $category->id }})'
                            data-id="{{ $category->id }}"
                            class="next action-button  {{ $category->id == $categoryId ? 'active' : '' }}"
                            value="Next">{{ $category->name }}</button>
                    @endforeach
                </div>
            </div>
        </fieldset>
    @elseif ($this->sectionId == 2)
        <fieldset wire:loading.class.add="disabled" id="sec2" class="product-info">
            <div class="form-card">
                <h3>What brand is your device? <i class='bx bx-info-circle'></i></h3>
                <div class="sell-device-info">
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
                <div class="sell-device-info products">
                    @foreach ($this->products as $product)
                        <button type="button" name="product_id" wire:click='next("product",{{ $product->id }})'
                            data-id="{{ $product->id }}"
                            class="next action-button product {{ $product->id == $productId ? 'active' : '' }}"
                            value="Next">{{ $product->name }}</button>
                    @endforeach
                </div>
            </div>
        </fieldset>
    @elseif (!empty($this->productId) && !empty($this->attributes))
        <fieldset wire:loading.class.add="disabled" id="sec{{ $this->sectionId }}" class="product-info">
            <div class="form-card">
                @if ($this->attributes['slug'] == 'condition')
                    <h3>What condition is your device in? <i class='bx bx-info-circle'></i></h3>
                @else
                    <h3>{{ $this->attributes['attribute_question'] }} <i class='bx bx-info-circle'></i></h3>
                @endif
                <div class="sell-device-info">
                    @foreach ($this->attributes['variants'] as $key => $value)
                        <button type="button" name="next"
                            wire:click='next("{{ $this->attributes['slug'] }}",{{ $key }},"{{ $value }}", "{{ $this->attributes['id'] }}")'
                            class="next action-button @if ($this->attributes['description']) action-list-btn @endif {{ isset($attributeValueIds[$cartQty][$this->sectionId]) && $attributeValueIds[$cartQty][$this->sectionId] == $key ? 'active' : '' }}"
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
                <div class="form-card sell-product-info-wrapper">
                    <h3>You’ve got <span>${{ $grandTotal }}</span> in trade-in
                        value</h3>
                    @foreach ($this->data as $key => $sku)
                        <div class="sell-product-info">
                            <div class="sell-product-img">
                                <img src="{{ asset('/assets/images/home/ipad-product.png') }}" alt="">
                                @if (count($data) > 1)
                                    <a href="javascript:;" class="btn-remove icon-cancel remove-product"
                                        wire:click='removeProduct({{ $key }})' title="Remove Product"></a>
                                @endif
                            </div>
                            <div class="sell-content">
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
                                                <input type="text" name="quant" class="form-control input-number"
                                                    value="{{ $sku['quantity'] }}" min="8" max="30">
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

                <div class="form-card sell-product-info-wrapper">
                    <div class="sell-product-info">
                        <button type="submit" class="action-button" value="Next">Get paid
                            today</button>
                        <button type="button" class="action-button add-more-devices" wire:click='addMoreDevices'>Add
                            more
                            devices</button>
                    </div>
                </div>
            @endif
        </fieldset>
        <hr />
        <p class="add-note-text">Your device will be checked once we receives it. If the information you've provided is
            inaccurate, we may send you a new offer.</p>
    @endif
</form>
