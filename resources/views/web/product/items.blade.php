<div class="col-md-9">

    <div class="row">
        @if(sizeof($products) === 0)
            <div class="col-md-12 text-center">
                <h3>{{trans('category.noproducts')}}</h3>
            </div>
        @else
            @foreach($products as $product)
                <div class="col-md-4">
                    <a href="{{route("product.single", ["id"=>$product->id])}}" class="product">
                        <img src="{{$product->feature_image != null ? $product->feature_image : "img/blackgirl.jpg"}}"
                             alt="">
                        <div class="price">{{$product->formatted_price}}</div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>

</div>