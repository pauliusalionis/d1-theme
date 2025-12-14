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

    // Hero - Simple
    acf_register_block_type( array(
        'name'            => 'hero-simple',
        'title'           => __( 'Hero - Simple', 'd1' ),
        'description'     => __( 'Simple hero with heading, text, and buttons.', 'd1' ),
        'category'        => 'd1-blocks',
        'icon'            => 'cover-image',
        'keywords'        => array( 'hero', 'banner', 'intro' ),
        'render_template' => D1_DIR . '/template-parts/blocks/hero-simple.php',
        'enqueue_style'   => D1_URI . '/assets/css/blocks/hero-simple.css',
        'supports'        => array(
            'align'  => array( 'full', 'wide' ),
            'anchor' => true,
            'mode'   => true,
        ),
    ) );

    // Simple Section
    acf_register_block_type( array(
        'name'            => 'simple-section',
        'title'           => __( 'Simple Section', 'd1' ),
        'description'     => __( 'Section with heading and text content.', 'd1' ),
        'category'        => 'd1-blocks',
        'icon'            => 'text',
        'keywords'        => array( 'section', 'text', 'content' ),
        'render_template' => D1_DIR . '/template-parts/blocks/simple-section.php',
        'enqueue_style'   => D1_URI . '/assets/css/blocks/simple-section.css',
        'supports'        => array(
            'align'  => array( 'full', 'wide' ),
            'anchor' => true,
            'mode'   => true,
        ),
    ) );

    // Text + Image
    acf_register_block_type( array(
        'name'            => 'text-image',
        'title'           => __( 'Text + Image', 'd1' ),
        'description'     => __( 'Split layout with text and image.', 'd1' ),
        'category'        => 'd1-blocks',
        'icon'            => 'align-pull-left',
        'keywords'        => array( 'text', 'image', 'split', 'media' ),
        'render_template' => D1_DIR . '/template-parts/blocks/text-image.php',
        'enqueue_style'   => D1_URI . '/assets/css/blocks/text-image.css',
        'supports'        => array(
            'align'  => array( 'full', 'wide' ),
            'anchor' => true,
            'mode'   => true,
        ),
    ) );

    // FAQ Section
    acf_register_block_type( array(
        'name'            => 'faq',
        'title'           => __( 'FAQ Section', 'd1' ),
        'description'     => __( 'Accordion-style FAQ section.', 'd1' ),
        'category'        => 'd1-blocks',
        'icon'            => 'editor-help',
        'keywords'        => array( 'faq', 'accordion', 'questions' ),
        'render_template' => D1_DIR . '/template-parts/blocks/faq.php',
        'enqueue_style'   => D1_URI . '/assets/css/blocks/faq.css',
        'supports'        => array(
            'align'  => array( 'full', 'wide' ),
            'anchor' => true,
            'mode'   => true,
        ),
    ) );

    // CTA Section
    acf_register_block_type( array(
        'name'            => 'cta',
        'title'           => __( 'CTA Section', 'd1' ),
        'description'     => __( 'Call to action with heading, text, and buttons.', 'd1' ),
        'category'        => 'd1-blocks',
        'icon'            => 'megaphone',
        'keywords'        => array( 'cta', 'call to action', 'button' ),
        'render_template' => D1_DIR . '/template-parts/blocks/cta.php',
        'enqueue_style'   => D1_URI . '/assets/css/blocks/cta.css',
        'supports'        => array(
            'align'  => array( 'full', 'wide' ),
            'anchor' => true,
            'mode'   => true,
        ),
    ) );

    // Shortcode Block
    acf_register_block_type( array(
        'name'            => 'shortcode',
        'title'           => __( 'Shortcode', 'd1' ),
        'description'     => __( 'Execute any shortcode.', 'd1' ),
        'category'        => 'd1-blocks',
        'icon'            => 'shortcode',
        'keywords'        => array( 'shortcode', 'embed', 'form' ),
        'render_template' => D1_DIR . '/template-parts/blocks/shortcode.php',
        'enqueue_style'   => D1_URI . '/assets/css/blocks/shortcode.css',
        'supports'        => array(
            'align'  => array( 'full', 'wide' ),
            'anchor' => true,
            'mode'   => true,
        ),
    ) );
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