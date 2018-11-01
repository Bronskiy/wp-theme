<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('booklovers_gutenberg_theme_setup')) {
    add_action( 'booklovers_action_before_init_theme', 'booklovers_gutenberg_theme_setup', 1 );
    function booklovers_gutenberg_theme_setup() {
        if (is_admin()) {
            add_filter( 'booklovers_filter_required_plugins', 'booklovers_gutenberg_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'booklovers_exists_gutenberg' ) ) {
    function booklovers_exists_gutenberg() {
        return function_exists( 'the_gutenberg_project' ) && function_exists( 'register_block_type' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'booklovers_gutenberg_required_plugins' ) ) {
    //add_filter('booklovers_filter_required_plugins',    'booklovers_gutenberg_required_plugins');
    function booklovers_gutenberg_required_plugins($list=array()) {
        if (in_array('gutenberg', (array)booklovers_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Gutenberg', 'booklovers'),
                'slug'         => 'gutenberg',
                'required'     => false
            );
        return $list;
    }
}