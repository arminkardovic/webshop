<div class="carpet-items">
        @php($total = 0)

        @foreach($cart as $key => $item)
            @php($total += $item->quantity * $item->price)
        <li id="li-{{$key}}">
            <img src="{{isset($item->featureImage) && $item->featureImage != '' ? $item->featureImage : \Illuminate\Support\Facades\URL::to('img/blackgirl.jpg')}}" alt="">
            <div class="carpet-item-content">

                <div class="heading">

                    <span class="price">{{$item->price}} €</span>

                    <a href="" onclick="removeFromCartCollapse(event, {{json_encode($item)}}, {{$key}}, '{{route('removeFromCart')}}')" class="close"><i class="fas fa-times"></i></a>

                    <a href="{{route('checkout')}}" class="edit"><i class="fas fa-pencil-alt"></i></a>

                </div>

                <h4>{{Lang::locale() == 'en' ? $item->product_name : $item->product_name_sr}}</h4>

                @foreach($item->combinationInfo as $combinationInfoItem)
                <span class="attribute">{{$combinationInfoItem->name}}: <span class="value">{{$combinationInfoItem->value}}</span></span>
                @endforeach


            </div>
        </li>
        @endforeach
    </div>

    <div class="payment-info">

        <div class="subtotal">Ukupno proizvodi: <span class="value">{{number_format((float)$total, 2, '.', '')}} €</span></div>

        <div class="delivering">Dostava u Hrvatskoj: <span class="value">20 €</span></div>

        <div class="total">UKUPNO ZA PLAĆANJE: <span>{{number_format((float)$total + 20, 2, '.', '')}} €</span></div>

        <button type="button" class="btn btn-primary submit" onclick="window.location.replace('/checkout')" @if(sizeof($cart) == 0) disabled @endif>PLATI</button>

        <div class="payment-way">Moguci nacini placanja:

            <div class="btn-group cards" data-toggle="buttons">

                <label class="btn btn-primary visa">
                    <input type="radio" name="options" id="option2">
                    <i class="fab fa-cc-visa"></i>
                </label>

                <label class="btn btn-primary mastercard">
                    <input type="radio" name="options" id="option3">
                    <i class="fab fa-cc-mastercard"></i>
                </label>

                <label class="btn btn-primary paypal">
                    <input type="radio" name="options" id="option4">
                    <i class="fab fa-cc-paypal"></i>
                </label>


            </div>


        </div>

        <div class="delivery-time">Očekivano vrijeme dostave: <span>5 dana</span></div>

    </div>