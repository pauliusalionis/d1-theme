/**
 * D1 Theme Main JavaScript
 *
 * @package D1
 */
(function () {
  'use strict';

  function domReady(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  /**
   * HEADER DRAWER
   * Requires:
   * - button.site-header__toggle (aria-controls="site-drawer")
   * - #site-drawer[hidden]
   * - elements with [data-drawer-close] inside drawer (overlay + close button)
   */
  function initHeaderDrawer() {
    var toggle = document.querySelector('.site-header__toggle');
    var drawer = document.getElementById('site-drawer');
    if (!toggle || !drawer) return;

    var lastFocus = null;

    function isOpen() {
      return toggle.getAttribute('aria-expanded') === 'true';
    }

    function openDrawer() {
      if (!drawer.hidden) return;

      lastFocus = document.activeElement;

      drawer.hidden = false;
      toggle.setAttribute('aria-expanded', 'true');
      document.documentElement.classList.add('is-drawer-open');

      // Focus first actionable element inside drawer
      var focusEl = drawer.querySelector('button, a, input, select, textarea, [tabindex]:not([tabindex="-1"])');
      if (focusEl) focusEl.focus();
    }

    function closeDrawer() {
      if (drawer.hidden) return;

      drawer.hidden = true;
      toggle.setAttribute('aria-expanded', 'false');
      document.documentElement.classList.remove('is-drawer-open');

      if (lastFocus && typeof lastFocus.focus === 'function') {
        lastFocus.focus();
      }
    }

    // Toggle click
    toggle.addEventListener('click', function () {
      isOpen() ? closeDrawer() : openDrawer();
    });

    // Close buttons + overlay (delegated inside drawer)
    drawer.addEventListener('click', function (e) {
      var closeTrigger = e.target.closest('[data-drawer-close]');
      if (closeTrigger) closeDrawer();
    });

    // ESC closes
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && isOpen()) closeDrawer();
    });

    // Basic focus trap (optional but useful)
    document.addEventListener('keydown', function (e) {
      if (e.key !== 'Tab' || !isOpen()) return;

      var focusables = drawer.querySelectorAll('button, a, input, select, textarea, [tabindex]:not([tabindex="-1"])');
      if (!focusables.length) return;

      var first = focusables[0];
      var last = focusables[focusables.length - 1];

      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    });
  }

  /**
   * Sticky header enhancement
   * Adds .is-scrolled to .site-header after scrolling
   */
  function initHeaderScrollState() {
    var header = document.querySelector('.site-header');
    if (!header) return;

    function onScroll() {
      header.classList.toggle('is-scrolled', window.scrollY > 8);
    }

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /**
   * Accordions (FAQ)
   * Requires:
   * - .js-accordion wrapper
   * - .faq__question trigger inside
   * - .js-accordion-panel inside
   */
  function initAccordions() {
    document.addEventListener('click', function (e) {
      var trigger = e.target.closest('.js-accordion .faq__question');
      if (!trigger) return;

      var accordion = trigger.closest('.js-accordion');
      if (!accordion) return;

      var panel = accordion.querySelector('.js-accordion-panel');
      if (!panel) return;

      var isOpen = accordion.classList.contains('is-open');

      accordion.classList.toggle('is-open', !isOpen);
      trigger.setAttribute('aria-expanded', String(!isOpen));

      // Height animation (optional)
      if (!isOpen) {
        panel.style.maxHeight = panel.scrollHeight + 'px';
      } else {
        panel.style.maxHeight = '';
      }
    });

    // Keep open heights correct on resize
    window.addEventListener('resize', function () {
      document.querySelectorAll('.js-accordion.is-open .js-accordion-panel').forEach(function (panel) {
        panel.style.maxHeight = panel.scrollHeight + 'px';
      });
    });
  }

  /**
   * Fade-in on scroll
   * - add .fade-in to elements
   * - CSS should reveal when .is-in is added
   */
  function initFadeIn() {
    var els = document.querySelectorAll('.fade-in');
    if (!els.length) return;

    if (!('IntersectionObserver' in window)) {
      els.forEach(function (el) { el.classList.add('is-in'); });
      return;
    }

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-in');
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    els.forEach(function (el) { observer.observe(el); });
  }

  domReady(function () {
    initHeaderDrawer();
    initHeaderScrollState();
    initAccordions();
    initFadeIn();
  });
})();