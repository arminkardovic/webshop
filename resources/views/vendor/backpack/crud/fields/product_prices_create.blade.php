<?php

?>

<table id="product_prices_table" class="table table-bordered" border="1">
</table>

<input type="hidden" name="productPricesField">

@push('crud_fields_scripts')

    <script>
        var firstTime = true;
        $(document).ready(function () {
            var attributesSetSelect = $('#attributes-set');

            getAttributesCreateTable(attributesSetSelect.val());

            attributesSetSelect.select2({
                theme: "bootstrap"
            }).on("change", function (e) {
                getAttributesCreateTable($(this).val());
            });


        });

        function generatePricesField() {
            var valueColumns = $("#product_prices_table > thead > tr:first").children("th").length - 2;

            var prices = [];

            $("#product_prices_table > tbody  > tr").each(function () {
                var price = {};
                price.stock = $(this).find(".product-stock").val();
                price.price = $(this).find(".product-price").val();
                price.attributeValuesIds = [];

                let i = 0;
                $(this).children("td").each(function () {
                    if (i >= valueColumns) {
                        return;
                    }
                    price.attributeValuesIds.push($(this).data("attribute-value-id"));
                    i++;
                });
                prices.push(price);
            });

            var jsonPricesField = JSON.stringify(prices);
            console.log(jsonPricesField);
            $("input[name=productPricesField]").val(jsonPricesField);
        }

        function bindPricesChangeEvent() {
            $(".product-stock, .product-price").bind('keyup input', function () {
                generatePricesField();
            });
        }

        function getAttributesCreateTable(setId) {
            $.ajax({
                url: "{{ route('getCreateProductPricesTable') }}",
                type: 'POST',
                data: {
                    setId: setId,
                }
            })
                .done(function (response) {
                    $("#product_prices_table").html(response);
                    bindPricesChangeEvent();
                    if (firstTime == true) {
                        generatePricesField();
                        firstTime = false;
                    }
                });
        }
    </script>

@endpush