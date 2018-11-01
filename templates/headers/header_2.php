<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'booklovers_template_header_2_theme_setup' ) ) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_template_header_2_theme_setup', 1 );
	function booklovers_template_header_2_theme_setup() {
		booklovers_add_template(array(
			'layout' => 'header_2',
			'mode'   => 'header',
			'title'  => esc_html__('Header 2', 'booklovers'),
			'icon'   => booklovers_get_file_url('templates/headers/images/2.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'booklovers_template_header_2_output' ) ) {
	function booklovers_template_header_2_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!=''
			? ' style="background-image: url('.esc_url($header_image).')"'
			: '';
		}
		?>

		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_2 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_2 top_panel_position_<?php echo esc_attr(booklovers_get_custom_option('top_panel_position')); ?>">

				<?php
				if (booklovers_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<div class="slogan_in_top"><?php echo booklovers_get_custom_option('welcome_slogan');?></div>
						<?php
						booklovers_template_set_args('top-panel-top', array(
							'top_panel_top_components' => array('login')
							));
						get_template_part(booklovers_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
				<?php } ?>

				<div class="top_panel_middle" <?php booklovers_show_layout($header_css); ?>>
					<div class="content_wrap">
						<div class="columns_wrap columns_fluid">
							<div class="column-1_4 contact_phone_in_top">
								<?php
								$contact_phone = booklovers_get_custom_option('contact_phone');
								echo (!empty($contact_phone) ? esc_html__('Free Call','booklovers') . ' <span><a href="tel:'. esc_attr($contact_phone).'">' . esc_attr($contact_phone). '</a></span>' : '');?>
							</div><div class="column-1_2 contact_logo">
								<?php booklovers_show_logo(); ?>
							</div><div class="column-1_4 menu_user_cart">
								<?php
							if (function_exists('booklovers_exists_woocommerce') && booklovers_exists_woocommerce() && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) {
							 get_template_part(booklovers_get_file_slug('templates/headers/_parts/contact-info-cart.php')); }?>
							</div>
						</div>
					</div>
				</div>

				<div class="top_panel_bottom">
					<div class="content_wrap clearfix">
						<nav class="menu_main_nav_area">
							<?php
							$menu_main = booklovers_get_nav_menu('menu_main');
							if (empty($menu_main)) $menu_main = booklovers_get_nav_menu();
							booklovers_show_layout($menu_main);
							?>
						</nav>
					</div>
				</div>

			</div>
		</header>

		<?php
		booklovers_storage_set('header_mobile', array(
			'open_hours' => false,
			'login' => true,
			'socials' => true,
			'bookmarks' => true,
			'contact_address' => false,
			'contact_phone_email' => true,
			'woo_cart' => true,
			'search' => true
			)
		);
	}
}
?>
