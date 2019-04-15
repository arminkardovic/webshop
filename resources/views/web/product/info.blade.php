<h1 class="product_title entry-title">
    {{$product->nameTranslated}}
</h1>
<p class="price">
                    <span class="price-amount amount">
                        @if(isset($productPrice) && isset($productPrice->price) && $productPrice->stock > 0)
                            {{$productPrice->price}} &euro;
                        @else
                        {{$product->formatted_price}}
                        @endif
                    </span>
</p>
{{ Form::open(array('id' => 'attributes_form', 'method' => 'get')) }}

@foreach($attributes as $attribute)

    <div class="size">
        <div id="size-label">{{$attribute->name}}:</div>
        <div class="size-value">

            <div class="btn-group" data-toggle="buttons">
                @foreach($attribute->values as $value)
                    <label class="btn btn-primary attribute-value{{in_array($value->id, $productPrice->attributes) ? ' active': ''}}" for="{{$value->id}}">
                        <input type="radio" id="{{$value->id}}" name="attribute-{{$attribute->id}}"
                               value="{{$value->id}}" @if(in_array($value->id, $productPrice->attributes)) checked @endif >{{ $value->value }}
                    </label>
                @endforeach
            </div>

        </div>

    </div>
@endforeach
{{ Form::close() }}

<form class="cart" method="post" enctype="multipart/form-data" id="add_to_cart_form">
    <div class="quantity" @if(!(isset($productPrice) && isset($productPrice->price) && $productPrice->stock > 0)) hidden @endif >
        Količina: <input type="number" class="input-text qty text" step="1" min="1"
                         name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*"
                         inputmode="numeric" max="{{$productPrice->stock}}">
    </div>
    <button type="submit" name="add-to-cart" value="283"
            class="single_add_to_cart_button button alt" @if(!(isset($productPrice) && isset($productPrice->price) && $productPrice->stock > 0)) disabled @endif >dodaj u korpu
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