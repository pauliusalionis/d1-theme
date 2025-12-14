<?php
/**
 * Block: Stats Grid
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

// Stats fields
$stats       = get_field( 'stats' );
$columns     = get_field( 'columns' ) ?: '4';
$animate     = get_field( 'animate_numbers' ) !== false;

// Build block class
$block_class = 'stats-grid';
if ( $animate ) {
	$block_class .= ' stats-grid--animate';
}

// Open section
d1_section_open( array(
	'anchor'     => $anchor,
	'class'      => trim( "$block_class $class_name js-fade-in" ),
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

	<?php if ( $stats ) : ?>
		<div class="stats-grid__grid stats-grid__grid--cols-<?php echo esc_attr( $columns ); ?>">
			<?php foreach ( $stats as $stat ) : ?>
				<?php
				d1_stat( array(
					'number'      => $stat['number'] ?? '',
					'prefix'      => $stat['prefix'] ?? '',
					'suffix'      => $stat['suffix'] ?? '',
					'label'       => $stat['label'] ?? '',
					'description' => $stat['description'] ?? '',
					'animate'     => $animate,
				) );
				?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<?php
endif;

d1_section_close( $hidden );
