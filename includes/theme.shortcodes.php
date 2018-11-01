<?php
if (!function_exists('booklovers_theme_shortcodes_setup')) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_theme_shortcodes_setup', 1 );
	function booklovers_theme_shortcodes_setup() {
		add_filter('booklovers_filter_googlemap_styles', 'booklovers_theme_shortcodes_googlemap_styles');
	}
}


// Add theme-specific Google map styles
if ( !function_exists( 'booklovers_theme_shortcodes_googlemap_styles' ) ) {
	function booklovers_theme_shortcodes_googlemap_styles($list) {
		$list['simple']		= esc_html__('Simple', 'booklovers');
		$list['greyscale']	= esc_html__('Greyscale', 'booklovers');
		$list['inverse']	= esc_html__('Inverse', 'booklovers');
		$list['dark']		= esc_html__('Dark', 'booklovers');
		return $list;
	}
}
?>