<?php
/**
 * Theme footer
 *
 * @package D1
 */
?>

<footer class="site-footer section section--alt">
    <div class="container">
        <div class="cluster cluster--between">
            <div class="site-footer__copy">
                &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>
            </div>

            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Footer Menu', 'd1' ); ?>">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'cluster',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>