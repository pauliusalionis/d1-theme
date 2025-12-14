<?php
/**
 * Theme footer
 *
 * @package D1
 */

// Get footer settings from ACF
$footer_style        = d1_get_theme_option( 'footer_style', 'default' );
$footer_bg_color     = d1_get_theme_option( 'footer_background_color', 'soft' );
$footer_bg_image     = d1_get_theme_option( 'footer_background_image' );
$footer_logo         = d1_get_theme_option( 'footer_logo' );
$footer_tagline      = d1_get_theme_option( 'footer_tagline' );
$footer_phone        = d1_get_theme_option( 'footer_phone' );
$footer_email        = d1_get_theme_option( 'footer_email' );
$footer_address      = d1_get_theme_option( 'footer_address' );
$footer_show_social  = d1_get_theme_option( 'footer_show_social', true );
$footer_social_links = d1_get_theme_option( 'footer_social_links' );
$footer_copyright    = d1_get_theme_option( 'footer_copyright_text' );

// Determine section classes
$section_classes = array( 'site-footer', 'section' );

if ( $footer_style === 'compact' ) {
    $section_classes[] = 'site-footer--compact';
}

// Background color class
switch ( $footer_bg_color ) {
    case 'dark':
        $section_classes[] = 'section--dark';
        break;
    case 'brand':
        $section_classes[] = 'section--brand';
        break;
    case 'soft':
    default:
        $section_classes[] = 'section--alt';
        break;
}

if ( $footer_bg_image ) {
    $section_classes[] = 'section--has-bg';
}
?>

<footer class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">
    <?php if ( $footer_bg_image ) : ?>
        <figure class="section__bg">
            <?php echo wp_get_attachment_image( $footer_bg_image, 'full', false, array( 'class' => 'section__bg-img' ) ); ?>
        </figure>
    <?php endif; ?>

    <div class="container">

        <?php if ( $footer_style !== 'compact' ) : ?>
            <div class="site-footer__grid">

                <!-- Footer Branding Column -->
                <div class="site-footer__brand">
                    <?php if ( $footer_logo ) : ?>
                        <div class="site-footer__logo">
                            <?php echo wp_get_attachment_image( $footer_logo, 'medium' ); ?>
                        </div>
                    <?php else : ?>
                        <div class="site-footer__logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ( $footer_tagline ) : ?>
                        <p class="site-footer__tagline"><?php echo esc_html( $footer_tagline ); ?></p>
                    <?php endif; ?>

                    <?php if ( $footer_show_social && $footer_social_links ) : ?>
                        <div class="site-footer__social">
                            <?php foreach ( $footer_social_links as $social ) : ?>
                                <?php if ( ! empty( $social['url'] ) && ! empty( $social['icon'] ) ) : ?>
                                    <a href="<?php echo esc_url( $social['url'] ); ?>"
                                       class="site-footer__social-link"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       aria-label="<?php echo esc_attr( $social['platform'] ?? 'Social Media' ); ?>">
                                        <span class="site-footer__social-icon"><?php echo $social['icon']; ?></span>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer Menu Columns -->
                <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                    <?php
                    $menu_location = "footer_col_{$i}";
                    if ( has_nav_menu( $menu_location ) ) :
                    ?>
                        <div class="site-footer__column">
                            <?php
                            $menu_obj = wp_get_nav_menu_object( get_nav_menu_locations()[ $menu_location ] );
                            if ( $menu_obj ) :
                            ?>
                                <h3 class="site-footer__column-title"><?php echo esc_html( $menu_obj->name ); ?></h3>
                            <?php endif; ?>

                            <?php
                            wp_nav_menu( array(
                                'theme_location' => $menu_location,
                                'container'      => 'nav',
                                'menu_class'     => 'site-footer__nav',
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            ) );
                            ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>

                <!-- Contact Info Column -->
                <?php if ( $footer_phone || $footer_email || $footer_address ) : ?>
                    <div class="site-footer__column">
                        <h3 class="site-footer__column-title"><?php esc_html_e( 'Contact', 'd1' ); ?></h3>
                        <div class="site-footer__contact">
                            <?php if ( $footer_phone ) : ?>
                                <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $footer_phone ) ); ?>"
                                   class="site-footer__contact-item">
                                    <svg class="site-footer__contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span><?php echo esc_html( $footer_phone ); ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if ( $footer_email ) : ?>
                                <a href="mailto:<?php echo esc_attr( $footer_email ); ?>"
                                   class="site-footer__contact-item">
                                    <svg class="site-footer__contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span><?php echo esc_html( $footer_email ); ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if ( $footer_address ) : ?>
                                <div class="site-footer__contact-item">
                                    <svg class="site-footer__contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span><?php echo esc_html( $footer_address ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <!-- Footer Bottom Bar -->
        <div class="site-footer__bottom">
            <div class="site-footer__bottom-inner">
                <p class="site-footer__copy">
                    <?php if ( $footer_copyright ) : ?>
                        <?php echo wp_kses_post( $footer_copyright ); ?>
                    <?php else : ?>
                        &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'd1' ); ?>
                    <?php endif; ?>
                </p>

                <?php if ( has_nav_menu( 'footer_bottom' ) ) : ?>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer_bottom',
                        'container'      => false,
                        'menu_class'     => 'site-footer__bottom-nav',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>