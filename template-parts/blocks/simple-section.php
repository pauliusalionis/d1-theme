<?php
/**
 * Block: Simple Section
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
$content     = get_field( 'content' );
$buttons     = get_field( 'buttons' );
$text_align  = get_field( 'text_alignment' ) ?: 'left';

// Open section
d1_section_open( array(
    'anchor'     => $anchor,
    'class'      => trim( "simple-section $class_name" ),
    'background' => $background,
    'spacing'    => $spacing,
    'width'      => $width,
    'align'      => $align,
    'hidden'     => $hidden,
) );

if ( ! $hidden ) :
?>
    <div class="stack <?php echo $text_align === 'center' ? 'stack--center' : ''; ?>">
        
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
<?php
endif;

d1_section_close( $hidden );