/**
 * Drone Sark – Swiper Sliders
 * Initialises all slider instances on the page.
 */
(function () {
  'use strict';

  function isMobile() {
    return window.innerWidth <= 768;
  }

  function isTablet() {
    return window.innerWidth <= 1024 && window.innerWidth > 768;
  }

  document.addEventListener('DOMContentLoaded', function () {

    // ── Accessories slider ──────────────────────────────
    const accessoriesEl = document.querySelector('.ds-accessories-slider');
    if (accessoriesEl && typeof Swiper !== 'undefined') {
      new Swiper(accessoriesEl, {
        slidesPerView: 2,
        spaceBetween: 12,
        loop: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        navigation: {
          nextEl: '.ds-accessories-slider .ds-slider-next',
          prevEl: '.ds-accessories-slider .ds-slider-prev',
        },
        breakpoints: {
          480: {
            slidesPerView: 2,
            spaceBetween: 12,
          },
          768: {
            slidesPerView: 4,
            spaceBetween: 16,
          },
          1025: {
            slidesPerView: 6,
            spaceBetween: 16,
          },
        },
      });
    }

    // ── Reviews slider ──────────────────────────────────
    const reviewsEl = document.querySelector('.ds-reviews-slider');
    if (reviewsEl && typeof Swiper !== 'undefined') {
      new Swiper(reviewsEl, {
        slidesPerView: 1,
        spaceBetween: 16,
        loop: true,
        autoplay: {
          delay: 4500,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        navigation: {
          nextEl: '.ds-reviews-slider .ds-slider-next',
          prevEl: '.ds-reviews-slider .ds-slider-prev',
        },
        pagination: {
          el: '.ds-reviews-pagination',
          clickable: true,
        },
        breakpoints: {
          481: {
            slidesPerView: 2,
            spaceBetween: 16,
          },
          769: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          1025: {
            slidesPerView: 4,
            spaceBetween: 20,
          },
        },
      });
    }

    // ── Hero slider (if any) ─────────────────────────────
    const heroSliderEl = document.querySelector('.ds-hero-slider');
    if (heroSliderEl && typeof Swiper !== 'undefined') {
      new Swiper(heroSliderEl, {
        effect: 'fade',
        loop: true,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.ds-hero-pagination',
          clickable: true,
        },
        navigation: {
          nextEl: '.ds-hero-next',
          prevEl: '.ds-hero-prev',
        },
      });
    }

  });

})();
