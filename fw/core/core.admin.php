<?php
/**
 * Booklovers Framework: Admin functions
 *
 * @package	booklovers
 * @since	booklovers 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Admin actions and filters:
------------------------------------------------------------------------ */

if (is_admin()) {

	/* Theme setup section
	-------------------------------------------------------------------- */
	
	if ( !function_exists( 'booklovers_admin_theme_setup' ) ) {
		add_action( 'booklovers_action_before_init_theme', 'booklovers_admin_theme_setup', 11 );
		function booklovers_admin_theme_setup() {
			if ( is_admin() ) {
				add_action("admin_footer",			'booklovers_admin_prepare_scripts', 9);
				add_action("admin_enqueue_scripts",	'booklovers_admin_load_scripts');
				add_action('tgmpa_register',		'booklovers_admin_register_plugins');

				// AJAX: Get terms for specified post type
				add_action('wp_ajax_booklovers_admin_change_post_type', 		'booklovers_callback_admin_change_post_type');
				add_action('wp_ajax_nopriv_booklovers_admin_change_post_type','booklovers_callback_admin_change_post_type');
			}
		}
	}
	
	// Load required styles and scripts for admin mode
	if ( !function_exists( 'booklovers_admin_load_scripts' ) ) {
		//Handler of add_action("admin_enqueue_scripts", 'booklovers_admin_load_scripts');
		function booklovers_admin_load_scripts() {
            if (booklovers_get_theme_option('debug_mode')=='yes') {
                wp_enqueue_script( 'booklovers-core-debug-script', booklovers_get_file_url('js/core.debug.js'), array(), null, true );
            }
            //if (booklovers_options_is_used()) {
				wp_enqueue_style( 'booklovers-admin-style', booklovers_get_file_url('css/core.admin.css'), array(), null );
				wp_enqueue_script( 'booklovers-admin-script', booklovers_get_file_url('js/core.admin.js'), array('jquery'), null, true );
			//}
			if (booklovers_strpos(add_query_arg(array()), 'widgets.php')!==false) {
				wp_enqueue_style( 'booklovers-fontello-style', booklovers_get_file_url('css/fontello-admin/css/fontello-admin.css'), array(), null );
				wp_enqueue_style( 'booklovers-animations-style', booklovers_get_file_url('css/fontello-admin/css/animation.css'), array(), null );
			}
		}
	}
	


         // Prepare required styles and scripts for admin mode
        if ( !function_exists( 'booklovers_admin_prepare_scripts' ) ) {
            //Handler of add_action("admin_footer", 'booklovers_admin_prepare_scripts', 9);
            function booklovers_admin_prepare_scripts() {
                $vars = booklovers_storage_get('js_vars');
                if (empty($vars) || !is_array($vars)) $vars = array();
                $vars = array_merge($vars, array(
                    'admin_mode' => true,
                    'ajax_nonce' => wp_create_nonce(admin_url('admin-ajax.php')),
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'ajax_error' => esc_html__('Invalid server answer', 'booklovers'),
                    'importer_error_msg' => esc_html__('Errors that occurred during the import process:', 'booklovers'),
                    'msg_importer_full_alert' => esc_html__("ATTENTION!\n\nIn this case ALL THE OLD DATA WILL BE ERASED\nand YOU WILL GET A NEW SET OF POSTS, pages and menu items.", 'booklovers')
                        . "\n\n"
                        . esc_html__("It is strongly recommended only for new installations of WordPress\n(without posts, pages and any other data)!", 'booklovers')
                        . "\n\n"
                        . esc_html__("Press OK to continue or Cancel to return to a partial installation", 'booklovers'),
                    'user_logged_in' => true
                ));
                wp_localize_script('booklovers-admin-script', 'BOOKLOVERS_STORAGE', apply_filters('booklovers_action_add_scripts_inline', $vars));
                $code = booklovers_storage_get('js_code');
                if (!empty($js_code)) {
                    $st = '<';
                    $ct = '/';
                    $et = '>';
                    booklovers_show_layout($code, "{$st}script{$et}jQuery(document).ready(function(){", "});{$st}{$ct}script{$et}");
                }
            }
        }
	
	// AJAX: Get terms for specified post type
	if ( !function_exists( 'booklovers_callback_admin_change_post_type' ) ) {
		function booklovers_callback_admin_change_post_type() {
			if ( !wp_verify_nonce( booklovers_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
				die();
			$post_type = $_REQUEST['post_type'];
			$terms = booklovers_get_list_terms(false, booklovers_get_taxonomy_categories_by_post_type($post_type));
			$terms = booklovers_array_merge(array(0 => esc_html__('- Select category -', 'booklovers')), $terms);
			$response = array(
				'error' => '',
				'data' => array(
					'ids' => array_keys($terms),
					'titles' => array_values($terms)
				)
			);
			echo json_encode($response);
			die();
		}
	}

	// Return current post type in dashboard
	if ( !function_exists( 'booklovers_admin_get_current_post_type' ) ) {
		function booklovers_admin_get_current_post_type() {
			global $post, $typenow, $current_screen;
			if ( $post && $post->post_type )							//we have a post so we can just get the post type from that
				return $post->post_type;
			else if ( $typenow )										//check the global $typenow — set in admin.php
				return $typenow;
			else if ( $current_screen && $current_screen->post_type )	//check the global $current_screen object — set in sceen.php
				return $current_screen->post_type;
			else if ( isset( $_REQUEST['post_type'] ) )					//check the post_type querystring
				return sanitize_key( $_REQUEST['post_type'] );
			else if ( isset( $_REQUEST['post'] ) ) {					//lastly check the post id querystring
				$post = get_post( sanitize_key( $_REQUEST['post'] ) );
				return !empty($post->post_type) ? $post->post_type : '';
			} else														//we do not know the post type!
				return '';
		}
	}

	// Add admin menu pages
	if ( !function_exists( 'booklovers_admin_add_menu_item' ) ) {
		function booklovers_admin_add_menu_item($mode, $item, $pos='100') {
			static $shift = 0;
			if ($pos=='100') $pos .= '.'.$shift++;
			$fn = join('_', array('add', $mode, 'page'));
			if (empty($item['parent']))
				$fn($item['page_title'], $item['menu_title'], $item['capability'], $item['menu_slug'], $item['callback'], $item['icon'], $pos);
			else
				$fn($item['parent'], $item['page_title'], $item['menu_title'], $item['capability'], $item['menu_slug'], $item['callback'], $item['icon'], $pos);
		}
	}
	
	// Register optional plugins
	if ( !function_exists( 'booklovers_admin_register_plugins' ) ) {
		function booklovers_admin_register_plugins() {

			$plugins = apply_filters('booklovers_filter_required_plugins', array(
				array(
					'name' 		=> 'Booklovers Utilities',
					'version'	=> '2.6',				// Minimal required version
					'slug' 		=> 'trx_utils',
					'source'	=> booklovers_get_file_dir('plugins/install/trx_utils.zip'),
					'force_activation'   => false,		// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => true,		// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'required' 	=> true
				)
			));

			$config = array(
				'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'parent_slug'  => 'themes.php',            // Parent menu slug.
				'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => true,                    // Automatically activate plugins after installation or not.
				'message'      => ''                       // Message to output right before the plugins table.
			);
	
			tgmpa( $plugins, $config );
		}
	}

	require_once( get_template_directory().'/fw/lib/tgm/class-tgm-plugin-activation.php' );
}

?>