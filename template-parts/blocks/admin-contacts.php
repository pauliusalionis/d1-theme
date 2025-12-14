<?php
/**
 * Block: Admin Contacts
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

// Contacts fields
$contacts = get_field( 'contacts' );
$columns  = get_field( 'columns' ) ?: '3';

// Build block class
$block_class = 'admin-contacts';

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

	<?php if ( $contacts ) : ?>
		<div class="admin-contacts__grid admin-contacts__grid--cols-<?php echo esc_attr( $columns ); ?>">
			<?php foreach ( $contacts as $contact ) : ?>
				<?php
				d1_person( array(
					'image'       => $contact['image'] ?? null,
					'name'        => $contact['name'] ?? '',
					'position'    => $contact['position'] ?? '',
					'description' => $contact['description'] ?? '',
					'email'       => $contact['email'] ?? '',
					'phone'       => $contact['phone'] ?? '',
					'social'      => array(),
				) );
				?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<?php
endif;

d1_section_close( $hidden );
