jQuery(document).ready(function ($) {

    $('.similar-products-slider').slick({
        infinite: true,
        slidesToShow: 3,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToScroll: 1
    });

    $('.slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-pagination'
    });
    $('.slider-pagination').slick({
        slidesToShow: 3,
        arrows: false,
        vertical: true,
        slidesToScroll: 1,
        asNavFor: '.slider',
        dots: false,
        focusOnSelect: true
    });

    $("#collapseCartButton").click(function () {
        if (window.requestPath == 'checkout') {
            return;
        }


        if ($("#collapseCarpet").length) {
            $('.collapse').collapse();
            return;
        }

        $.ajax({
            url: '/getCollapseCartHtml',
            type: 'GET'
        })
            .done(function (response) {
                $('.container-fluid, .container').append(response);
                if(window.requestPath === '/') {
                    $('.collapse').first().css('margin-top', '142px');
                }
                $('.collapse').collapse();
            });
    });


});// End Custom jQuery

function removeFromCartCollapse(event, item, key, url) {
    event.preventDefault();

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            item: JSON.stringify(item)
        },
        xhrFields: {
            withCredentials: true
        }
    }).done(function (response) {
        var date = new Date();
        var minutes = 30;
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        document.cookie = "cart" + "=" + response + ";path=/;expires=" + date.toGMTString();
        getCartTotal();
        $.ajax({
            url: '/getCollapseInnerCartHtml',
            type: 'GET'
        })
            .done(function (response) {
                $('.collapse').html(response);
            });
    }).fail(function (error) {
    });
}

function getCartTotal() {
    event.preventDefault();

    $.ajax({
        url: window.getCartTotalUrl,
        type: 'GET',
        xhrFields: {
            withCredentials: true
        }
    }).done(function (response) {
        $("span#cartTotalInMenu").html(response);
    }).fail(function (error) {
    });
}

function refreshCollapsedCart() {
    if (!$("#collapseCarpet").length) {
        return;
    }

    $.ajax({
        url: '/getCollapseInnerCartHtml',
        type: 'GET'
    })
        .done(function (response) {
            $('.collapse').html(response);
        });
}


