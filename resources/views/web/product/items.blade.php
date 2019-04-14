<div class="col-md-9">

    <div class="row">

        @foreach($products as $product)
            <div class="col-md-4">
                <a href="{{route("product.single", ["id"=>$product->id])}}" class="product">
                    <img src="{{$product->feature_image != null ? $product->feature_image : "img/blackgirl.jpg"}}" alt="">
                    <div class="price">{{$product->formatted_price}}</div>
                </a>
            </div>
        @endforeach
    </div>

</div>