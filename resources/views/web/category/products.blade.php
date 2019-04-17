<section class="products">


    <div class="container-fluid">
        <div class="row">

            <!-- Filters -->
            @include('web.product.filters', ['category' => $category, 'attributes' => $attributes, 'products' => $products])
            @include('web.product.items', ['category' => $category, 'attributes' => $attributes, 'products' => $products])


        </div>
    </div>
</section>