<?php
/**
 * Block: CTA Contact
 *
 * @package D1
 */

// Block settings
$anchor     = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
$class_name = ! empty( $block['className'] ) ? $block['className'] : '';
$align      = ! empty( $block['align'] ) ? 'align' . $block['align'] : '';

// Section fields
$hidden     = get_field( 'section_hidden' );
$background = get_field( 'section_background' ) ?: 'brand';
$spacing    = get_field( 'section_spacing' ) ?: 'spacious';
$width      = get_field( 'section_width' ) ?: 'default';

// Content fields
$eyebrow     = get_field( 'heading_eyebrow' );
$heading     = get_field( 'heading_text' );
$heading_tag = get_field( 'heading_tag' ) ?: 'h2';
$subheading  = get_field( 'heading_subtext' );

// CTA fields
$contact_info = get_field( 'contact_info' );
$buttons      = get_field( 'buttons' );

// Build block class
$block_class = 'cta-contact';

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

	<div class="cta-contact__wrapper">
		<div class="cta-contact__content">
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

			<?php if ( $contact_info ) : ?>
				<div class="cta-contact__info">
					<?php foreach ( $contact_info as $info ) : ?>
						<?php
						d1_company_detail( array(
							'icon'  => $info['icon'] ?? '',
							'label' => $info['label'] ?? '',
							'value' => $info['value'] ?? '',
							'link'  => $info['link'] ?? null,
						) );
						?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $buttons ) : ?>
				<?php d1_button_group( $buttons, 'center' ); ?>
			<?php endif; ?>
		</div>
	</div>

<?php
endif;

d1_section_close( $hidden );
