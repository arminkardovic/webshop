<div class="tab-pane" id="favorites" role="tabpanel">

    @if(sizeof($user->favorites) > 0)
    <table class="table span12">

        <thead>
        <tr>
            <th style="width: 70%">Product</th>

            <th style="width: 20%; text-align: right;">Price</th>
        </tr>
        </thead>

        <tbody>

        @foreach($user->favorites as $product)
            <tr>
                <td class="product-info">
                    <a href="" class="close" onclick="removeFromFavorites(event, {{$product->id}})"><i
                                class="fas fa-times"></i></a>
                    <a href="{{route("product.single", ["id"=>$product->id])}}">
                    <img src="{{$product->feature_image != null ? $product->feature_image : "img/blackgirl.jpg"}}"
                         alt="">
                    </a>
                    <div class="product-name">{{$product->nameTranslated}}</div>
                    {{--<div class="atributes">

                        <dt class="label">color</dt>
                        <dd class="value">red</dd>

                        <dt class="label">size</dt>
                        <dd class="value">4</dd>

                    </div>--}}
                </td>

                <td class="product-price">
                    <span class="value">{{$product->price}}</span>
                    <span class="value-symbol">€</span>
                </td>
            </tr>
        @endforeach

        {{--<tr>
            <td class="product-info">
                <img src="img/blackgirl.jpg" alt="">
                <div class="product-name">Haljina sa podsuknjom od tila i mašnom na struku</div>
                <div class="atributes">

                    <dt class="label">color</dt>
                    <dd class="value">red</dd>

                    <dt class="label">size</dt>
                    <dd class="value">4</dd>

                </div>
            </td>

            <td class="product-price">
                <span class="value">58</span>
                <span class="value-symbol">€</span>
            </td>
        </tr>--}}

        </tbody>
    </table>
        @endisset

</div>

@section('after_scripts')
<script>
    function removeFromFavorites(event, productId) {
        event.preventDefault();
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
            $(event.target).parent().parent().remove();
        }).fail(function (error) {
            bootstrap_alert.warning("Greska prilikom uklanjanja iz liste favorita.");
        });
    }
</script>
@endsection