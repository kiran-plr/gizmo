@push('styles')
    <!-- Sweet Alert-->
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
<div>
    <div class="row cart-wrapper">
        <div class="col-lg-8 col-md-7">
            <div class="cart-table-container">
                <table class="table table-cart">
                    <thead>
                        <tr>
                            <th class="thumbnail-col"></th>
                            <th class="product-col">Product</th>
                            <th class="price-col">Price</th>
                            <th class="qty-col">Quantity</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $product)
                            <tr class="product-row">
                                <td>
                                    <figure class="product-image-container">
                                        <a href="javascript:;" {{-- wire:click='removeProduct({{ $key }})' --}} class="product-image">
                                            <img src="{{ asset('/assets/images/home/ipad-product.png') }}"
                                                alt="">
                                        </a>
                                        <a href="javascript:;" class="btn-remove icon-cancel remove-product"
                                            data-id="{{ $key }}" title="Remove Product"></a>
                                    </figure>
                                </td>
                                <td class="product-col">
                                    <h5 class="product-title">
                                        <a href="product.html">{{ $product['product_name'] }}</a>
                                        <div class="cart-product-variants">
                                            <ul>
                                                @foreach ($product['attributes'] as $carrier => $value)
                                                    <li><span>{{ ucfirst($carrier) }}:</span>
                                                        {{ !empty($value['value']) ? $value['value'] : '' }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </h5>
                                </td>
                                <td>${{ number_format($product['sku_price'], 2) }}</td>
                                <td>
                                    <div class="quantity-wrapper">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-number"
                                                    wire:click='removeQuantity({{ $key }})'>
                                                    <span class="bx bx-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="quant" class="form-control input-number"
                                                value="{{ $product['quantity'] }}" min="8" max="30">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-number"
                                                    wire:click='addQuantity({{ $key }})'>
                                                    <span class="bx bx-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right"><span
                                        class="subtotal-price">${{ number_format($product['total_price'], 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4 col-md-5">
            <div class="cart-summary">
                <h3>CART TOTALS</h3>
                <table class="table table-totals">
                    <tfoot>
                        <tr>
                            <td><b>Total</b></td>
                            <td>
                                <b>${{ number_format(AppHelper::getGrandTotal($this->data,2), 2) }}</b>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class="checkout-methods">
                    <a href="javascript:;" class="btn btn-block btn-dark" wire:click.prevent='submit'>Get Paid Today
                        <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- Sweet Alerts js -->
    <script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).on('click', '.remove-product', function() {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't remove this product!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#34c38f",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Submit",
            }).then(function(t) {
                if (t.isConfirmed) {
                    @this.emit('removeProduct', id);
                }
            });
        });
    </script>
@endpush
