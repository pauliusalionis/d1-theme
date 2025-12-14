<?php
/**
 * Block: Services List
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

// Query fields
$posts_per_page = get_field( 'posts_per_page' ) ?: 6;
$category       = get_field( 'category' );
$orderby        = get_field( 'orderby' ) ?: 'date';
$order          = get_field( 'order' ) ?: 'DESC';

// Display fields
$columns       = get_field( 'columns' ) ?: '3';
$card_style    = get_field( 'card_style' ) ?: 'elevated';
$text_align    = get_field( 'text_alignment' ) ?: 'center';
$show_excerpt  = get_field( 'show_excerpt' );
$show_image    = get_field( 'show_image' );
$show_category = get_field( 'show_category' );

// Build block class
$block_class = 'services-list';
if ( $text_align === 'left' ) {
	$block_class .= ' services-list--align-left';
}

// Build query args
$args = array(
	'post_type'      => 'd1_service',
	'posts_per_page' => $posts_per_page,
	'orderby'        => $orderby,
	'order'          => $order,
	'post_status'    => 'publish',
);

// Add category filter if selected
if ( $category ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'd1_service_cat',
			'field'    => 'term_id',
			'terms'    => $category,
		),
	);
}

// Execute query
$services_query = new WP_Query( $args );

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

	<?php if ( $services_query->have_posts() ) : ?>
		<div class="services-list__grid services-list__grid--cols-<?php echo esc_attr( $columns ); ?>">
			<?php
			while ( $services_query->have_posts() ) :
				$services_query->the_post();

				// Get service data
				$service_id       = get_the_ID();
				$service_title    = get_the_title();
				$service_excerpt  = get_the_excerpt();
				$service_image    = $show_image ? get_post_thumbnail_id() : null;
				$service_link     = array(
					'url'    => get_permalink(),
					'title'  => $service_title,
					'target' => '',
				);

				// Get category badge
				$badge = '';
				if ( $show_category ) {
					$terms = get_the_terms( $service_id, 'd1_service_cat' );
					if ( $terms && ! is_wp_error( $terms ) ) {
						$badge = $terms[0]->name;
					}
				}

				// Get ACF fields if they exist (for icon/number)
				$icon   = get_field( 'service_icon', $service_id ) ?: '';
				$number = get_field( 'service_number', $service_id ) ?: '';

				// Prepare card args
				$card_args = array(
					'title'       => $service_title,
					'description' => $show_excerpt ? $service_excerpt : '',
					'link'        => $service_link,
					'badge'       => $badge,
					'style'       => $card_style,
				);

				// Add image if enabled and exists
				if ( $service_image ) {
					$card_args['image'] = array( 'ID' => $service_image );
				} elseif ( $icon ) {
					$card_args['icon'] = $icon;
				} elseif ( $number ) {
					$card_args['number'] = $number;
				}

				d1_card( $card_args );

			endwhile;
			wp_reset_postdata();
			?>
		</div>
	<?php else : ?>
		<p class="services-list__no-results">
			<?php esc_html_e( 'No services found.', 'd1' ); ?>
		</p>
	<?php endif; ?>

<?php
endif;

d1_section_close( $hidden );
