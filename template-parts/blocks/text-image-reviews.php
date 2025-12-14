<?php
/**
 * Block: Text Image Reviews
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

// Layout fields
$text_content = get_field( 'text_content' );
$image        = get_field( 'image' );
$reviews      = get_field( 'reviews' );
$image_position = get_field( 'image_position' ) ?: 'left';
$show_rating  = get_field( 'show_ratings' ) !== false;

// Build block class
$block_class = 'text-image-reviews text-image-reviews--' . esc_attr( $image_position );

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

	<div class="text-image-reviews__wrapper">
		<div class="text-image-reviews__text">
			<?php
			// Render heading group
			if ( $eyebrow || $heading || $subheading ) {
				d1_heading_group( array(
					'eyebrow'     => $eyebrow,
					'heading'     => $heading,
					'heading_tag' => $heading_tag,
					'subheading'  => $subheading,
					'align'       => 'left',
				) );
			}
			?>

			<?php if ( $text_content ) : ?>
				<?php d1_rich_text( $text_content ); ?>
			<?php endif; ?>

			<?php if ( $reviews ) : ?>
				<div class="text-image-reviews__reviews">
					<?php foreach ( $reviews as $review ) : ?>
						<?php
						d1_review( array(
							'quote'       => $review['quote'] ?? '',
							'author'      => $review['author'] ?? '',
							'position'    => $review['position'] ?? '',
							'company'     => $review['company'] ?? '',
							'image'       => $review['image'] ?? null,
							'rating'      => $review['rating'] ?? 0,
							'show_rating' => $show_rating,
						) );
						?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $image ) : ?>
			<div class="text-image-reviews__image">
				<?php
				d1_media( array(
					'type'   => 'image',
					'image'  => $image,
					'aspect' => 'auto',
					'style'  => 'rounded',
					'size'   => 'large',
				) );
				?>
			</div>
		<?php endif; ?>
	</div>

<?php
endif;

d1_section_close( $hidden );
