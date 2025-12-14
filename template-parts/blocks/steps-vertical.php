<?php
/**
 * Block: Steps Vertical
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

// Steps fields
$steps           = get_field( 'steps' );
$show_numbers    = get_field( 'show_numbers' ) !== false;
$show_connector  = get_field( 'show_connector' ) !== false;

// Build block class
$block_class = 'steps-vertical';
if ( $show_connector ) {
	$block_class .= ' steps-vertical--connected';
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

	<?php if ( $steps ) : ?>
		<div class="steps-vertical__wrapper">
			<?php foreach ( $steps as $index => $step ) : ?>
				<?php
				d1_step( array(
					'number'      => $show_numbers ? ( $index + 1 ) : '',
					'icon'        => ( ! $show_numbers && ! empty( $step['icon'] ) ) ? $step['icon'] : '',
					'title'       => $step['title'] ?? '',
					'description' => $step['description'] ?? '',
					'link'        => $step['link'] ?? null,
				) );
				?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<?php
endif;

d1_section_close( $hidden );
