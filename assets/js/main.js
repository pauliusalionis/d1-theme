/**
 * D1 Theme Main JavaScript
 *
 * @package D1
 */

(function() {
    'use strict';

    /**
     * Initialize accordions
     */
    function initAccordions() {
        var triggers = document.querySelectorAll('.js-accordion .faq__question');
        
        triggers.forEach(function(trigger) {
            trigger.addEventListener('click', function() {
                var accordion = this.closest('.js-accordion');
                var panel = accordion.querySelector('.js-accordion-panel');
                var isOpen = accordion.classList.contains('is-open');
                
                // Close all others (optional - remove if you want multiple open)
                // document.querySelectorAll('.js-accordion.is-open').forEach(function(item) {
                //     item.classList.remove('is-open');
                //     item.querySelector('.js-accordion-panel').style.maxHeight = null;
                // });
                
                if (isOpen) {
                    accordion.classList.remove('is-open');
                    panel.style.maxHeight = null;
                } else {
                    accordion.classList.add('is-open');
                    panel.style.maxHeight = panel.scrollHeight + 'px';
                }
            });
        });
    }

    /**
     * Initialize fade-in on scroll
     */
    function initFadeIn() {
        if (!('IntersectionObserver' in window)) {
            // Fallback: just show everything
            document.querySelectorAll('.fade-in').forEach(function(el) {
                el.style.opacity = '1';
                el.style.transform = 'none';
            });
            return;
        }

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        document.querySelectorAll('.fade-in').forEach(function(el) {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    }

    /**
     * DOM Ready
     */
    function domReady(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    domReady(function() {
        initAccordions();
        initFadeIn();
    });

})();