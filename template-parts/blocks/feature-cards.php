<?php
/**
 * Block: Feature Cards
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

// Cards fields
$cards       = get_field( 'cards' );
$columns     = get_field( 'columns' ) ?: '3';
$card_style  = get_field( 'card_style' ) ?: 'default';
$text_align  = get_field( 'text_alignment' ) ?: 'center';

// Build block class
$block_class = 'feature-cards';
if ( $text_align === 'left' ) {
	$block_class .= ' feature-cards--align-left';
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

	<?php if ( $cards ) : ?>
		<div class="feature-cards__grid feature-cards__grid--cols-<?php echo esc_attr( $columns ); ?>">
			<?php foreach ( $cards as $card ) : ?>
				<?php
				d1_card( array(
					'icon'        => $card['icon'] ?? '',
					'image'       => $card['image'] ?? null,
					'number'      => $card['number'] ?? '',
					'title'       => $card['title'] ?? '',
					'subtitle'    => $card['subtitle'] ?? '',
					'description' => $card['description'] ?? '',
					'link'        => $card['link'] ?? null,
					'badge'       => $card['badge'] ?? '',
					'style'       => $card_style,
					'highlight'   => $card['highlight'] ?? false,
				) );
				?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<?php
endif;

d1_section_close( $hidden );
