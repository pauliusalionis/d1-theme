<?php
/**
 * Theme header
 *
 * @package D1
 */

$has_acf = function_exists('get_field');

// ACF options (existing)
$logo_pos   = $has_acf ? (get_field('header_logo_position', 'option') ?: 'left') : 'left';
$menu_pos   = $has_acf ? (get_field('header_menu_position', 'option') ?: 'right') : 'right';
$is_sticky  = $has_acf ? (bool) get_field('header_sticky', 'option') : true;
$phone      = $has_acf ? trim((string) get_field('header_phone', 'option')) : '';
$cta        = $has_acf ? get_field('header_cta', 'option') : null;

$head_scripts = $has_acf ? (string) get_field('head_scripts', 'option') : '';
$body_scripts = $has_acf ? (string) get_field('body_scripts', 'option') : '';

// NEW options you want (safe defaults if fields not created yet)
$drawer_side = $has_acf ? (get_field('header_drawer_position', 'option') ?: 'right') : 'right'; // right|left
$drawer_on_desktop = $has_acf ? (bool) get_field('header_drawer_desktop', 'option') : false;     // true|false
$header_layout = $has_acf ? (get_field('header_layout', 'option') ?: 'boxed-wide') : 'boxed-wide'; // full-width|boxed|boxed-wide

// Header classes
$header_classes = array(
	'site-header',
	$is_sticky ? 'site-header--sticky' : '',
	'site-header--logo-' . sanitize_html_class($logo_pos),
	'site-header--menu-' . sanitize_html_class($menu_pos),
	sanitize_html_class($header_layout),
);
$header_classes = trim(implode(' ', array_filter($header_classes)));

// HTML classes
$html_classes = array();
if ($drawer_on_desktop) {
	$html_classes[] = 'has-drawer-desktop';
}
$html_class_attr = $html_classes ? ' class="' . esc_attr(implode(' ', $html_classes)) . '"' : '';

// Helpers
$phone_href = '';
if ($phone !== '') {
	$tel = preg_replace('/[^0-9\+]/', '', $phone);
	$phone_href = $tel ? 'tel:' . $tel : '';
}

$cta_url    = is_array($cta) && !empty($cta['url']) ? $cta['url'] : '';
$cta_title  = is_array($cta) && !empty($cta['title']) ? $cta['title'] : '';
$cta_target = is_array($cta) && !empty($cta['target']) ? $cta['target'] : '';

// Drawer class
$drawer_side_class = ($drawer_side === 'left') ? 'site-drawer--left' : 'site-drawer--right';
?>
<!DOCTYPE html>
<html<?php echo $html_class_attr; ?> <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>

	<?php if ($head_scripts) : ?>
		<?php echo $head_scripts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php endif; ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ($body_scripts) : ?>
	<?php echo $body_scripts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php endif; ?>

<a class="skip-link screen-reader-text" href="#main">
	<?php esc_html_e('Skip to content', 'd1'); ?>
</a>

<header class="<?php echo esc_attr($header_classes); ?> full-width">
	<div class="container site-header__inner">

		<div class="site-header__brand">
			<?php if (has_custom_logo()) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
					<?php bloginfo('name'); ?>
				</a>
			<?php endif; ?>
		</div>

		<?php if (has_nav_menu('primary')) : ?>
			<nav class="site-nav site-header__nav" aria-label="<?php echo esc_attr__('Primary Menu', 'd1'); ?>">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'fallback_cb'    => false,
				));
				?>
			</nav>
		<?php endif; ?>

		<div class="site-header__utils">
			<?php if ($phone && $phone_href) : ?>
				<a class="site-header__phone" href="<?php echo esc_url($phone_href); ?>">
					<?php echo esc_html($phone); ?>
				</a>
			<?php endif; ?>

			<?php if ($cta_url && $cta_title) : ?>
				<a class="btn btn--primary site-header__cta"
				   href="<?php echo esc_url($cta_url); ?>"
				   <?php echo $cta_target ? 'target="' . esc_attr($cta_target) . '"' : ''; ?>
				   <?php echo $cta_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
					<?php echo esc_html($cta_title); ?>
				</a>
			<?php endif; ?>

			<button class="site-header__toggle"
			        type="button"
			        aria-label="<?php echo esc_attr__('Open menu', 'd1'); ?>"
			        aria-controls="site-drawer"
			        aria-expanded="false">
				<span class="site-header__toggle-icon" aria-hidden="true"></span>
			</button>
		</div>

	</div>

	<div id="site-drawer" class="site-drawer <?php echo esc_attr($drawer_side_class); ?>" hidden>
		<div class="site-drawer__overlay" data-drawer-close></div>

		<div class="site-drawer__panel" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr__('Menu', 'd1'); ?>">
			<button class="site-drawer__close"
			        type="button"
			        data-drawer-close
			        aria-label="<?php echo esc_attr__('Close menu', 'd1'); ?>">
				×
			</button>

			<?php if (has_nav_menu('primary')) : ?>
				<nav class="site-drawer__nav" aria-label="<?php echo esc_attr__('Mobile Menu', 'd1'); ?>">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'site-drawer__list',
						'fallback_cb'    => false,
					));
					?>
				</nav>
			<?php endif; ?>

			<div class="site-drawer__utils">
				<?php if ($phone && $phone_href) : ?>
					<a class="btn btn--ghost" href="<?php echo esc_url($phone_href); ?>">
						<?php echo esc_html($phone); ?>
					</a>
				<?php endif; ?>

				<?php if ($cta_url && $cta_title) : ?>
					<a class="btn btn--primary"
					   href="<?php echo esc_url($cta_url); ?>"
					   <?php echo $cta_target ? 'target="' . esc_attr($cta_target) . '"' : ''; ?>
					   <?php echo $cta_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
						<?php echo esc_html($cta_title); ?>
					</a>
				<?php endif; ?>
			</div>

		</div>
	</div>
</header>