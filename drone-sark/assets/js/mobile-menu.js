/**
 * Drone Sark – Mobile Menu & Navigation
 */
(function () {
  'use strict';

  // ── Mobile drawer ──────────────────────────────────────
  function initMobileDrawer() {
    const toggle  = document.querySelector('.ds-mobile-menu-toggle');
    const drawer  = document.getElementById('ds-mobile-drawer');
    const overlay = document.getElementById('ds-mobile-overlay');
    const close   = document.querySelector('.ds-mobile-drawer__close');

    if (!toggle || !drawer) return;

    function openDrawer() {
      drawer.classList.add('is-open');
      drawer.setAttribute('aria-hidden', 'false');
      toggle.setAttribute('aria-expanded', 'true');
      if (overlay) overlay.classList.add('is-visible');
      document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
      drawer.classList.remove('is-open');
      drawer.setAttribute('aria-hidden', 'true');
      toggle.setAttribute('aria-expanded', 'false');
      if (overlay) overlay.classList.remove('is-visible');
      document.body.style.overflow = '';
    }

    toggle.addEventListener('click', function () {
      const isOpen = drawer.classList.contains('is-open');
      isOpen ? closeDrawer() : openDrawer();
    });

    if (close) close.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);

    // Escape key closes drawer
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
        closeDrawer();
        toggle.focus();
      }
    });
  }

  // ── Mobile sub-menu accordion ──────────────────────────
  function initMobileAccordion() {
    const menu = document.querySelector('.ds-mobile-nav-menu');
    if (!menu) return;

    const parentItems = menu.querySelectorAll('.menu-item-has-children');

    parentItems.forEach(function (item) {
      const link = item.querySelector('a');
      if (!link) return;

      // Add toggle chevron
      const chevron = document.createElement('span');
      chevron.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>';
      chevron.classList.add('ds-mobile-submenu-toggle');
      chevron.style.cssText = 'cursor:pointer;display:flex;align-items:center;padding:0 1rem;';

      link.parentNode.insertBefore(chevron, link.nextSibling);

      chevron.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        item.classList.toggle('is-open');
        const expanded = item.classList.contains('is-open');
        chevron.style.transform = expanded ? 'rotate(180deg)' : '';
      });
    });
  }

  // ── Mobile search toggle ────────────────────────────────
  function initMobileSearch() {
    const toggle = document.querySelector('.ds-mobile-search-toggle');
    const panel  = document.getElementById('ds-mobile-search');
    if (!toggle || !panel) return;

    toggle.addEventListener('click', function () {
      const isOpen = !panel.hidden;
      panel.hidden = isOpen;
      toggle.setAttribute('aria-expanded', String(!isOpen));

      if (!isOpen) {
        const input = panel.querySelector('input[type="search"]');
        if (input) input.focus();
      }
    });
  }

  // ── Filter drawer (shop) ────────────────────────────────
  function initFilterDrawer() {
    const toggle  = document.querySelector('.ds-filter-drawer-toggle');
    const drawer  = document.getElementById('ds-filter-drawer');
    const overlay = document.getElementById('ds-filter-overlay');
    const close   = document.querySelector('.ds-filter-drawer__close');

    if (!toggle || !drawer) return;

    function open() {
      drawer.classList.add('is-open');
      drawer.setAttribute('aria-hidden', 'false');
      if (overlay) overlay.classList.add('is-visible');
      document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
      drawer.classList.remove('is-open');
      drawer.setAttribute('aria-hidden', 'true');
      if (overlay) overlay.classList.remove('is-visible');
      document.body.style.overflow = '';
    }

    toggle.addEventListener('click', open);
    if (close) close.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
        closeDrawer();
        toggle.focus();
      }
    });
  }

  // ── Active nav item highlight ───────────────────────────
  function highlightActiveNav() {
    const currentUrl = window.location.href;
    const links = document.querySelectorAll('.ds-nav-bar__menu a, .ds-mobile-nav-menu a');

    links.forEach(function (link) {
      if (link.href === currentUrl) {
        link.parentElement.classList.add('current-menu-item');
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initMobileDrawer();
    initMobileAccordion();
    initMobileSearch();
    initFilterDrawer();
    highlightActiveNav();
  });

})();
