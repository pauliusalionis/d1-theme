<?php
/**
 * Block: Hero - Slider
 *
 * @package D1
 */

// Block settings
$anchor     = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
$class_name = ! empty( $block['className'] ) ? $block['className'] : '';
$align      = ! empty( $block['align'] ) ? 'align' . $block['align'] : 'alignfull';

// Section fields
$hidden     = get_field( 'section_hidden' );
$background = get_field( 'section_background' ) ?: 'default';
$spacing    = get_field( 'section_spacing' ) ?: 'spacious';
$width      = get_field( 'section_width' ) ?: 'default';

// Slider fields
$slides          = get_field( 'slides' );
$autoplay        = get_field( 'slider_autoplay' );
$autoplay_delay  = get_field( 'slider_autoplay_delay' ) ?: 5000;
$loop            = get_field( 'slider_loop' );
$navigation      = get_field( 'slider_navigation' );
$pagination      = get_field( 'slider_pagination' );
$effect          = get_field( 'slider_effect' ) ?: 'slide';
$text_align      = get_field( 'text_alignment' ) ?: 'center';
$content_position = get_field( 'content_position' ) ?: 'center';

// Generate unique ID for this slider instance
$slider_id = 'hero-slider-' . uniqid();

// Open section
d1_section_open( array(
    'anchor'     => $anchor,
    'class'      => trim( "hero-slider $class_name" ),
    'background' => $background,
    'spacing'    => $spacing,
    'width'      => $width,
    'align'      => $align,
    'hidden'     => $hidden,
) );

if ( ! $hidden && ! empty( $slides ) ) :
?>

    <div class="hero-slider__wrapper">
        <div
            id="<?php echo esc_attr( $slider_id ); ?>"
            class="swiper hero-slider__swiper"
            data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
            data-autoplay-delay="<?php echo esc_attr( $autoplay_delay ); ?>"
            data-loop="<?php echo $loop ? 'true' : 'false'; ?>"
            data-effect="<?php echo esc_attr( $effect ); ?>"
        >
            <div class="swiper-wrapper">
                <?php foreach ( $slides as $index => $slide ) :
                    $slide_bg_image = $slide['background_image'] ?? null;
                    $slide_eyebrow  = $slide['eyebrow'] ?? '';
                    $slide_heading  = $slide['heading'] ?? '';
                    $slide_heading_tag = $slide['heading_tag'] ?? 'h2';
                    $slide_subheading = $slide['subheading'] ?? '';
                    $slide_content  = $slide['content'] ?? '';
                    $slide_buttons  = $slide['buttons'] ?? array();

                    $slide_classes = array( 'swiper-slide', 'hero-slider__slide' );
                    $slide_classes[] = 'hero-slider__slide--' . $text_align;
                    $slide_classes[] = 'hero-slider__slide--' . $content_position;
                ?>
                    <div class="<?php echo esc_attr( implode( ' ', $slide_classes ) ); ?>">
                        <?php if ( $slide_bg_image ) : ?>
                            <figure class="hero-slider__bg" aria-hidden="true">
                                <?php echo wp_get_attachment_image(
                                    $slide_bg_image,
                                    'full',
                                    false,
                                    array(
                                        'class' => 'hero-slider__bg-img',
                                        'loading' => $index === 0 ? 'eager' : 'lazy',
                                    )
                                ); ?>
                                <div class="hero-slider__overlay"></div>
                            </figure>
                        <?php endif; ?>

                        <div class="hero-slider__content">
                            <div class="stack stack--lg <?php echo $text_align === 'center' ? 'stack--center' : ''; ?>">
                                <?php
                                d1_heading_group( array(
                                    'eyebrow'     => $slide_eyebrow,
                                    'heading'     => $slide_heading,
                                    'heading_tag' => $slide_heading_tag,
                                    'subheading'  => $slide_subheading,
                                    'align'       => $text_align,
                                ) );

                                d1_rich_text( $slide_content, $text_align === 'center' ? 'narrow' : 'default' );
                                d1_button_group( $slide_buttons, $text_align );
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ( $navigation ) : ?>
                <div class="hero-slider__nav hero-slider__nav--prev">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <div class="hero-slider__nav hero-slider__nav--next">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            <?php endif; ?>

            <?php if ( $pagination ) : ?>
                <div class="hero-slider__pagination"></div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper === 'undefined') {
            console.error('Swiper is not loaded');
            return;
        }

        const slider = document.getElementById('<?php echo esc_js( $slider_id ); ?>');
        if (!slider) return;

        const autoplay = slider.dataset.autoplay === 'true';
        const autoplayDelay = parseInt(slider.dataset.autoplayDelay) || 5000;
        const loop = slider.dataset.loop === 'true';
        const effect = slider.dataset.effect || 'slide';

        new Swiper('#<?php echo esc_js( $slider_id ); ?>', {
            effect: effect,
            loop: loop,
            speed: 800,
            autoplay: autoplay ? {
                delay: autoplayDelay,
                disableOnInteraction: false,
            } : false,
            <?php if ( $navigation ) : ?>
            navigation: {
                nextEl: '#<?php echo esc_js( $slider_id ); ?> .hero-slider__nav--next',
                prevEl: '#<?php echo esc_js( $slider_id ); ?> .hero-slider__nav--prev',
            },
            <?php endif; ?>
            <?php if ( $pagination ) : ?>
            pagination: {
                el: '#<?php echo esc_js( $slider_id ); ?> .hero-slider__pagination',
                clickable: true,
                dynamicBullets: true,
            },
            <?php endif; ?>
            <?php if ( $effect === 'fade' ) : ?>
            fadeEffect: {
                crossFade: true
            },
            <?php endif; ?>
            on: {
                init: function() {
                    slider.classList.add('swiper-initialized');
                }
            }
        });
    });
    </script>

<?php
endif;

d1_section_close( $hidden );
