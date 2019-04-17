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
        if(window.requestPath == 'checkout') {
            return;
        }
        if($("#collapseCarpet").length) {
            $('.collapse').collapse();
            return;
        }

        $.ajax({
            url: '/getCollapseCartHtml',
            type: 'GET'
        })
            .done(function (response) {
                $('.container-fluid, .container').append(response);
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
        $("li#li-" + key).remove();
        var date = new Date();
        var minutes = 30;
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        document.cookie = "cart" + "=" + response + ";path=/;expires=" + date.toGMTString();
        // bootstrap_alert.success("Proizvod uklonjen iz korpe.");
    }).fail(function (error) {
        // bootstrap_alert.warning("Greska prilikom uklanjanja iz korpe.");
    });
}

/*bootstrap_alert = {};


bootstrap_alert.warning = function(message) {
    $('#alert_placeholder').html('<div class="alert alert-danger" role="alert"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
}

bootstrap_alert.success = function(message) {
    $('#alert_placeholder').html('<div class="alert alert-success" role="alert"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
}*/

