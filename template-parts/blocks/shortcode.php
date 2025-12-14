<?php
/**
 * Block: Shortcode
 *
 * @package D1
 */

// Block settings
$anchor     = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
$class_name = ! empty( $block['className'] ) ? $block['className'] : '';
$align      = ! empty( $block['align'] ) ? 'align' . $block['align'] : '';

// Section fields
$hidden     = get_field( 'section_hidden' );
$background = get_field( 'section_background' ) ?: 'default';
$spacing    = get_field( 'section_spacing' ) ?: 'default';
$width      = get_field( 'section_width' ) ?: 'default';

// Content fields
$eyebrow     = get_field( 'heading_eyebrow' );
$heading     = get_field( 'heading_text' );
$heading_tag = get_field( 'heading_tag' ) ?: 'h2';
$subheading  = get_field( 'heading_subtext' );
$text_align  = get_field( 'text_alignment' ) ?: 'center';

// Shortcode fields
$shortcode   = get_field( 'shortcode' );
$width       = get_field( 'shortcode_width' ) ?: 'default';

// Build block class
$block_class = 'shortcode-block';
if ( $width === 'narrow' ) {
    $block_class .= ' shortcode-block--narrow';
}

// Open section
d1_section_open( array(
    'anchor'     => $anchor,
    'class'      => trim( "$block_class $class_name" ),
    'background' => $background,
    'spacing'    => $spacing,
    'width'      => $width,
    'align'      => $align,
    'hidden'     => $hidden,
) );

if ( ! $hidden ) :
?>
    <div class="stack stack--lg <?php echo $text_align === 'center' ? 'stack--center' : ''; ?>">
        
        <?php
        d1_heading_group( array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'heading_tag' => $heading_tag,
            'subheading'  => $subheading,
            'align'       => $text_align,
        ) );
        ?>

        <?php if ( $shortcode ) : ?>
            <div class="shortcode-content">
                <?php echo do_shortcode( $shortcode ); ?>
            </div>
        <?php endif; ?>

    </div>
<?php
endif;

d1_section_close( $hidden );