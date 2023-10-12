@push('styles')
    <script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>
@endpush
<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                    <form id="product-add">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3" x-data="{ open: false }">
                                    <label for="productname">Product Name</label>
                                    <input id="productname" wire:model.lazy='productArr.name' name="productname"
                                        type="text" class="form-control" maxlength="40" minlength="5" required
                                        {{ $product ? 'readonly disabled' : '' }} placeholder="Product Name">
                                    @error('productArr.name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3" x-data="{ open: false }">
                                    <label for="productslug">Product Slug</label>
                                    <input id="productslug" wire:model.lazy='productArr.slug' name="productslug"
                                        type="text" class="form-control" maxlength="40" minlength="5" required
                                        {{ $product ? 'readonly disabled' : '' }} placeholder="Product Slug">
                                    @error('productArr.slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="producttype">Product Type</label>
                                    <select class="form-control" wire:model.lazy='product.type' required>
                                        <option value="">Select Product Type</option>
                                        <option value="configurable">Configurable</option>
                                        <option value="simple">Simple</option>
                                    </select>
                                    @error('product.type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                <div class="mb-3" x-data="{ open: false }">
                                    <label for="name">Attribute Family</label>
                                    <select class="form-control" wire:model='productArr.attribute_family_id' required
                                        {{ $product ? 'readonly disabled' : '' }} x-on:change='$wire.emit("changeAttributeFamily")'>
                                        <option value="">Select Attribute Family</option>
                                        @foreach ($this->attributeFamilies as $key => $family)
                                            <option value="{{ $family->id }}">
                                                {{ $family->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('productArr.attribute_family_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Category</label>
                                    <select class="form-control" wire:model.lazy='productArr.category_id' required
                                        {{ $product ? 'readonly disabled' : '' }}>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('productArr.category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="control-label">Brand</label>
                                    <select class="form-control" wire:model.lazy='productArr.brand_id' required
                                        {{ $product ? 'readonly disabled' : '' }}>
                                        <option value="" selected>Select Brand</option>
                                        @foreach ($this->brands as $key => $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('productArr.brand_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="productdesc">Product Description</label>
                                    <textarea class="form-control" wire:model.lazy='productArr.description' id="productdesc" rows="3"
                                        placeholder="Product Description" required></textarea>
                                    @error('productArr.description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Configuration</h4>
                    <form class="repeater" enctype="multipart/form-data">
                        @csrf
                        <div data-repeater-list="group-a">
                            <div class="row" x-data="{ open: false }">
                                @if (isset($productArr['attribute_family_id']) && !$productId)
                                    @foreach ($this->attributes as $key => $attribute)
                                        <div class="mb-3 col-lg-3">
                                            <label for="name">{{ $attribute->name }}</label>
                                            <select class="form-control" multiple
                                                x-on:click='$wire.emit("newAttrSelect")'
                                                wire:model='attrvalues.{{ $attribute->id }}' required>
                                                <option value="" disabled>Select Value</option>
                                                @foreach ($attribute->attributeValues as $key => $value)
                                                    <option
                                                        value="{{ serialize(['id' => $value->id, 'slug' => $value->slug]) }}">
                                                        {{ $value->value }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    @endforeach
                                @endif
                                @if (count($attrvalues) > 0)
                                    <div class="mb-3 col-lg-10">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>SKU</th>
                                                    <th>Status</th>
                                                    <th>Price ($)</th>
                                                    <th>Retail Price ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="configuration">
                                                @php
                                                    $count = 0;
                                                    $attrValue = [];
                                                @endphp
                                                @foreach ($this->combinationsArr as $sku => $value)
                                                    @foreach ($value as $key => $attr)
                                                        @php $attrValue[$key] =  $attr['id']; @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td class="configuration-sku">
                                                            <span>{{ $sku }}</span>
                                                        </td>
                                                        <td>
                                                            @php
                                                                $statusValidationMess = 'configuration.' . $count . '.status';
                                                            @endphp
                                                            <select class="form-control"
                                                                wire:model='{{ $statusValidationMess }}'>
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                            @error($statusValidationMess)
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            @php
                                                                $priceValidationMess = 'configuration.' . $count . '.price';
                                                            @endphp
                                                            <input type="number" step="0.01" x:data="{0.0}"
                                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                maxlength="8"
                                                                wire:model='{{ $priceValidationMess }}'
                                                                class="form-control price"
                                                                x-on:keyup='dataChange("{{ $count }}","{{ $sku }}","{{ serialize($attrValue) }}")'
                                                                required value="0" />
                                                            @error($priceValidationMess)
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <input type="hidden"
                                                                wire:model='configuration.{{ $count }}.attrvalues'
                                                                value="{{ serialize($attrValue) }}" />
                                                        </td>
                                                        <td>
                                                            @php
                                                                $retailPriceValidationMess = 'configuration.' . $count . '.retail_price';
                                                            @endphp
                                                            <input type="number" step="0.01" x:data="{0.0}"
                                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                maxlength="8"
                                                                wire:model='{{ $retailPriceValidationMess }}'
                                                                class="form-control price" required value="0" />
                                                            @error($retailPriceValidationMess)
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    @if (isset($productArr['attribute_family_id']) && !empty($productArr['attribute_family_id']))
                                        <span class="invalid-feedback">
                                            <strong>Please select attribute value for assign value</strong>
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Images</h4>
                    <form class="repeater" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" wire:ignore>
                            <div class="input-group">
                                <div class="upload-selecter input-group-btn">
                                    <span>Choose Images</span>
                                    <a id="lfm" data-input="thumbnail" data-preview="holder"
                                        data-value="product" class="upload-selecter-btn">
                                        Select File
                                    </a>
                                </div>
                                <input id="thumbnail" wire:model='photos' readonly="readonly" class="form-control"
                                    type="text" name="photo" autocomplete="off">
                            </div>
                            <label id="thumbnail-error" class="text-denager error_message" for="thumbnail"></label>
                            <div class="row remove-icon-overlay">
                                <ul class="sortimage-order productImagePre ui-sortable">
                                </ul>
                            </div>
                            <div class="row removeCateImg remove-icon-overlay">
                                <div class="col">
                                    <div class="plus-box mt-3">
                                        <span><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="plus-box mt-3">
                                        <span><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="plus-box mt-3">
                                        <span><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="plus-box mt-3">
                                        <span><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="plus-box mt-3">
                                        <span><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="plus-box mt-3">
                                        <span><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-primary waves-effect waves-light"
                            wire:click.prevent='{{ $productId ? 'updateProduct' : 'createProduct' }}'>
                            Save Changes
                        </button>
                        <button type="button" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('#lfm').filemanager('file');

        function dataChange(count, sku, attrValue) {
            @this.set('configuration.' + count + '.sku', sku);
            @this.set('configuration.' + count + '.attribute', attrValue);
        }

        $(document).on('change', '#productname', function(e) {
            @this.emit('setSlug');
            @this.emit('slugChange');
        });
        $(document).on('change', '#productslug', function(e) {
            @this.emit('slugChange');
        });
    </script>
@endpush
