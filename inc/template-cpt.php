<?php
/**
 * Template CPT for reusable block compositions
 *
 * @package D1
 */

add_action( 'init', 'd1_register_template_cpt' );

function d1_register_template_cpt() {
    register_post_type( 'd1_template', array(
        'labels' => array(
            'name'               => __( 'Templates', 'd1' ),
            'singular_name'      => __( 'Template', 'd1' ),
            'add_new'            => __( 'Add New', 'd1' ),
            'add_new_item'       => __( 'Add New Template', 'd1' ),
            'edit_item'          => __( 'Edit Template', 'd1' ),
            'new_item'           => __( 'New Template', 'd1' ),
            'view_item'          => __( 'View Template', 'd1' ),
            'search_items'       => __( 'Search Templates', 'd1' ),
            'not_found'          => __( 'No templates found', 'd1' ),
            'not_found_in_trash' => __( 'No templates found in trash', 'd1' ),
        ),
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => 'd1-theme-settings',
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-layout',
        'supports'            => array( 'title', 'editor' ),
        'has_archive'         => false,
        'exclude_from_search' => true,
    ) );
}