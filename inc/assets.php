<?php
/**
 * Enqueue styles and scripts
 *
 * @package D1
 */

add_action( 'wp_enqueue_scripts', 'd1_enqueue_assets' );

function d1_enqueue_assets() {
    // Foundation CSS
    wp_enqueue_style(
        'd1-foundation',
        D1_URI . '/assets/css/foundation.css',
        array(),
        D1_VERSION
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
