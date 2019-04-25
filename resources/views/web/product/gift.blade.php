@extends('web.layout')

@section("content")
    <section class="product">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-xl-6 slideshow">
                    <div class="slider">
                        @foreach($product->images as $image)
                            <div class="slider-item">
                                <img src="{{$image->url}}" alt="">
                            </div>
                        @endforeach
                    </div>

                    <div class="slider-pagination">
                        @foreach($product->images as $image)
                            <div class="item">
                                <img src="{{$image->url}}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
                @php

                        @endphp

                <div class="col-xs-12 col-md-6 col-xl-5 f-image">
                    <div id="alert_placeholder"></div>
                    <div id="productInfo">
                        <h1 class="product_title entry-title">
                            {{$product->nameTranslated}}
                        </h1>
                        <p class="price">
                    <span class="price-amount amount">
                        {{$product->formatted_price}}
                    </span>
                        </p>

                        <form class="cart" id="add_to_cart_form" method="post" enctype="multipart/form-data">
                            <div class="email">
                                Enter email of user to gift: <input type="text" class="input-text text" title="Email" name="email">
                            </div>
                            <button type="submit" name="add-to-cart" value="283"
                                    class="single_add_to_cart_button button alt">dodaj u korpu
                            </button>
                        </form>

                        <div class="shipping">
                            <span>Dostava u </span>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#country">
                                Crnoj Gori
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="country" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Odaberite zemlju</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <li>Srbija</li>
                                            <li>Hrvatska</li>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Odustani
                                            </button>
                                            <button type="button" class="btn btn-primary">Odaberi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="btn btn-primary" type="button" value="besplatna">
                        </div>
                        <div style="margin-top:50px;">
                            <h3>{{trans('product.description')}}:</h3>
                            {!! $product->descriptionTranslated !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('after_scripts')
    <script>
        $(document).ready(function () {
            $("#add_to_cart_form").submit(function (event) {
                event.preventDefault();
                var productId = {{$product->id}};
                var email = $("input[name=email]").val();
                var combinationIds = [];

                $.ajax({
                    url: '{{route('addToCart')}}',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        combination: combinationIds,
                        email: email,
                        quantity: 1
                    },
                    xhrFields: {
                        withCredentials: true
                    }
                }).done(function (response) {
                    var date = new Date();
                    var minutes = 30;
                    date.setTime(date.getTime() + (minutes * 60 * 1000));
                    document.cookie = "cart" + "=" + response + ";path=/;expires=" + date.toGMTString();
                    bootstrap_alert.success("Proizvod dodat u korpu.");
                    getCartTotal();
                    refreshCollapsedCart();
                }).fail(function (error) {
                    bootstrap_alert.warning("Nema dovoljno proizvoda na stanju.");
                });
            });
        });

        bootstrap_alert = {};

        bootstrap_alert.warning = function (message) {
            $('#alert_placeholder').html('<div class="alert alert-danger" role="alert"><a class="close" data-dismiss="alert">×</a><span>' + message + '</span></div>')
        }

        bootstrap_alert.success = function (message) {
            $('#alert_placeholder').html('<div class="alert alert-success" role="alert"><a class="close" data-dismiss="alert">×</a><span>' + message + '</span></div>')
        }
    </script>
@endsection