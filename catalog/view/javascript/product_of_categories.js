$(document).ready(function () {

    function showButtonProduct() {
        var product_layout = $('.product-of-categories__product');

        $(product_layout).hover(
            function () {
                if ( $('.product-of-categories__button-group').is(':animated') == false) {

                    $(this).find('.product-of-categories__rating').hide(0);
                    $(this).find('.product-of-categories__img').css('opacity', '0.45');
                    $(this).find('.product-of-categories__button-group').show(250);
                }

            },
            function () {
                $('.product-of-categories__rating').slideDown(250);
                $('.product-of-categories__button-group').hide(0);
                $('.product-of-categories__img').css('opacity', '1');
            }
        );
    }

    showButtonProduct();

});
