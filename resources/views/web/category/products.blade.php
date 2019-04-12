<section class="products">
    <div class="container-fluid">
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <a href="{{route("product.single", ["id"=>$product->id])}}" class="product">
                        <img src="{{$product->feature_image}}" alt="">
                        <div class="price">{{$product->formatted_price}}</div>
                    </a>
                </div>
            @endforeach

        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</section>