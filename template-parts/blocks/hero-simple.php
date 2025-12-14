<?php
/**
 * Block: Hero - Simple
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

// Content fields
$eyebrow     = get_field( 'heading_eyebrow' );
$heading     = get_field( 'heading_text' );
$heading_tag = get_field( 'heading_tag' ) ?: 'h1';
$subheading  = get_field( 'heading_subtext' );
$content     = get_field( 'content' );
$buttons     = get_field( 'buttons' );
$text_align  = get_field( 'text_alignment' ) ?: 'center';
$layout = get_field('hero_layout') ?: 'default';

// Open section
d1_section_open( array(
    'anchor'     => $anchor,
    'class'      => trim( "hero-simple hero-simple--{$layout} $class_name" ),
    'background' => $background,
    'spacing'    => $spacing,
    'width'      => $width,
    'align'      => $align,
    'hidden'     => $hidden,
) );

if ( ! $hidden ) :

    if ( $layout === 'alternative' ) : ?>
        
        <div class="hero-simple__alt">

            <div class="hero-simple__alt-left">
                <?php
                d1_heading_group( array(
                    'eyebrow'     => $eyebrow,
                    'heading'     => $heading,
                    'heading_tag' => $heading_tag,
                    // In this layout, we usually don't want subheading under the H1
                    'subheading'  => '',
                    'align'       => 'left',
                ) );
                ?>
            </div>

            <div class="hero-simple__alt-right">
                <?php
                // Right column: subheading + content + buttons
                if ( $subheading ) {
                    echo '<p class="hero-simple__alt-subheading">' . esc_html( $subheading ) . '</p>';
                }

                d1_rich_text( $content, 'default' );

                d1_button_group( $buttons, 'left' );
                ?>
            </div>

        </div>

    <?php else : ?>

        <div class="stack stack--lg <?php echo $text_align === 'center' ? 'stack--center' : ''; ?>">
            <?php
            d1_heading_group( array(
                'eyebrow'     => $eyebrow,
                'heading'     => $heading,
                'heading_tag' => $heading_tag,
                'subheading'  => $subheading,
                'align'       => $text_align,
            ) );

            d1_rich_text( $content, $text_align === 'center' ? 'narrow' : 'default' );
            d1_button_group( $buttons, $text_align );
            ?>
        </div>

    <?php endif;

endif;

d1_section_close( $hidden );