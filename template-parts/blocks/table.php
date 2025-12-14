<?php
/**
 * Block: Table
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
$content     = get_field( 'content' );
$text_align  = get_field( 'text_alignment' ) ?: 'left';

// Table fields
$table_columns    = get_field( 'table_columns' );
$table_rows       = get_field( 'table_rows' );
$table_style      = get_field( 'table_style' ) ?: 'default';
$table_responsive = get_field( 'table_responsive_mode' ) ?: 'scroll';
$show_header      = get_field( 'show_header' );

// Build block class
$block_class = 'table-block';
if ( $table_style === 'striped' ) {
	$block_class .= ' table-block--striped';
} elseif ( $table_style === 'bordered' ) {
	$block_class .= ' table-block--bordered';
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
	<div class="stack <?php echo $text_align === 'center' ? 'stack--center' : ''; ?>">

		<?php
		d1_heading_group( array(
			'eyebrow'     => $eyebrow,
			'heading'     => $heading,
			'heading_tag' => $heading_tag,
			'subheading'  => $subheading,
			'align'       => $text_align,
		) );

		d1_rich_text( $content, $text_align === 'center' ? 'narrow' : 'default' );
		?>

		<?php if ( $table_columns || $table_rows ) : ?>
			<div class="table-block__wrapper table-block__wrapper--<?php echo esc_attr( $table_responsive ); ?>">
				<table class="table-block__table">

					<?php if ( $show_header && $table_columns ) : ?>
						<thead>
							<tr>
								<?php foreach ( $table_columns as $column ) : ?>
									<th><?php echo esc_html( $column['header_text'] ?? '' ); ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
					<?php endif; ?>

					<?php if ( $table_rows ) : ?>
						<tbody>
							<?php foreach ( $table_rows as $row ) : ?>
								<tr>
									<?php
									$cells = $row['cells'] ?? array();
									if ( $cells ) :
										foreach ( $cells as $cell ) :
											$cell_type = $cell['cell_type'] ?? 'td';
											$cell_text = $cell['cell_text'] ?? '';
											?>
											<<?php echo esc_attr( $cell_type ); ?>>
												<?php echo wp_kses_post( $cell_text ); ?>
											</<?php echo esc_attr( $cell_type ); ?>>
											<?php
										endforeach;
									endif;
									?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					<?php endif; ?>

				</table>
			</div>
		<?php endif; ?>

	</div>
<?php
endif;

d1_section_close( $hidden );
