<?php
/**
 * Block: Benefits Grid
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

// Benefits fields
$benefits    = get_field( 'benefits' );
$columns     = get_field( 'columns' ) ?: '3';
$show_icons  = get_field( 'show_icons' );
$text_align  = get_field( 'text_alignment' ) ?: 'center';

// Build block class
$block_class = 'benefits-grid';
if ( $text_align === 'left' ) {
	$block_class .= ' benefits-grid--align-left';
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

	<?php
	// Render heading group
	if ( $eyebrow || $heading || $subheading ) {
		d1_heading_group( array(
			'eyebrow'     => $eyebrow,
			'heading'     => $heading,
			'heading_tag' => $heading_tag,
			'subheading'  => $subheading,
			'align'       => 'center',
		) );
	}
	?>

	<?php if ( $benefits ) : ?>
		<div class="benefits-grid__grid benefits-grid__grid--cols-<?php echo esc_attr( $columns ); ?>">
			<?php foreach ( $benefits as $benefit ) : ?>
				<?php
				d1_card( array(
					'icon'        => ( $show_icons && ! empty( $benefit['icon'] ) ) ? $benefit['icon'] : '',
					'image'       => $benefit['image'] ?? null,
					'title'       => $benefit['title'] ?? '',
					'description' => $benefit['description'] ?? '',
					'link'        => $benefit['link'] ?? null,
					'style'       => 'default',
					'highlight'   => false,
				) );
				?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<?php
endif;

d1_section_close( $hidden );
