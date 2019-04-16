{{--@php dd($cart); @endphp--}}
<main class="checkout-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="shipping-address">
                    <h3>Shipping address</h3>
                    <div class="form-group btn-group address-list col-md-12" data-toggle="buttons">
                        <div class="row">
                            <label class="btn btn-block active col-sm-12">
                                <input type="radio" name="address" id="option1" checked>
                                <span>Milan Markovic</span>
                                <span>Bore Stankovica Podgorica</span>
                                <span>81000 Montenegro</span>
                                <span>+38267279358</span>
                            </label>

                            <label class="btn btn-block col-sm-12">
                                <input type="radio" name="address" id="option2">
                                <span>Milan Markovic</span>
                                <span>Bore Stankovica 2 Podgorica</span>
                                <span>81000 Montenegro,</span>
                                <span>+38267279358</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="shipping-methods">
                    <h3>SHIPPING METHODS</h3>
                    <div class="form-group btn-group address-list" data-toggle="shipping-buttons">
                        <label class="btn btn-block active col-12">
                            <input type="radio" name="methods" id="dhl" checked>
                            <span>DHL</span>
                        </label>

                        <label class="btn btn-block col-12">
                            <input type="radio" name="methods" id="post">
                            <span>POST EXPRESS</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="carpet-items">
                    <h3>ORDER REVIEW</h3>

                    <table class="table span12">

                        <thead>
                        <tr>
                            <th style="width: 70%">Product</th>
                            <th style="width: 10%">Qty</th>
                            <th style="width: 10%; text-align: right;">Subtotal</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php($total = 0)

                        @foreach($cart as $item)
                            @php($total += $item->quantity * $item->price)
                            <tr>
                                <td class="product-info">
                                    <img src="{{isset($item->featureImage) && $item->featureImage != '' ? $item->featureImage : 'img/blackgirl.jpg'}}"
                                         alt="">
                                    <div class="product-name">{{Lang::locale() == 'en' ? $item->product_name : $item->product_name_sr}}</div>
                                    <div class="atributes">
                                        @foreach($item->combinationInfo as $combinationInfoItem)
                                            <dt class="label">{{$combinationInfoItem->name}}</dt>
                                            <dd class="value">{{$combinationInfoItem->value}}</dd>
                                        @endforeach

                                    </div>
                                </td>
                                <td class="product-qty">
                                    <input type="number" class="input-text qty text" step="1" min="1"
                                           max="{{$item->stock}}"
                                           name="quantity"
                                           value="{{$item->quantity}}" title="Qty" size="4" pattern="[0-9]*"
                                           inputmode="numeric">

                                </td>
                                <td class="product-price">
                                    <span class="value">{{$item->price}}</span>
                                    <span class="value-symbol">€</span>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <table id="checkout-total-table">
                        <tr class="totals sub">
                            <th>Cart Subtotal</th>
                            <td class="amount">
                                <span class="value">{{number_format((float)$total, 2, '.', '')}}</span>
                                <span class="value-symbol">€</span>
                            </td>
                        </tr>

                        <tr class="shipping-total">
                            <th>Shipping</th>
                            <td class="amount">
                                <span class="value">20.00</span>
                                <span class="value-symbol">€</span>
                            </td>
                        </tr>

                        <tr class="total-price">
                            <th>Total price</th>
                            <td class="amount">
                                <span class="value">{{number_format((float)$total + 20, 2, '.', '')}}</span>
                                <span class="value-symbol">€</span>
                            </td>
                        </tr>
                    </table>

                    <button id="checkout-button-place-order" type="button" class="btn btn-primary submit">CHECKOUT TO
                        PAYMENT
                    </button>

                </div>
            </div>
        </div>
    </div>
    </div>

</main>