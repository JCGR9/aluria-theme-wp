/* ============================================
   ALURIA MODAS - WooCommerce Extras
   Funciones específicas para WooCommerce
   ============================================ */

(function($) {
    'use strict';

    $(document).ready(function() {

        // ============================================
        // WooCommerce Cart Fragments Update
        // ============================================
        $(document.body).on('added_to_cart removed_from_cart', function() {
            // Actualizar contador visual
            $('.cart-count').each(function() {
                const count = parseInt($(this).text()) || 0;
                $(this).css('display', count > 0 ? 'flex' : 'none');
            });
        });

        // ============================================
        // Size Options in Product Page
        // ============================================
        $(document).on('click', '.size-option', function() {
            $('.size-option').removeClass('selected');
            $(this).addClass('selected');
        });

        // ============================================
        // WooCommerce Messages
        // ============================================
        // Auto-hide WooCommerce messages after 5 seconds
        setTimeout(function() {
            $('.woocommerce-message, .woocommerce-error, .woocommerce-info').fadeOut(500);
        }, 5000);

        // ============================================
        // Quantity Input Styling
        // ============================================
        $(document).on('click', '.quantity .plus, .quantity .minus', function() {
            var $qty = $(this).closest('.quantity').find('.qty'),
                currentVal = parseFloat($qty.val()),
                max = parseFloat($qty.attr('max')),
                min = parseFloat($qty.attr('min')),
                step = $qty.attr('step');

            if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
            if (max === '' || max === 'NaN') max = '';
            if (min === '' || min === 'NaN') min = 0;
            if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

            if ($(this).is('.plus')) {
                if (max && currentVal >= max) {
                    $qty.val(max);
                } else {
                    $qty.val(currentVal + parseFloat(step));
                }
            } else {
                if (min && currentVal <= min) {
                    $qty.val(min);
                } else if (currentVal > 0) {
                    $qty.val(currentVal - parseFloat(step));
                }
            }

            $qty.trigger('change');
        });

        // ============================================
        // Product Variation Changes
        // ============================================
        $(document).on('woocommerce_variation_select_change', function() {
            // Opcional: lógica adicional cuando cambia una variación
        });

        // ============================================
        // AJAX Add to Cart from Archive Pages
        // ============================================
        $(document).on('click', '.ajax_add_to_cart', function(e) {
            var $button = $(this);
            
            $button.addClass('loading');
            
            $(document.body).one('added_to_cart', function() {
                $button.removeClass('loading').addClass('added');
                
                setTimeout(function() {
                    $button.removeClass('added');
                }, 2000);
            });
        });

    });

})(jQuery);
