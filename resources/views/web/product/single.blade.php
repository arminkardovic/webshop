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
                        {{--{{$product->formatted_price}}--}}
                        {{\App\Utils\PriceUtils::formatPrice($product->price)}} {{Auth::user()->locationSettings->currency}}
                    </span>
                        </p>
                        {{ Form::open(array('id' => 'attributes_form', 'method' => 'get')) }}

                        @foreach($attributes as $attribute)

                            <div class="size">
                                <div id="size-label">{{$attribute->name}}:</div>
                                <div class="size-value">

                                    <div class="btn-group" data-toggle="buttons">
                                        @foreach($attribute->values as $value)
                                            <label class="btn btn-primary attribute-value">
                                                <input type="radio" name="attribute-{{$attribute->id}}"
                                                       value="{{$value->id}}"> {{ $value->value }}
                                            </label>
                                        @endforeach
                                    </div>

                                </div>

                            </div>
                        @endforeach
                        {{ Form::close() }}

                        <form class="cart" id="add_to_cart_form" method="post" enctype="multipart/form-data">
                            <div class="quantity" hidden>
                                Količina: <input type="number" class="input-text qty text" step="1" min="1" max=""
                                                 name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*"
                                                 inputmode="numeric" disabled>
                            </div>
                            <button type="submit" name="add-to-cart" value="283"
                                    class="single_add_to_cart_button button alt" disabled>dodaj u korpu
                            </button>
                            @auth
                                @php($isFavorite = Auth::user()->favorites->contains($product->id))
                                <a href="#" id="unfavoriteButton" class="heart" @if(!$isFavorite) hidden @endif><i
                                            class="fas fa-heart"
                                            onclick="removeFromFavorites(event, {{$product->id}})"></i></a>
                                <a href="#" id="favoriteButton"
                                   style="position: absolute;bottom: 0;right: 0;-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;padding: 13px;"
                                   @if($isFavorite) hidden @endif>
                                    <i style="font-size: 65px;color: #660033;" class="far fa-heart"
                                       onclick="addToFavorites(event, {{$product->id}})"></i>
                                </a>
                            @endauth
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
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('after_scripts')
    <script>
        $(document).ready(function () {
            setEvents();
        });

        function setEvents() {
            $("label.attribute-value").click(function () {
                $(this).children("input").prop("checked", true);
                $("#attributes_form").submit();
            });

            $("#attributes_form").submit(function (event) {

                event.preventDefault();
                var numberOfAttributes = {{sizeof($attributes)}};
                var combination = $(this).serializeArray();
                var combinationJson = JSON.stringify(combination);
                var quantity = $("input[name=quantity]").val();

                if (combination.length === numberOfAttributes) {

                    $.ajax({
                        url: '{{route('getInfoForCombination')}}',
                        type: 'GET',
                        data: {
                            product_id: '{{$product->id}}',
                            combination: combinationJson
                        },
                    }).done(function (response) {
                        $("#productInfo").html(response);
                        var quantityElement = $("input[name=quantity]");

                        if (parseInt(quantityElement.attr('max')) >= quantity) {
                            quantityElement.val(quantity);
                        }
                        setEvents();
                    });
                }
            });

            $("#add_to_cart_form").submit(function (event) {
                event.preventDefault();
                var quantity = $("input[name=quantity]").val();
                var productId = {{$product->id}};
                var combination = $("#attributes_form").serializeArray();
                var combinationIds = [];

                for (var i = 0; i < combination.length; i++) {
                    combinationIds.push(parseInt(combination[i].value));
                }

                console.log(combinationIds);

                $.ajax({
                    url: '{{route('addToCart')}}',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        combination: combinationIds,
                        quantity: quantity
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
        }

        function addToFavorites(event, productId) {
            $.ajax({
                url: '{{route('addToFavorites')}}',
                type: 'POST',
                data: {
                    product_id: productId
                },
                xhrFields: {
                    withCredentials: true
                }
            }).done(function (response) {
                bootstrap_alert.success("Proizvod dodat u listu favorita.");
                $(event.target).parent().attr('hidden', true);
                $('#unfavoriteButton').removeAttr('hidden');
            }).fail(function (error) {
                bootstrap_alert.warning("Greska prilikom dodavanja u listu favorita.");
            });
        }

        function removeFromFavorites(event, productId) {

            $.ajax({
                url: '{{route('removeFromFavorites')}}',
                type: 'POST',
                data: {
                    product_id: productId
                },
                xhrFields: {
                    withCredentials: true
                }
            }).done(function (response) {
                bootstrap_alert.success("Proizvod uklonjen iz liste favorita.");
                $(event.target).parent().attr('hidden', true);
                $('#favoriteButton').removeAttr('hidden');
            }).fail(function (error) {
                bootstrap_alert.warning("Greska prilikom uklanjanja iz liste favorita.");
            });
        }

        bootstrap_alert = {};

        bootstrap_alert.warning = function (message) {
            $('#alert_placeholder').html('<div class="alert alert-danger" role="alert"><a class="close" data-dismiss="alert">×</a><span>' + message + '</span></div>')
        }

        bootstrap_alert.success = function (message) {
            $('#alert_placeholder').html('<div class="alert alert-success" role="alert"><a class="close" data-dismiss="alert">×</a><span>' + message + '</span></div>')
        }
    </script>
@endsection