<?php
/**
 * Custom Post Types registration
 *
 * @package D1
 */

add_action( 'init', 'd1_register_cpts' );

function d1_register_cpts() {
    $enabled_cpts = d1_get_enabled_cpts();

    foreach ( $enabled_cpts as $cpt_key ) {
        $config = d1_get_cpt_config( $cpt_key );
        if ( $config ) {
            register_post_type( $config['slug'], $config['args'] );
            
            if ( ! empty( $config['taxonomy'] ) ) {
                register_taxonomy(
                    $config['taxonomy']['slug'],
                    $config['slug'],
                    $config['taxonomy']['args']
                );
            }
        }
    }
}

function d1_get_enabled_cpts() {
    $enabled = d1_get_theme_option( 'd1_enabled_cpts', array() );
    return is_array( $enabled ) ? $enabled : array();
}

function d1_get_cpt_config( $key ) {
    $cpts = array(
        'services' => array(
            'slug' => 'd1_service',
            'args' => array(
                'labels'       => d1_get_cpt_labels( 'Service', 'Services' ),
                'public'       => true,
                'has_archive'  => true,
                'menu_icon'    => 'dashicons-clipboard',
                'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                'show_in_rest' => true,
                'rewrite'      => array( 'slug' => 'services' ),
            ),
            'taxonomy' => array(
                'slug' => 'd1_service_cat',
                'args' => array(
                    'labels'       => d1_get_tax_labels( 'Category', 'Categories' ),
                    'hierarchical' => true,
                    'show_in_rest' => true,
                    'rewrite'      => array( 'slug' => 'service-category' ),
                ),
            ),
        ),
        'locations' => array(
            'slug' => 'd1_location',
            'args' => array(
                'labels'       => d1_get_cpt_labels( 'Location', 'Locations' ),
                'public'       => true,
                'has_archive'  => true,
                'menu_icon'    => 'dashicons-location',
                'supports'     => array( 'title', 'editor', 'thumbnail' ),
                'show_in_rest' => true,
                'rewrite'      => array( 'slug' => 'locations' ),
            ),
            'taxonomy' => null,
        ),
        'reviews' => array(
            'slug' => 'd1_review',
            'args' => array(
                'labels'             => d1_get_cpt_labels( 'Review', 'Reviews' ),
                'public'             => false,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'has_archive'        => false,
                'menu_icon'          => 'dashicons-star-filled',
                'supports'           => array( 'title', 'editor' ),
                'show_in_rest'       => true,
            ),
            'taxonomy' => null,
        ),
        'projects' => array(
            'slug' => 'd1_project',
            'args' => array(
                'labels'       => d1_get_cpt_labels( 'Project', 'Projects' ),
                'public'       => true,
                'has_archive'  => true,
                'menu_icon'    => 'dashicons-portfolio',
                'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                'show_in_rest' => true,
                'rewrite'      => array( 'slug' => 'projects' ),
            ),
            'taxonomy' => array(
                'slug' => 'd1_project_cat',
                'args' => array(
                    'labels'       => d1_get_tax_labels( 'Category', 'Categories' ),
                    'hierarchical' => true,
                    'show_in_rest' => true,
                    'rewrite'      => array( 'slug' => 'project-category' ),
                ),
            ),
        ),
        'jobs' => array(
            'slug' => 'd1_job',
            'args' => array(
                'labels'       => d1_get_cpt_labels( 'Job', 'Jobs' ),
                'public'       => true,
                'has_archive'  => true,
                'menu_icon'    => 'dashicons-businessman',
                'supports'     => array( 'title', 'editor' ),
                'show_in_rest' => true,
                'rewrite'      => array( 'slug' => 'jobs' ),
            ),
            'taxonomy' => array(
                'slug' => 'd1_job_type',
                'args' => array(
                    'labels'       => d1_get_tax_labels( 'Job Type', 'Job Types' ),
                    'hierarchical' => true,
                    'show_in_rest' => true,
                    'rewrite'      => array( 'slug' => 'job-type' ),
                ),
            ),
        ),
        'people' => array(
            'slug' => 'd1_person',
            'args' => array(
                'labels'             => d1_get_cpt_labels( 'Person', 'People' ),
                'public'             => false,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'has_archive'        => false,
                'menu_icon'          => 'dashicons-groups',
                'supports'           => array( 'title', 'thumbnail' ),
                'show_in_rest'       => true,
            ),
            'taxonomy' => array(
                'slug' => 'd1_department',
                'args' => array(
                    'labels'       => d1_get_tax_labels( 'Department', 'Departments' ),
                    'hierarchical' => true,
                    'show_in_rest' => true,
                    'rewrite'      => array( 'slug' => 'department' ),
                ),
            ),
        ),
    );

    return isset( $cpts[ $key ] ) ? $cpts[ $key ] : null;
}

function d1_get_cpt_labels( $singular, $plural ) {
    return array(
        'name'               => __( $plural, 'd1' ),
        'singular_name'      => __( $singular, 'd1' ),
        'add_new'            => __( 'Add New', 'd1' ),
        'add_new_item'       => sprintf( __( 'Add New %s', 'd1' ), $singular ),
        'edit_item'          => sprintf( __( 'Edit %s', 'd1' ), $singular ),
        'new_item'           => sprintf( __( 'New %s', 'd1' ), $singular ),
        'view_item'          => sprintf( __( 'View %s', 'd1' ), $singular ),
        'search_items'       => sprintf( __( 'Search %s', 'd1' ), $plural ),
        'not_found'          => sprintf( __( 'No %s found', 'd1' ), strtolower( $plural ) ),
        'not_found_in_trash' => sprintf( __( 'No %s found in trash', 'd1' ), strtolower( $plural ) ),
    );
}

function d1_get_tax_labels( $singular, $plural ) {
    return array(
        'name'              => __( $plural, 'd1' ),
        'singular_name'     => __( $singular, 'd1' ),
        'search_items'      => sprintf( __( 'Search %s', 'd1' ), $plural ),
        'all_items'         => sprintf( __( 'All %s', 'd1' ), $plural ),
        'parent_item'       => sprintf( __( 'Parent %s', 'd1' ), $singular ),
        'parent_item_colon' => sprintf( __( 'Parent %s:', 'd1' ), $singular ),
        'edit_item'         => sprintf( __( 'Edit %s', 'd1' ), $singular ),
        'update_item'       => sprintf( __( 'Update %s', 'd1' ), $singular ),
        'add_new_item'      => sprintf( __( 'Add New %s', 'd1' ), $singular ),
        'new_item_name'     => sprintf( __( 'New %s Name', 'd1' ), $singular ),
        'menu_name'         => __( $plural, 'd1' ),
    );
}

function d1_get_available_cpts() {
    return array(
        'services'  => __( 'Services', 'd1' ),
        'locations' => __( 'Locations', 'd1' ),
        'reviews'   => __( 'Reviews', 'd1' ),
        'projects'  => __( 'Projects', 'd1' ),
        'jobs'      => __( 'Jobs', 'd1' ),
        'people'    => __( 'People', 'd1' ),
    );
}