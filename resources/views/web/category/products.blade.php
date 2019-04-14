<section class="products">

    <!-- Carpet dropdown -->
    <div class="collapse" id="collapseCarpet">

        <div class="carpet-items">
            <li>
                <img src="img/blackgirl.jpg" alt="">
                <div class="carpet-item-content">

                    <div class="heading">

                        <span class="price">58 €</span>

                        <a href="" class="close"><i class="fas fa-times"></i></a>

                        <a href="" class="edit"><i class="fas fa-pencil-alt"></i></a>

                    </div>

                    <h4>Haljina sa podsuknjom od tila i mašnom na struku</h4>

                    <span class="attribute">veličina: <span class="value">5</span></span><span
                            class="attribute">boja: <span class="value">plava</span></span><span class="attribute">poruka: <span
                                class="value">maja</span></span>

                </div>
            </li>

            <li>
                <img src="img/blackgirl.jpg" alt="">
                <div class="carpet-item-content">

                    <div class="heading">

                        <span class="price">58 €</span>

                        <a href="" class="close"><i class="fas fa-times"></i></a>

                        <a href="" class="edit"><i class="fas fa-pencil-alt"></i></a>

                    </div>

                    <h4>Lutka od tekstila</h4>

                    <span class="attribute">poruka: <span class="value">maja</span></span>

                </div>
            </li>

        </div>

        <div class="payment-info">

            <div class="subtotal">Ukupno proizvodi: <span class="value">185 €</span></div>

            <div class="delivering">Dostava u Hrvatskoj: <span class="value">18 €</span></div>

            <div class="total">UKUPNO ZA PLAĆANJE: <span>140 €</span></div>

            <button type="button" class="btn btn-primary submit">PLATI</button>

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
    </div>

    <div class="container-fluid">
        <div class="row">

            <!-- Filters -->
            @include('web.product.filters', ['category' => $category, 'attributes' => $attributes, 'products' => $products])
            @include('web.product.items', ['category' => $category, 'attributes' => $attributes, 'products' => $products])


        </div>
    </div>
</section>