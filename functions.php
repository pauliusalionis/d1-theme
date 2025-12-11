<?php
/**
 * D1 Theme functions and definitions
 *
 * @package D1
 */

// Define theme constants
define( 'D1_VERSION', '1.0.0' );
define( 'D1_DIR', get_template_directory() );
define( 'D1_URI', get_template_directory_uri() );

// Include files
require_once D1_DIR . '/inc/setup.php';
require_once D1_DIR . '/inc/assets.php';
require_once D1_DIR . '/inc/options.php';
require_once D1_DIR . '/inc/acf-blocks.php';
require_once D1_DIR . '/inc/cpt.php';
require_once D1_DIR . '/inc/template-cpt.php';
