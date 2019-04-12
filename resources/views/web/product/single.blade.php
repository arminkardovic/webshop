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

                <div class="col-xs-12 col-md-6 col-xl-5 f-image">
                    <h1 class="product_title entry-title">
                        {{$product->name}}
                    </h1>

                    <p class="price">
                    <span class="price-amount amount">
                        {{$product->formatted_price}}
                    </span>
                    </p>

                    <div class="size">
                        <div id="size-label">Broj:</div>
                        <div class="size-value">

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input type="radio" name="options" id="option1" checked> 2
                                </label>

                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option2"> 4
                                </label>

                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option3"> 6
                                </label>

                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option4"> 8
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option5"> 10
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option6"> 12
                                </label>

                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option5"> 14
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option6"> 16
                                </label>

                            </div>

                        </div>

                    </div>

                    <div class="color">
                        <div id="color-label">Broj:</div>
                        <div class="color-value">

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input type="radio" name="options" id="option1" checked> crvena
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option2"> roza
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option3"> teget
                                </label>

                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option4"> zelena
                                </label>

                            </div>

                        </div>
                    </div>

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