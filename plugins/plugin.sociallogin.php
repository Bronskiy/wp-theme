<?php
/* WordPress Social Login support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('booklovers_sociallogin_theme_setup')) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_sociallogin_theme_setup', 1 );
	function booklovers_sociallogin_theme_setup() {
		if (is_admin()) {
			add_filter( 'booklovers_filter_required_plugins',					'booklovers_sociallogin_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'booklovers_sociallogin_required_plugins' ) ) {
	//Handler of add_filter('booklovers_filter_required_plugins',	'booklovers_wpml_required_plugins');
	function booklovers_sociallogin_required_plugins($list=array()) {
		if (in_array('sociallogin', booklovers_storage_get('required_plugins'))) {
				$list[] = array(
					'name' 		=> 'WordPress Social Login',
					'slug' 		=> 'wordpress-social-login',
					'required' 	=> false
					);
		}
		return $list;
	}
}
?>