<?php
/**
 * Enqueue styles and scripts
 *
 * @package D1
 */

add_action( 'wp_enqueue_scripts', 'd1_enqueue_assets' );

function d1_enqueue_assets() {
    // Foundation CSS (core variables and utilities)
    wp_enqueue_style(
        'd1-foundation',
        D1_URI . '/assets/css/foundation.css',
        array(),
        D1_VERSION
    );

    // Header CSS
    wp_enqueue_style(
        'd1-header',
        D1_URI . '/assets/css/header.css',
        array( 'd1-foundation' ),
        D1_VERSION
    );

    // Footer CSS
    wp_enqueue_style(
        'd1-footer',
        D1_URI . '/assets/css/footer.css',
        array( 'd1-foundation' ),
        D1_VERSION
    );

    // Swiper CSS (for slider blocks)
    wp_enqueue_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );

    // Swiper JS (for slider blocks)
    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );

    // Main JS
    wp_enqueue_script(
        'd1-main',
        D1_URI . '/assets/js/main.js',
        array(),
        D1_VERSION,
        true
    );
}
