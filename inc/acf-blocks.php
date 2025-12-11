<?php
/**
 * ACF Blocks registration
 *
 * @package D1
 */

add_action( 'acf/init', 'd1_register_acf_blocks' );

function d1_register_acf_blocks() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    // Blocks will be registered here
}

/**
 * ACF JSON save point
 */
add_filter( 'acf/settings/save_json', 'd1_acf_json_save_point' );

function d1_acf_json_save_point( $path ) {
    return D1_DIR . '/acf-json';
}

/**
 * ACF JSON load point
 */
add_filter( 'acf/settings/load_json', 'd1_acf_json_load_point' );

function d1_acf_json_load_point( $paths ) {
    unset( $paths[0] );
    $paths[] = D1_DIR . '/acf-json';
    return $paths;
}
