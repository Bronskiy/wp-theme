<?php
/* Instagram Widget support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('booklovers_instagram_widget_theme_setup')) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_instagram_widget_theme_setup', 1 );
	function booklovers_instagram_widget_theme_setup() {
		if (booklovers_exists_instagram_widget()) {
			add_action( 'booklovers_action_add_styles', 						'booklovers_instagram_widget_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'booklovers_filter_importer_required_plugins',		'booklovers_instagram_widget_importer_required_plugins', 10, 2 );
			add_filter( 'booklovers_filter_required_plugins',					'booklovers_instagram_widget_required_plugins' );
		}
	}
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'booklovers_exists_instagram_widget' ) ) {
	function booklovers_exists_instagram_widget() {
		return function_exists('wpiw_init');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'booklovers_instagram_widget_required_plugins' ) ) {
	//Handler of add_filter('booklovers_filter_required_plugins',	'booklovers_instagram_widget_required_plugins');
	function booklovers_instagram_widget_required_plugins($list=array()) {
		if (in_array('instagram_widget', booklovers_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Instagram Widget', 'booklovers'),
					'slug' 		=> 'wp-instagram-widget',
					'required' 	=> false
				);
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'booklovers_instagram_widget_frontend_scripts' ) ) {
	//Handler of add_action( 'booklovers_action_add_styles', 'booklovers_instagram_widget_frontend_scripts' );
	function booklovers_instagram_widget_frontend_scripts() {
		if (file_exists(booklovers_get_file_dir('css/plugin.instagram-widget.css')))
			wp_enqueue_style( 'booklovers-plugin.instagram-widget-style',  booklovers_get_file_url('css/plugin.instagram-widget.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Instagram Widget in the required plugins
if ( !function_exists( 'booklovers_instagram_widget_importer_required_plugins' ) ) {
	//Handler of add_filter( 'booklovers_filter_importer_required_plugins',	'booklovers_instagram_widget_importer_required_plugins', 10, 2 );
	function booklovers_instagram_widget_importer_required_plugins($not_installed='', $list='') {
		if (booklovers_strpos($list, 'instagram_widget')!==false && !booklovers_exists_instagram_widget() )
			$not_installed .= '<br>' . esc_html__('WP Instagram Widget', 'booklovers');
		return $not_installed;
	}
}
?>