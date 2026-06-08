/**
 * Drone Sark – Mobile nav & cart count
 */
(function($){
    'use strict';

    // Update mobile cart count when WC fragments refresh
    $(document.body).on('wc_fragments_refreshed wc_fragments_loaded added_to_cart', function(){
        var count = parseInt($('.nm-cart-contents-count').first().text()) || 0;
        var $badge = $('.ds-mobile-cart-count');
        if(count > 0){
            $badge.text(count).show();
        } else {
            $badge.hide();
        }
    });

    // Highlight active nav item
    var current = window.location.href;
    $('.ds-mobile-bottom-nav__item').each(function(){
        if($(this).attr('href') === current){
            $(this).addClass('active');
        }
    });

})(jQuery);
