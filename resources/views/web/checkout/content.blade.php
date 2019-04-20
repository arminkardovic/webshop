{{--@php dd($cart); @endphp--}}
<main class="checkout-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
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

            <div class="col-md-4">
                <div class="payment-method">
                    <h3>Payment method</h3>

                    <div class="btn-group cards payment-way" data-toggle="buttons">

                        <label class="btn btn-primary visa">
                            <input type="radio" name="options" id="option1">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                        </label>

                        <label class="btn btn-primary mastercard">
                            <input type="radio" name="options" id="option2">

                            <i class="fas fa-hand-holding-usd"></i>
                        </label>

                        <label class="btn btn-primary paypal">
                            <input type="radio" name="options" id="option3">
                            <i class="fab fa-cc-paypal"></i>
                        </label>

                    </div>

                </div>
                <div class="gift-card">
                    <h3>Apply Coupon code</h3>
                    <form action="{{ route('previewWithCouponCode') }}" method="POST">
                        @isset($couponWarning)
                            <div class="alert alert-warning">
                                {{ $couponWarning }}
                            </div>
                        @endisset
                        <div class="input-group">
                            {!! csrf_field() !!}
                            <input type="text" class="form-control" name="couponcode"
                                   @isset($coupon) value="{{$coupon->code}}" @endisset>
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">APPLY</button>
                         </span>
                        </div>
                    </form>
                </div>
            </div>
            @include("web.checkout.order-review", ['cart' => $cart])
        </div>
    </div>
</main>