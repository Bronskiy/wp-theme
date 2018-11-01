<?php
/* WPML support functions
------------------------------------------------------------------------------- */

// Check if WPML installed and activated
if ( !function_exists( 'booklovers_exists_wpml' ) ) {
	function booklovers_exists_wpml() {
		return defined('ICL_SITEPRESS_VERSION') && class_exists('sitepress');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'booklovers_wpml_required_plugins' ) ) {
	//Handler of add_filter('booklovers_filter_required_plugins',	'booklovers_wpml_required_plugins');
	function booklovers_wpml_required_plugins($list=array()) {
		if (in_array('wpml', booklovers_storage_get('required_plugins'))) {
			$path = booklovers_get_file_dir('plugins/install/wpml.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('WPML', 'booklovers'),
					'slug' 		=> 'wpml',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}
?>