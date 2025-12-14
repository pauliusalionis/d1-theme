<?php
/**
 * Block: Logos Grid
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

// Logos fields
$logos       = get_field( 'logos' );
$columns     = get_field( 'columns' ) ?: '5';
$layout      = get_field( 'layout' ) ?: 'grid';

// Build block class
$block_class = 'logos-grid logos-grid--layout-' . esc_attr( $layout );

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

	<?php if ( $logos ) : ?>
		<div class="logos-grid__wrapper logos-grid__wrapper--cols-<?php echo esc_attr( $columns ); ?>" data-layout="<?php echo esc_attr( $layout ); ?>">
			<?php foreach ( $logos as $logo ) : ?>
				<?php
				d1_logo( array(
					'image' => $logo['image'] ?? null,
					'name'  => $logo['name'] ?? '',
					'link'  => $logo['link'] ?? null,
				) );
				?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<?php
endif;

d1_section_close( $hidden );
