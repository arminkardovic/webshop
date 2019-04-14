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
                <div class="col-xs-12 col-md-6 col-xl-5 f-image" id="productInfo">
                    <h1 class="product_title entry-title">
                        {{$product->nameTranslated}}
                    </h1>

                    <p class="price">
                    <span class="price-amount amount">
                        {{$product->formatted_price}}
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

                    <form class="cart" method="post" enctype="multipart/form-data">
                        <div class="quantity">
                            Količina: <input type="number" class="input-text qty text" step="1" min="1" max=""
                                             name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*"
                                             inputmode="numeric">
                        </div>
                        <button type="submit" name="add-to-cart" value="283"
                                class="single_add_to_cart_button button alt">dodaj u korpu
                        </button>
                        <a href="#" class="heart"><i class="fas fa-heart"></i></a>
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani
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
                var combination = JSON.stringify($(this).serializeArray());

                if($(this).serializeArray().length == numberOfAttributes) {

                    $.ajax({
                        url: '{{route('getInfoForCombination')}}',
                        type: 'GET',
                        data: {
                            product_id: '{{$product->id}}',
                            combination: combination
                        },
                    }).done(function (response) {
                        $("#productInfo").html(response);
                        setEvents();
                    });
                }
            });
        }
    </script>
@endsection