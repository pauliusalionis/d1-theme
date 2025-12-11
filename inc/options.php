<?php
/**
 * ACF Options pages and helpers
 *
 * @package D1
 */

add_action( 'acf/init', 'd1_register_options_pages' );

function d1_register_options_pages() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( array(
        'page_title' => __( 'Theme Settings', 'd1' ),
        'menu_title' => __( 'Theme Settings', 'd1' ),
        'menu_slug'  => 'd1-theme-settings',
        'capability' => 'manage_options',
        'icon_url'   => 'dashicons-admin-customizer',
        'position'   => 59,
    ) );

    acf_add_options_sub_page( array(
        'page_title'  => __( 'CPT Settings', 'd1' ),
        'menu_title'  => __( 'CPT Settings', 'd1' ),
        'menu_slug'   => 'd1-cpt-settings',
        'parent_slug' => 'd1-theme-settings',
    ) );
}

/**
 * Helper function to get theme options
 */
function d1_get_theme_option( $key, $default = null ) {
    if ( ! function_exists( 'get_field' ) ) {
        return $default;
    }
    
    $value = get_field( $key, 'option' );
    return $value !== null ? $value : $default;
}
