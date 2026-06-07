/**
 * Drone Sark – Main JS
 */
(function ($) {
  'use strict';

  const DS = window.DroneSark || {};

  // ── Header scroll effect ─────────────────────────────────
  function initHeaderScroll() {
    const header = document.getElementById('site-header');
    if (!header) return;

    let lastScroll = 0;

    window.addEventListener('scroll', function () {
      const y = window.scrollY;
      if (y > 20) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
      lastScroll = y;
    }, { passive: true });
  }

  // ── Buy Now button ────────────────────────────────────────
  function initBuyNow() {
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.ds-buy-now');
      if (!btn) return;

      e.preventDefault();
      const productId = btn.dataset.productId;
      const nonce     = btn.dataset.nonce;
      const qty       = document.querySelector('.qty') ? parseInt(document.querySelector('.qty').value) : 1;

      btn.disabled = true;
      btn.textContent = btn.getAttribute('data-loading-text') || 'Processing...';

      $.post(DS.ajaxUrl, {
        action:     'drone_sark_buy_now',
        product_id: productId,
        quantity:   qty,
        nonce:      nonce,
      }, function (response) {
        if (response.success && response.data.redirect) {
          window.location.href = response.data.redirect;
        }
      }).fail(function () {
        btn.disabled = false;
        btn.textContent = 'Buy Now';
      });
    });
  }

  // ── Add to Cart AJAX ─────────────────────────────────────
  function initAddToCart() {
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.ds-add-to-cart');
      if (!btn) return;

      e.preventDefault();
      const productId = btn.dataset.productId;
      const nonce     = btn.dataset.nonce;

      btn.classList.add('loading');
      btn.disabled = true;

      $.post(DS.ajaxUrl, {
        action:     'woocommerce_ajax_add_to_cart',
        product_id: productId,
        quantity:   1,
        nonce:      nonce,
      }, function () {
        btn.classList.remove('loading');
        btn.classList.add('added');
        btn.disabled = false;

        // Update mini cart fragments
        $(document.body).trigger('wc_fragment_refresh');

        setTimeout(function () {
          btn.classList.remove('added');
        }, 2000);
      });
    });
  }

  // ── Load More Products ───────────────────────────────────
  function initLoadMore() {
    const btn = document.getElementById('ds-load-more');
    if (!btn) return;

    btn.addEventListener('click', function () {
      const page      = parseInt(btn.dataset.page);
      const perPage   = parseInt(btn.dataset.perPage);
      const maxPages  = parseInt(btn.dataset.maxPages);
      const nonce     = btn.dataset.nonce;

      const textSpan    = btn.querySelector('.ds-load-more__text');
      const loadSpan    = btn.querySelector('.ds-load-more__loading');

      textSpan.hidden = true;
      loadSpan.hidden = false;
      btn.disabled    = true;

      $.post(DS.ajaxUrl, {
        action:   'drone_sark_load_more',
        page:     page,
        per_page: perPage,
        nonce:    nonce,
      }, function (response) {
        textSpan.hidden = false;
        loadSpan.hidden = true;
        btn.disabled    = false;

        if (response.success) {
          const grid = document.getElementById('ds-products-grid');
          if (grid) {
            grid.insertAdjacentHTML('beforeend', response.data.html);
          }

          const nextPage = page + 1;
          btn.dataset.page = nextPage;

          if (nextPage > maxPages || response.data.max_pages <= page) {
            btn.closest('.ds-load-more-wrap').remove();
          }
        }
      });
    });
  }

  // ── Wishlist quick button ────────────────────────────────
  function initWishlist() {
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.ds-wishlist-btn');
      if (!btn) return;

      e.preventDefault();
      const productId = btn.dataset.productId;

      // YITH WCWL integration
      if (typeof yith_wcwl_l10n !== 'undefined') {
        $.ajax({
          url: yith_wcwl_l10n.ajax_url,
          data: {
            action:     'yith_add_to_wishlist',
            product_id: productId,
            nonce:      yith_wcwl_l10n.nonce,
          },
          method: 'POST',
          success: function () {
            btn.classList.add('added');
          },
        });
      }
    });
  }

  // ── DOM ready ─────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', function () {
    initHeaderScroll();
    initBuyNow();
    initAddToCart();
    initLoadMore();
    initWishlist();
  });

})(jQuery);
