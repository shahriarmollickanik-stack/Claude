/**
 * Drone Sark – Shop filter & AJAX
 */
(function ($) {
  'use strict';

  // ── Price range slider (basic) ──────────────────────
  function initPriceRange() {
    const form = document.querySelector('.widget_price_filter form');
    if (!form) return;
    // WooCommerce handles price filter natively; just ensure
    // the slider widget renders correctly inside our sidebar.
  }

  // ── Smooth product count update ─────────────────────
  function initProductCount() {
    $(document.body).on('woocommerce_layered_nav_init', function () {
      // WooCommerce layered nav handles filtering
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initPriceRange();
    initProductCount();
  });

})(jQuery);
