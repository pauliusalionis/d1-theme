<?php
/**
 * Block: Text + Image
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

// Media fields
$image       = get_field( 'media_image' );
$media_style = get_field( 'media_style' ) ?: 'default';

// Layout fields
$layout      = get_field( 'layout_position' ) ?: 'image-right';
$media_size  = get_field( 'layout_media_size' ) ?: 'default';

// Build block class
$block_class = 'text-image';

if ( $layout === 'image-left' ) {
    $block_class .= ' text-image--reverse';
}
if ( $layout === 'image-top' ) {
    $block_class .= ' text-image--top';
}
if ( $media_size === 'large' ) {
    $block_class .= ' text-image--media-large';
}
if ( $media_size === 'small' ) {
    $block_class .= ' text-image--media-small';
}

$split_class = '';

if ($layout === 'image-left') {
    $split_class = 'split--reverse';
} elseif ($layout === 'image-top') {
    $split_class = 'split--flex-reverse';
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
    <div class="split <?php echo esc_attr($split_class); ?>">
        
        <div class="text-image__content">
            <?php
            d1_heading_group( array(
                'eyebrow'     => $eyebrow,
                'heading'     => $heading,
                'heading_tag' => $heading_tag,
                'subheading'  => $subheading,
                'align'       => 'left',
            ) );

            d1_rich_text( $content );

            d1_button_group( $buttons, 'left' );
            ?>
        </div>

        <div class="text-image__media">
            <?php
            d1_media( array(
                'type'  => 'image',
                'image' => $image,
                'style' => $media_style,
                'size'  => 'large',
            ) );
            ?>
        </div>

    </div>
<?php
endif;

d1_section_close( $hidden );