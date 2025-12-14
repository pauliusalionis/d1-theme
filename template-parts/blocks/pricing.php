<?php
/**
 * Block: Pricing
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

// Pricing fields
$plans             = get_field( 'plans' );
$columns           = get_field( 'columns' ) ?: '3';
$show_toggle       = get_field( 'show_billing_toggle' );
$toggle_label_1    = get_field( 'toggle_label_1' ) ?: 'Monthly';
$toggle_label_2    = get_field( 'toggle_label_2' ) ?: 'Yearly';

// Build block class
$block_class = 'pricing-block';
if ( $show_toggle ) {
	$block_class .= ' pricing-block--with-toggle';
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

	<?php if ( $show_toggle ) : ?>
		<div class="pricing-block__toggle">
			<button class="pricing-toggle" data-toggle-pricing>
				<span class="pricing-toggle__label pricing-toggle__label--active" data-label="1">
					<?php echo esc_html( $toggle_label_1 ); ?>
				</span>
				<span class="pricing-toggle__switch" aria-hidden="true"></span>
				<span class="pricing-toggle__label" data-label="2">
					<?php echo esc_html( $toggle_label_2 ); ?>
				</span>
			</button>
		</div>
	<?php endif; ?>

	<?php if ( $plans ) : ?>
		<div class="pricing-block__grid pricing-block__grid--cols-<?php echo esc_attr( $columns ); ?>">
			<?php foreach ( $plans as $plan ) : ?>
				<?php
				d1_pricing_card( array(
					'name'        => $plan['name'] ?? '',
					'price'       => $plan['price'] ?? '',
					'period'      => $plan['period'] ?? '',
					'description' => $plan['description'] ?? '',
					'features'    => $plan['features'] ?? array(),
					'button'      => $plan['button'] ?? null,
					'highlight'   => $plan['highlight'] ?? false,
					'badge'       => $plan['badge'] ?? '',
				) );
				?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<?php
endif;

d1_section_close( $hidden );
