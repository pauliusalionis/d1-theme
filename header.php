<?php
/**
 * Theme header
 *
 * @package D1
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="cluster cluster--between">
            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary Menu', 'd1' ); ?>">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'cluster',
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</header>