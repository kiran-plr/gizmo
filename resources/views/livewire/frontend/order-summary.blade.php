<div class="form-card sell-product-info-wrapper order-summary-list">
    <h3>You’ve got <span>${{ number_format(AppHelper::getGrandTotal($data,$shipmentType), 2) }}</span> in trade-in value</h3>
    <div class="cart-table-container ">
        <table class="table table-cart">
            <thead>
                <tr>
                    <th class="thumbnail-col"></th>
                    <th class="product-col">Product</th>
                    <th class="price-col">Price</th>
                    <th class="qty-col text-center">QTY</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $product)
                    <tr class="product-row">
                        <td>
                            <figure class="product-image-container">
                                <a href="#!" class="product-image">
                                    <img src="{{ asset('/assets/images/home/ipad-product.png') }}" alt="">
                                </a>
                            </figure>
                        </td>
                        <td class="product-col">
                            <h5 class="product-title">
                                <a href="javascript:;">{{ $product['product_name'] }}</a>
                            </h5>
                            <div class="cart-product-variants">
                                <ul>
                                    @foreach ($product['attributes'] as $carrier => $value)
                                        <li><span>{{ ucfirst($carrier) }}:</span>
                                            {{ !empty($value['value']) ? $value['value'] : '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>
                        <td>${{ number_format(AppHelper::getProductPrice($product,$shipmentType), 2) }}</td>
                        <td>
                            <div class="quantity-wrapper">
                                <div class="input-group">
                                    <span>{{ $product['quantity'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-right"><span
                                class="subtotal-price">${{ number_format(AppHelper::getProductTotalPrice($product,$shipmentType), 2) }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="cart-summary">
        <table class="table table-totals">
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><b>${{ number_format(AppHelper::getGrandTotal($data,$shipmentType), 2) }}</b></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
