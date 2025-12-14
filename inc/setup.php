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
        'primary'      => __( 'Primary Menu', 'd1' ),
        'footer'       => __( 'Footer Menu', 'd1' ),
        'footer_col_1' => __( 'Footer Column 1', 'd1' ),
        'footer_col_2' => __( 'Footer Column 2', 'd1' ),
        'footer_col_3' => __( 'Footer Column 3', 'd1' ),
        'footer_bottom' => __( 'Footer Bottom', 'd1' ),
    ) );

    // Load text domain
    load_theme_textdomain( 'd1', D1_DIR . '/languages' );
}

/**
 * Allow only D1 ACF blocks in the editor
 */
add_filter( 'allowed_block_types_all', 'd1_allowed_block_types', 10, 2 );

function d1_allowed_block_types( $allowed_blocks, $editor_context ) {
    // Get all registered blocks
    $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
    
    // Filter to only ACF blocks (they start with 'acf/')
    $acf_blocks = array();
    foreach ( $registered_blocks as $block_name => $block ) {
        if ( strpos( $block_name, 'acf/' ) === 0 ) {
            $acf_blocks[] = $block_name;
        }
    }
    
    // Also allow some essential core blocks
    $allowed_core = array(
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/list-item',
        'core/image',
    );
    
    return array_merge( $acf_blocks, $allowed_core );
}

/**
 * Add D1 block category
 */
add_filter( 'block_categories_all', 'd1_block_category', 10, 2 );

function d1_block_category( $categories, $editor_context ) {
    array_unshift( $categories, array(
        'slug'  => 'd1-blocks',
        'title' => __( 'D1 Blocks', 'd1' ),
        'icon'  => 'layout',
    ) );
    return $categories;
}