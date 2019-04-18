<div class="col-md-4">
    <div class="carpet-items">
        <div id = "alert_placeholder"></div>
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

            @foreach($cart as $key => $item)
                @php($total += $item->quantity * $item->price)
                <tr id="row-{{$key}}">
                    <td class="product-info">
                        <a href="" onclick="removeFromCart(event, {{json_encode($item)}}, {{$key}})" class="close"><i class="fas fa-times"></i></a>
                        <a href="{{route("product.single", ["id"=>$item->product_id])}}">
                        <img src="{{isset($item->featureImage) && $item->featureImage != '' ? $item->featureImage : 'img/blackgirl.jpg'}}"
                             alt="">
                        </a>
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

@section('after_scripts')
    <script>
        function removeFromCart(event, item, key) {
            event.preventDefault();


            $.ajax({
                url: '{{route('removeFromCart')}}',
                type: 'POST',
                data: {
                    item: JSON.stringify(item)
                },
                xhrFields: {
                    withCredentials: true
                }
            }).done(function (response) {
                $("tr#row-" + key).remove();
                var date = new Date();
                var minutes = 30;
                date.setTime(date.getTime() + (minutes * 60 * 1000));
                document.cookie = "cart" + "=" + response + ";path=/;expires=" + date.toGMTString();
                bootstrap_alert.success("Proizvod uklonjen iz korpe.");
                getCartTotal();
            }).fail(function (error) {
                bootstrap_alert.warning("Greska prilikom uklanjanja iz korpe.");
            });
        }

        bootstrap_alert = {};

        bootstrap_alert.warning = function(message) {
            $('#alert_placeholder').html('<div class="alert alert-danger" role="alert"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
        }

        bootstrap_alert.success = function(message) {
            $('#alert_placeholder').html('<div class="alert alert-success" role="alert"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
        }

    </script>
@endsection