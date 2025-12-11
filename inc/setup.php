<?php
/**
 * Theme setup
 *
 * @package D1
 */

add_action( 'after_setup_theme', 'd1_setup' );

function d1_setup() {
    // Add theme support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Register menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'd1' ),
        'footer'  => __( 'Footer Menu', 'd1' ),
    ) );

    // Load text domain
    load_theme_textdomain( 'd1', D1_DIR . '/languages' );
}
