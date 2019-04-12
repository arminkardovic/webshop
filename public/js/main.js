jQuery(document).ready(function($){

    $('.similar-products-slider').slick({
        infinite: true,
        slidesToShow: 3,
        dots:false,
        arrows:false,
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
        arrows:false,
        vertical:true,
        slidesToScroll: 1,
        asNavFor: '.slider',
        dots: false,
        focusOnSelect: true
    });

});// End Custom jQuery
