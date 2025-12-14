<?php
/**
 * Reusable component render functions
 *
 * @package D1
 */

/**
 * Section wrapper - opening tag
 *
 * @param array $args Section settings
 * @return void
 */
function d1_section_open( $args = array() ) {
    $defaults = array(
        'anchor'            => '',
        'class'             => '',
        'background'        => 'default',  // default, alt, dark, brand
        'spacing'           => 'default',  // narrow, default, spacious
        'width'             => 'default',  // narrow, default, wide
        'align'             => '',         // Block alignment (alignfull, alignwide)
        'hidden'            => false,

        // Image BG
        'background_image'  => null,       // ACF image (id|array|url) or null
        'background_overlay'=> '',         // optional extra class e.g. 'section__bg--overlay'
        'background_alt'    => '',         // keep empty for decorative bg
        'background_lazy'   => true,       // lazy-load bg image
    );

    $args = wp_parse_args( $args, $defaults );

    // Don't render if hidden
    if ( $args['hidden'] ) {
        return;
    }

    // If not passed explicitly, try to pull from ACF
    if ( empty( $args['background_image'] ) && function_exists( 'get_field' ) ) {
        $args['background_image'] = get_field( 'section_background_image' );
    }

    // Build classes
    $classes = array( 'section' );

    // Background
    switch ( $args['background'] ) {
        case 'alt':
            $classes[] = 'section--alt';
            break;
        case 'dark':
            $classes[] = 'section--dark';
            break;
        case 'brand':
            $classes[] = 'section--brand';
            break;
    }

    // Spacing
    switch ( $args['spacing'] ) {
        case 'narrow':
            $classes[] = 'section--narrow';
            break;
        case 'spacious':
            $classes[] = 'section--spacious';
            break;
    }

    // Width
    switch ( $args['width'] ) {
        case 'narrow':
            $classes[] = 'section--width-narrow';
            break;
        case 'wide':
            $classes[] = 'section--width-wide';
            break;
        case 'full-width':
            $classes[] = 'section--width-full';
            break;
        case 'full-screen':
            $classes[] = 'section--width-screen';
            break;
        // 'default' is boxed, no additional class needed
    }

    // Block alignment
    if ( $args['align'] ) {
        $classes[] = $args['align'];
    }

    // Custom class
    if ( $args['class'] ) {
        $classes[] = $args['class'];
    }

    // If background image exists, add a class for styling
    $has_bg = ! empty( $args['background_image'] );
    if ( $has_bg ) {
        $classes[] = 'section--has-bg';
    }

    $anchor_attr = $args['anchor'] ? 'id="' . esc_attr( $args['anchor'] ) . '"' : '';

    ?>
    <section <?php echo $anchor_attr; ?> class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <?php if ( $has_bg ) : ?>
            <?php echo d1_render_section_background_figure( $args['background_image'], $args ); ?>
        <?php endif; ?>

        <div class="container section__inner">
    <?php
}

/**
 * Render section background <figure>
 *
 * @param mixed $image ACF image: ID|array|url
 * @param array $args Section args for options
 * @return string
 */
function d1_render_section_background_figure( $image, $args = array() ) {
    $figure_classes = array( 'section__bg' );
    if ( ! empty( $args['background_overlay'] ) ) {
        $figure_classes[] = sanitize_html_class( $args['background_overlay'] );
    }

    // Decorative background by default:
    $alt = isset( $args['background_alt'] ) ? (string) $args['background_alt'] : '';
    $is_decorative = ($alt === '');

    // Resolve image HTML safely.
    // Prefer ID for srcset/sizes.
    $img_html = '';

    if ( is_numeric( $image ) ) {
        $img_html = wp_get_attachment_image(
            (int) $image,
            'full',
            false,
            array(
                'class'   => 'section__bg-img',
                'alt'     => $alt,
                'loading' => ! empty( $args['background_lazy'] ) ? 'lazy' : 'eager',
                'decoding'=> 'async',
            )
        );
    } elseif ( is_array( $image ) && ! empty( $image['ID'] ) ) {
        $img_html = wp_get_attachment_image(
            (int) $image['ID'],
            'full',
            false,
            array(
                'class'   => 'section__bg-img',
                'alt'     => $alt,
                'loading' => ! empty( $args['background_lazy'] ) ? 'lazy' : 'eager',
                'decoding'=> 'async',
            )
        );
    } elseif ( is_array( $image ) && ! empty( $image['url'] ) ) {
        $img_html = sprintf(
            '<img class="section__bg-img" src="%s" alt="%s" loading="%s" decoding="async">',
            esc_url( $image['url'] ),
            esc_attr( $alt ),
            ! empty( $args['background_lazy'] ) ? 'lazy' : 'eager'
        );
    } elseif ( is_string( $image ) && $image !== '' ) {
        $img_html = sprintf(
            '<img class="section__bg-img" src="%s" alt="%s" loading="%s" decoding="async">',
            esc_url( $image ),
            esc_attr( $alt ),
            ! empty( $args['background_lazy'] ) ? 'lazy' : 'eager'
        );
    }

    if ( ! $img_html ) {
        return '';
    }

    $aria = $is_decorative ? ' aria-hidden="true"' : '';

    return sprintf(
        '<figure class="%s"%s>%s</figure>',
        esc_attr( implode( ' ', $figure_classes ) ),
        $aria,
        $img_html // already escaped by wp_get_attachment_image or esc_url above
    );
}

function d1_section_close( $hidden = false ) {
    if ( $hidden ) {
        return;
    }
    ?>
        </div>
    </section>
    <?php
}

/**
 * Heading group component
 *
 * @param array $args Heading settings
 * @return void
 */
function d1_heading_group( $args = array() ) {
    $defaults = array(
        'eyebrow'    => '',
        'heading'    => '',
        'heading_tag'=> 'h2',
        'subheading' => '',
        'align'      => 'left',  // left, center
    );
    $args = wp_parse_args( $args, $defaults );

    // Don't render if no content
    if ( ! $args['heading'] && ! $args['eyebrow'] && ! $args['subheading'] ) {
        return;
    }

    $wrapper_class = 'heading-group';
    if ( $args['align'] === 'center' ) {
        $wrapper_class .= ' heading-group--center';
    }
    ?>
    <header class="<?php echo esc_attr( $wrapper_class ); ?>">
        <?php if ( $args['eyebrow'] ) : ?>
            <p class="heading-group__eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
        <?php endif; ?>

        <?php if ( $args['heading'] ) : ?>
            <<?php echo esc_attr( $args['heading_tag'] ); ?> class="heading-group__title">
                <?php echo esc_html( $args['heading'] ); ?>
            </<?php echo esc_attr( $args['heading_tag'] ); ?>>
        <?php endif; ?>

        <?php if ( $args['subheading'] ) : ?>
            <p class="heading-group__subtitle"><?php echo wp_kses_post( $args['subheading'] ); ?></p>
        <?php endif; ?>
    </header>
    <?php
}

/**
 * Button group component
 *
 * @param array $buttons Array of button data
 * @param string $align Alignment (left, center, right)
 * @return void
 */
function d1_button_group( $buttons = array(), $align = 'left' ) {
    if ( empty( $buttons ) ) {
        return;
    }

    $wrapper_class = 'cluster';
    if ( $align === 'center' ) {
        $wrapper_class .= ' cluster--center';
    } elseif ( $align === 'right' ) {
        $wrapper_class .= ' cluster--right';
    }
    ?>
    <div class="<?php echo esc_attr( $wrapper_class ); ?>">
        <?php foreach ( $buttons as $button ) :
            $link  = $button['link'] ?? null;
            $style = $button['style'] ?? 'primary';
            $size  = $button['size'] ?? 'default';

            if ( ! $link ) {
                continue;
            }

            $btn_class = 'btn btn--' . esc_attr( $style );
            if ( $size === 'small' ) {
                $btn_class .= ' btn--sm';
            }
        ?>
            <a 
                href="<?php echo esc_url( $link['url'] ); ?>" 
                class="<?php echo esc_attr( $btn_class ); ?>"
                <?php echo ! empty( $link['target'] ) ? 'target="_blank" rel="noopener"' : ''; ?>
            >
                <?php echo esc_html( $link['title'] ); ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Media component
 *
 * @param array $args Media settings
 * @return void
 */
function d1_media( $args = array() ) {
    $defaults = array(
        'type'        => 'image',  // image, video, embed
        'image'       => null,     // Image array from ACF
        'video_url'   => '',       // Video URL for embed
        'aspect'      => 'auto',   // auto, 16:9, 4:3, 1:1
        'style'       => 'default', // default, rounded, shadow
        'size'        => 'large',  // WordPress image size
    );
    $args = wp_parse_args( $args, $defaults );

    // Build classes
    $classes = array( 'media' );
    
    if ( $args['style'] === 'rounded' ) {
        $classes[] = 'media--rounded';
    } elseif ( $args['style'] === 'shadow' ) {
        $classes[] = 'media--shadow';
    }

    if ( $args['aspect'] !== 'auto' ) {
        $classes[] = 'media--aspect-' . str_replace( ':', '-', $args['aspect'] );
    }

    // Render based on type
    if ( $args['type'] === 'image' && $args['image'] ) : ?>
        <figure class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <?php echo wp_get_attachment_image( $args['image']['ID'], $args['size'], false, array(
                'class'   => 'media__image',
                'loading' => 'lazy',
            ) ); ?>
        </figure>
    <?php elseif ( $args['type'] === 'video' && $args['video_url'] ) : ?>
        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <?php echo wp_oembed_get( $args['video_url'] ); ?>
        </div>
    <?php endif;
}

/**
 * Rich text component
 *
 * @param string $content WYSIWYG content
 * @param string $width Content width (default, narrow)
 * @return void
 */
function d1_rich_text( $content = '', $width = 'default' ) {
    if ( ! $content ) {
        return;
    }

    $class = 'rich-text';
    if ( $width === 'narrow' ) {
        $class .= ' content-narrow';
    }
    ?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <?php echo wp_kses_post( $content ); ?>
    </div>
    <?php
}

/**
 * Card component
 *
 * @param array $args Card settings
 * @return void
 */
function d1_card( $args = array() ) {
    $defaults = array(
        'icon'        => '',
        'image'       => null,
        'number'      => '',
        'title'       => '',
        'subtitle'    => '',
        'description' => '',
        'link'        => null,
        'badge'       => '',
        'style'       => 'default',  // default, elevated, outline
        'highlight'   => false,
    );
    $args = wp_parse_args( $args, $defaults );

    // Build classes
    $classes = array( 'card' );
    
    if ( $args['style'] === 'elevated' ) {
        $classes[] = 'card--elevated';
    } elseif ( $args['style'] === 'outline' ) {
        $classes[] = 'card--outline';
    }

    if ( $args['highlight'] ) {
        $classes[] = 'card--highlight';
    }

    if ( $args['link'] ) {
        $classes[] = 'card--hover';
    }

    $tag = $args['link'] ? 'a' : 'div';
    $href = $args['link'] ? ' href="' . esc_url( $args['link']['url'] ) . '"' : '';
    $target = ( $args['link'] && ! empty( $args['link']['target'] ) ) ? ' target="_blank" rel="noopener"' : '';
    ?>
    <<?php echo $tag . $href . $target; ?> class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <?php if ( $args['badge'] ) : ?>
            <span class="card__badge"><?php echo esc_html( $args['badge'] ); ?></span>
        <?php endif; ?>

        <?php if ( $args['image'] ) : ?>
            <figure class="card__image">
                <?php echo wp_get_attachment_image( $args['image']['ID'], 'medium', false, array(
                    'loading' => 'lazy',
                ) ); ?>
            </figure>
        <?php elseif ( $args['icon'] ) : ?>
            <span class="card__icon"><?php echo esc_html( $args['icon'] ); ?></span>
        <?php elseif ( $args['number'] ) : ?>
            <span class="card__number"><?php echo esc_html( $args['number'] ); ?></span>
        <?php endif; ?>

        <?php if ( $args['title'] ) : ?>
            <h3 class="card__title"><?php echo esc_html( $args['title'] ); ?></h3>
        <?php endif; ?>

        <?php if ( $args['subtitle'] ) : ?>
            <p class="card__subtitle"><?php echo esc_html( $args['subtitle'] ); ?></p>
        <?php endif; ?>

        <?php if ( $args['description'] ) : ?>
            <div class="card__content"><?php echo wp_kses_post( $args['description'] ); ?></div>
        <?php endif; ?>
    </<?php echo $tag; ?>>
    <?php
}

/**
 * FAQ item component
 *
 * @param string $question Question text
 * @param string $answer Answer content
 * @param bool $open Whether item starts open
 * @return void
 */
function d1_faq_item( $question = '', $answer = '', $open = false ) {
    if ( ! $question || ! $answer ) {
        return;
    }

    $classes = 'faq__item js-accordion';
    if ( $open ) {
        $classes .= ' is-open';
    }
    ?>
    <div class="<?php echo esc_attr( $classes ); ?>">
        <button class="faq__question" type="button" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>">
            <span><?php echo esc_html( $question ); ?></span>
            <span class="faq__icon" aria-hidden="true">+</span>
        </button>
        <div class="js-accordion-panel" <?php echo $open ? 'style="max-height: none;"' : ''; ?>>
            <div class="faq__answer">
                <?php echo wp_kses_post( $answer ); ?>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Step component
 *
 * @param array $args Step settings
 * @return void
 */
function d1_step( $args = array() ) {
    $defaults = array(
        'number'      => '',
        'icon'        => '',
        'title'       => '',
        'description' => '',
        'link'        => null,
    );
    $args = wp_parse_args( $args, $defaults );

    if ( ! $args['title'] ) {
        return;
    }

    $tag = $args['link'] ? 'a' : 'div';
    $href = $args['link'] ? ' href="' . esc_url( $args['link']['url'] ) . '"' : '';
    $target = ( $args['link'] && ! empty( $args['link']['target'] ) ) ? ' target="_blank" rel="noopener"' : '';
    ?>
    <<?php echo $tag . $href . $target; ?> class="step">
        <?php if ( $args['icon'] ) : ?>
            <div class="step__icon"><?php echo esc_html( $args['icon'] ); ?></div>
        <?php elseif ( $args['number'] ) : ?>
            <div class="step__number"><?php echo esc_html( $args['number'] ); ?></div>
        <?php endif; ?>

        <div class="step__content">
            <h3 class="step__title"><?php echo esc_html( $args['title'] ); ?></h3>
            <?php if ( $args['description'] ) : ?>
                <div class="step__description"><?php echo wp_kses_post( $args['description'] ); ?></div>
            <?php endif; ?>
        </div>
    </<?php echo $tag; ?>>
    <?php
}

/**
 * Stat component
 *
 * @param array $args Stat settings
 * @return void
 */
function d1_stat( $args = array() ) {
    $defaults = array(
        'number'      => '',
        'prefix'      => '',
        'suffix'      => '',
        'label'       => '',
        'description' => '',
        'animate'     => true,
    );
    $args = wp_parse_args( $args, $defaults );

    if ( ! $args['number'] && ! $args['label'] ) {
        return;
    }

    $stat_class = 'stat';
    if ( $args['animate'] ) {
        $stat_class .= ' js-stat';
    }
    ?>
    <div class="<?php echo esc_attr( $stat_class ); ?>">
        <?php if ( $args['number'] ) : ?>
            <div class="stat__number" data-value="<?php echo esc_attr( $args['number'] ); ?>">
                <?php if ( $args['prefix'] ) : ?>
                    <span class="stat__prefix"><?php echo esc_html( $args['prefix'] ); ?></span>
                <?php endif; ?>
                <span class="stat__value"><?php echo esc_html( $args['number'] ); ?></span>
                <?php if ( $args['suffix'] ) : ?>
                    <span class="stat__suffix"><?php echo esc_html( $args['suffix'] ); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( $args['label'] ) : ?>
            <div class="stat__label"><?php echo esc_html( $args['label'] ); ?></div>
        <?php endif; ?>

        <?php if ( $args['description'] ) : ?>
            <div class="stat__description"><?php echo wp_kses_post( $args['description'] ); ?></div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Logo component
 *
 * @param array $args Logo settings
 * @return void
 */
function d1_logo( $args = array() ) {
    $defaults = array(
        'image' => null,
        'name'  => '',
        'link'  => null,
    );
    $args = wp_parse_args( $args, $defaults );

    if ( ! $args['image'] ) {
        return;
    }

    $tag = $args['link'] ? 'a' : 'div';
    $href = $args['link'] ? ' href="' . esc_url( $args['link']['url'] ) . '"' : '';
    $target = ( $args['link'] && ! empty( $args['link']['target'] ) ) ? ' target="_blank" rel="noopener"' : '';
    ?>
    <<?php echo $tag . $href . $target; ?> class="logo-item">
        <figure class="logo-item__figure">
            <?php
            echo wp_get_attachment_image( $args['image']['ID'], 'medium', false, array(
                'class'   => 'logo-item__image',
                'alt'     => $args['name'] ? $args['name'] : '',
                'loading' => 'lazy',
            ) );
            ?>
        </figure>
    </<?php echo $tag; ?>>
    <?php
}

/**
 * Pricing card component
 *
 * @param array $args Pricing card settings
 * @return void
 */
function d1_pricing_card( $args = array() ) {
    $defaults = array(
        'name'         => '',
        'price'        => '',
        'period'       => '',
        'description'  => '',
        'features'     => array(),
        'button'       => null,
        'highlight'    => false,
        'badge'        => '',
    );
    $args = wp_parse_args( $args, $defaults );

    if ( ! $args['name'] ) {
        return;
    }

    $classes = array( 'pricing-card' );
    if ( $args['highlight'] ) {
        $classes[] = 'pricing-card--highlight';
    }
    ?>
    <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <?php if ( $args['badge'] ) : ?>
            <span class="pricing-card__badge"><?php echo esc_html( $args['badge'] ); ?></span>
        <?php endif; ?>

        <div class="pricing-card__header">
            <h3 class="pricing-card__name"><?php echo esc_html( $args['name'] ); ?></h3>

            <?php if ( $args['price'] ) : ?>
                <div class="pricing-card__price">
                    <span class="pricing-card__amount"><?php echo esc_html( $args['price'] ); ?></span>
                    <?php if ( $args['period'] ) : ?>
                        <span class="pricing-card__period"><?php echo esc_html( $args['period'] ); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( $args['description'] ) : ?>
                <p class="pricing-card__description"><?php echo esc_html( $args['description'] ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $args['features'] ) ) : ?>
            <ul class="pricing-card__features">
                <?php foreach ( $args['features'] as $feature ) : ?>
                    <?php if ( ! empty( $feature['text'] ) ) : ?>
                        <li class="pricing-card__feature">
                            <span class="pricing-card__feature-icon" aria-hidden="true">✓</span>
                            <?php echo esc_html( $feature['text'] ); ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ( $args['button'] && ! empty( $args['button']['url'] ) ) : ?>
            <div class="pricing-card__footer">
                <a
                    href="<?php echo esc_url( $args['button']['url'] ); ?>"
                    class="btn btn--primary btn--block"
                    <?php echo ! empty( $args['button']['target'] ) ? 'target="_blank" rel="noopener"' : ''; ?>
                >
                    <?php echo esc_html( $args['button']['title'] ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <?php
}