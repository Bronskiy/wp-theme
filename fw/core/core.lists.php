<?php
/**
 * Booklovers Framework: return lists
 *
 * @package booklovers
 * @since booklovers 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'booklovers_get_list_styles' ) ) {
	function booklovers_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'booklovers'), $i);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'booklovers_get_list_margins' ) ) {
	function booklovers_get_list_margins($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_margins'))=='') {
			$list = array(
				'null'		=> esc_html__('0 (No margin)',	'booklovers'),
				'tiny'		=> esc_html__('Tiny',		'booklovers'),
				'small'		=> esc_html__('Small',		'booklovers'),
				'medium'	=> esc_html__('Medium',		'booklovers'),
				'large'		=> esc_html__('Large',		'booklovers'),
				'huge'		=> esc_html__('Huge',		'booklovers'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'booklovers'),
				'small-'	=> esc_html__('Small (negative)',	'booklovers'),
				'medium-'	=> esc_html__('Medium (negative)',	'booklovers'),
				'large-'	=> esc_html__('Large (negative)',	'booklovers'),
				'huge-'		=> esc_html__('Huge (negative)',	'booklovers')
				);
			$list = apply_filters('booklovers_filter_list_margins', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_margins', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'booklovers_get_list_animations' ) ) {
	function booklovers_get_list_animations($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_animations'))=='') {
			$list = array(
				'none'			=> esc_html__('- None -',	'booklovers'),
				'bounced'		=> esc_html__('Bounced',		'booklovers'),
				'flash'			=> esc_html__('Flash',		'booklovers'),
				'flip'			=> esc_html__('Flip',		'booklovers'),
				'pulse'			=> esc_html__('Pulse',		'booklovers'),
				'rubberBand'	=> esc_html__('Rubber Band',	'booklovers'),
				'shake'			=> esc_html__('Shake',		'booklovers'),
				'swing'			=> esc_html__('Swing',		'booklovers'),
				'tada'			=> esc_html__('Tada',		'booklovers'),
				'wobble'		=> esc_html__('Wobble',		'booklovers')
				);
			$list = apply_filters('booklovers_filter_list_animations', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_animations', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the line styles
if ( !function_exists( 'booklovers_get_list_line_styles' ) ) {
	function booklovers_get_list_line_styles($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_line_styles'))=='') {
			$list = array(
				'solid'	=> esc_html__('Solid', 'booklovers'),
				'dashed'=> esc_html__('Dashed', 'booklovers'),
				'dotted'=> esc_html__('Dotted', 'booklovers'),
				'double'=> esc_html__('Double', 'booklovers'),
				'image'	=> esc_html__('Image', 'booklovers')
				);
			$list = apply_filters('booklovers_filter_list_line_styles', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_line_styles', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'booklovers_get_list_animations_in' ) ) {
	function booklovers_get_list_animations_in($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_animations_in'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'booklovers'),
				'bounceIn'			=> esc_html__('Bounce In',			'booklovers'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'booklovers'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'booklovers'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'booklovers'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'booklovers'),
				'fadeIn'			=> esc_html__('Fade In',			'booklovers'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'booklovers'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'booklovers'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'booklovers'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'booklovers'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'booklovers'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'booklovers'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'booklovers'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'booklovers'),
				'flipInX'			=> esc_html__('Flip In X',			'booklovers'),
				'flipInY'			=> esc_html__('Flip In Y',			'booklovers'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'booklovers'),
				'rotateIn'			=> esc_html__('Rotate In',			'booklovers'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','booklovers'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'booklovers'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'booklovers'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','booklovers'),
				'rollIn'			=> esc_html__('Roll In',			'booklovers'),
				'slideInUp'			=> esc_html__('Slide In Up',		'booklovers'),
				'slideInDown'		=> esc_html__('Slide In Down',		'booklovers'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'booklovers'),
				'slideInRight'		=> esc_html__('Slide In Right',		'booklovers'),
				'zoomIn'			=> esc_html__('Zoom In',			'booklovers'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'booklovers'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'booklovers'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'booklovers'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'booklovers')
				);
			$list = apply_filters('booklovers_filter_list_animations_in', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_animations_in', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'booklovers_get_list_animations_out' ) ) {
	function booklovers_get_list_animations_out($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_animations_out'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',	'booklovers'),
				'bounceOut'			=> esc_html__('Bounce Out',			'booklovers'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'booklovers'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',		'booklovers'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',		'booklovers'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'booklovers'),
				'fadeOut'			=> esc_html__('Fade Out',			'booklovers'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',			'booklovers'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'booklovers'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'booklovers'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'booklovers'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',		'booklovers'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'booklovers'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'booklovers'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'booklovers'),
				'flipOutX'			=> esc_html__('Flip Out X',			'booklovers'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'booklovers'),
				'hinge'				=> esc_html__('Hinge Out',			'booklovers'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',		'booklovers'),
				'rotateOut'			=> esc_html__('Rotate Out',			'booklovers'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left',	'booklovers'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right',		'booklovers'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',		'booklovers'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right',	'booklovers'),
				'rollOut'			=> esc_html__('Roll Out',		'booklovers'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'booklovers'),
				'slideOutDown'		=> esc_html__('Slide Out Down',	'booklovers'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',	'booklovers'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'booklovers'),
				'zoomOut'			=> esc_html__('Zoom Out',			'booklovers'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'booklovers'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',	'booklovers'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',	'booklovers'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',	'booklovers')
				);
			$list = apply_filters('booklovers_filter_list_animations_out', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_animations_out', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('booklovers_get_animation_classes')) {
	function booklovers_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return booklovers_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!booklovers_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of categories
if ( !function_exists( 'booklovers_get_list_categories' ) ) {
	function booklovers_get_list_categories($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'booklovers_get_list_terms' ) ) {
	function booklovers_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = booklovers_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$terms = get_terms( $taxonomy, array(
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 0,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $taxonomy,
					'pad_counts'               => false
					)
				);
			} else {
				$terms = booklovers_get_terms_by_taxonomy_from_db($taxonomy);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $cat) {
					$list[$cat->term_id] = $cat->name;	// . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
				}
			}
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'booklovers_get_list_posts_types' ) ) {
	function booklovers_get_list_posts_types($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_posts_types'))=='') {
			// Return only theme inheritance supported post types
			$list = apply_filters('booklovers_filter_list_post_types', array());
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'booklovers_get_list_posts' ) ) {
	function booklovers_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = booklovers_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'booklovers');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set($hash, $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list pages
if ( !function_exists( 'booklovers_get_list_pages' ) ) {
	function booklovers_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return booklovers_get_list_posts($prepend_inherit, $opt);
	}
}


// Return list of registered users
if ( !function_exists( 'booklovers_get_list_users' ) ) {
	function booklovers_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = booklovers_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'booklovers');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_users', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return images list
if (!function_exists('booklovers_get_list_images')) {	
	function booklovers_get_list_images($folder, $ext='', $only_names=false) {
		return function_exists('trx_utils_get_folder_list') ? trx_utils_get_folder_list($folder, $ext, $only_names) : array();
	}
}

// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'booklovers_get_list_sliders' ) ) {
	function booklovers_get_list_sliders($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_sliders'))=='') {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'booklovers')
			);
			$list = apply_filters('booklovers_filter_list_sliders', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_sliders', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'booklovers_get_list_slider_controls' ) ) {
	function booklovers_get_list_slider_controls($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_slider_controls'))=='') {
			$list = array(
				'no'		=> esc_html__('None', 'booklovers'),
				'side'		=> esc_html__('Side', 'booklovers'),
				'bottom'	=> esc_html__('Bottom', 'booklovers'),
				'pagination'=> esc_html__('Pagination', 'booklovers')
				);
			$list = apply_filters('booklovers_filter_list_slider_controls', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_slider_controls', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'booklovers_get_slider_controls_classes' ) ) {
	function booklovers_get_slider_controls_classes($controls) {
		if (booklovers_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'booklovers_get_list_popup_engines' ) ) {
	function booklovers_get_list_popup_engines($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_popup_engines'))=='') {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'booklovers'),
				"magnific"	=> esc_html__("Magnific popup", 'booklovers')
				);
			$list = apply_filters('booklovers_filter_list_popup_engines', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_popup_engines', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'booklovers_get_list_menus' ) ) {
	function booklovers_get_list_menus($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'booklovers');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'booklovers_get_list_sidebars' ) ) {
	function booklovers_get_list_sidebars($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_sidebars'))=='') {
			if (($list = booklovers_storage_get('registered_sidebars'))=='') $list = array();
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'booklovers_get_list_sidebars_positions' ) ) {
	function booklovers_get_list_sidebars_positions($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_sidebars_positions'))=='') {
			$list = array(
				'none'  => esc_html__('Hide',  'booklovers'),
				'left'  => esc_html__('Left',  'booklovers'),
				'right' => esc_html__('Right', 'booklovers')
				);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_sidebars_positions', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'booklovers_get_sidebar_class' ) ) {
	function booklovers_get_sidebar_class() {
		$sb_main = booklovers_get_custom_option('show_sidebar_main');
		$sb_outer = booklovers_get_custom_option('show_sidebar_outer');
		return (booklovers_param_is_off($sb_main) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (booklovers_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'booklovers_get_list_body_styles' ) ) {
	function booklovers_get_list_body_styles($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_body_styles'))=='') {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'booklovers'),
				'wide'	=> esc_html__('Wide',		'booklovers')
				);
			if (booklovers_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'booklovers');
				$list['fullscreen']	= esc_html__('Fullscreen',	'booklovers');
			}
			$list = apply_filters('booklovers_filter_list_body_styles', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_body_styles', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return skins list, prepended inherit
if ( !function_exists( 'booklovers_get_list_skins' ) ) {
	function booklovers_get_list_skins($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_skins'))=='') {
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_skins', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'booklovers_get_list_templates' ) ) {
	function booklovers_get_list_templates($mode='') {
		if (($list = booklovers_storage_get('list_templates_'.($mode)))=='') {
			$list = array();
			$tpl = booklovers_storage_get('registered_templates');
			if (is_array($tpl) && count($tpl) > 0) {
				foreach ($tpl as $k=>$v) {
					if ($mode=='' || in_array($mode, explode(',', $v['mode'])))
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: booklovers_strtoproper($v['layout'])
										);
				}
			}
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_templates_'.($mode), $list);
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'booklovers_get_list_templates_blog' ) ) {
	function booklovers_get_list_templates_blog($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_templates_blog'))=='') {
			$list = booklovers_get_list_templates('blog');
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_templates_blog', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'booklovers_get_list_templates_blogger' ) ) {
	function booklovers_get_list_templates_blogger($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_templates_blogger'))=='') {
			$list = booklovers_array_merge(booklovers_get_list_templates('blogger'), booklovers_get_list_templates('blog'));
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_templates_blogger', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'booklovers_get_list_templates_single' ) ) {
	function booklovers_get_list_templates_single($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_templates_single'))=='') {
			$list = booklovers_get_list_templates('single');
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_templates_single', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'booklovers_get_list_templates_header' ) ) {
	function booklovers_get_list_templates_header($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_templates_header'))=='') {
			$list = booklovers_get_list_templates('header');
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_templates_header', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'booklovers_get_list_templates_forms' ) ) {
	function booklovers_get_list_templates_forms($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_templates_forms'))=='') {
			$list = booklovers_get_list_templates('forms');
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_templates_forms', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'booklovers_get_list_article_styles' ) ) {
	function booklovers_get_list_article_styles($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_article_styles'))=='') {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'booklovers'),
				"stretch" => esc_html__('Stretch', 'booklovers')
				);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_article_styles', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'booklovers_get_list_post_formats_filters' ) ) {
	function booklovers_get_list_post_formats_filters($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_post_formats_filters'))=='') {
			$list = array(
				"no"      => esc_html__('All posts', 'booklovers'),
				"thumbs"  => esc_html__('With thumbs', 'booklovers'),
				"reviews" => esc_html__('With reviews', 'booklovers'),
				"video"   => esc_html__('With videos', 'booklovers'),
				"audio"   => esc_html__('With audios', 'booklovers'),
				"gallery" => esc_html__('With galleries', 'booklovers')
				);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_post_formats_filters', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'booklovers_get_list_portfolio_filters' ) ) {
	function booklovers_get_list_portfolio_filters($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_portfolio_filters'))=='') {
			$list = array(
				"hide"		=> esc_html__('Hide', 'booklovers'),
				"tags"		=> esc_html__('Tags', 'booklovers'),
				"categories"=> esc_html__('Categories', 'booklovers')
				);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_portfolio_filters', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'booklovers_get_list_hovers' ) ) {
	function booklovers_get_list_hovers($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_hovers'))=='') {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'booklovers');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'booklovers');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'booklovers');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'booklovers');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'booklovers');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'booklovers');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'booklovers');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'booklovers');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'booklovers');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'booklovers');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'booklovers');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'booklovers');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'booklovers');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'booklovers');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'booklovers');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'booklovers');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'booklovers');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'booklovers');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'booklovers');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'booklovers');
			$list['square effect1']  = esc_html__('Square Effect 1',  'booklovers');
			$list['square effect2']  = esc_html__('Square Effect 2',  'booklovers');
			$list['square effect3']  = esc_html__('Square Effect 3',  'booklovers');
	//		$list['square effect4']  = esc_html__('Square Effect 4',  'booklovers');
			$list['square effect5']  = esc_html__('Square Effect 5',  'booklovers');
			$list['square effect6']  = esc_html__('Square Effect 6',  'booklovers');
			$list['square effect7']  = esc_html__('Square Effect 7',  'booklovers');
			$list['square effect8']  = esc_html__('Square Effect 8',  'booklovers');
			$list['square effect9']  = esc_html__('Square Effect 9',  'booklovers');
			$list['square effect10'] = esc_html__('Square Effect 10',  'booklovers');
			$list['square effect11'] = esc_html__('Square Effect 11',  'booklovers');
			$list['square effect12'] = esc_html__('Square Effect 12',  'booklovers');
			$list['square effect13'] = esc_html__('Square Effect 13',  'booklovers');
			$list['square effect14'] = esc_html__('Square Effect 14',  'booklovers');
			$list['square effect15'] = esc_html__('Square Effect 15',  'booklovers');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'booklovers');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'booklovers');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'booklovers');
			$list['square effect_more']  = esc_html__('Square Effect More',  'booklovers');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'booklovers');
			$list = apply_filters('booklovers_filter_portfolio_hovers', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_hovers', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'booklovers_get_list_blog_counters' ) ) {
	function booklovers_get_list_blog_counters($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_blog_counters'))=='') {
			$list = array(
				'views'		=> esc_html__('Views', 'booklovers'),
				'likes'		=> esc_html__('Likes', 'booklovers'),
				'rating'	=> esc_html__('Rating', 'booklovers'),
				'comments'	=> esc_html__('Comments', 'booklovers')
				);
			$list = apply_filters('booklovers_filter_list_blog_counters', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_blog_counters', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'booklovers_get_list_alter_sizes' ) ) {
	function booklovers_get_list_alter_sizes($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_alter_sizes'))=='') {
			$list = array(
					'1_1' => esc_html__('1x1', 'booklovers'),
					'1_2' => esc_html__('1x2', 'booklovers'),
					'2_1' => esc_html__('2x1', 'booklovers'),
					'2_2' => esc_html__('2x2', 'booklovers'),
					'1_3' => esc_html__('1x3', 'booklovers'),
					'2_3' => esc_html__('2x3', 'booklovers'),
					'3_1' => esc_html__('3x1', 'booklovers'),
					'3_2' => esc_html__('3x2', 'booklovers'),
					'3_3' => esc_html__('3x3', 'booklovers')
					);
			$list = apply_filters('booklovers_filter_portfolio_alter_sizes', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_alter_sizes', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'booklovers_get_list_hovers_directions' ) ) {
	function booklovers_get_list_hovers_directions($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_hovers_directions'))=='') {
			$list = array(
				'left_to_right' => esc_html__('Left to Right',  'booklovers'),
				'right_to_left' => esc_html__('Right to Left',  'booklovers'),
				'top_to_bottom' => esc_html__('Top to Bottom',  'booklovers'),
				'bottom_to_top' => esc_html__('Bottom to Top',  'booklovers'),
				'scale_up'      => esc_html__('Scale Up',  'booklovers'),
				'scale_down'    => esc_html__('Scale Down',  'booklovers'),
				'scale_down_up' => esc_html__('Scale Down-Up',  'booklovers'),
				'from_left_and_right' => esc_html__('From Left and Right',  'booklovers'),
				'from_top_and_bottom' => esc_html__('From Top and Bottom',  'booklovers')
			);
			$list = apply_filters('booklovers_filter_portfolio_hovers_directions', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_hovers_directions', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'booklovers_get_list_label_positions' ) ) {
	function booklovers_get_list_label_positions($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_label_positions'))=='') {
			$list = array(
				'top'		=> esc_html__('Top',		'booklovers'),
				'bottom'	=> esc_html__('Bottom',		'booklovers'),
				'left'		=> esc_html__('Left',		'booklovers'),
				'over'		=> esc_html__('Over',		'booklovers')
			);
			$list = apply_filters('booklovers_filter_label_positions', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_label_positions', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'booklovers_get_list_bg_image_positions' ) ) {
	function booklovers_get_list_bg_image_positions($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_bg_image_positions'))=='') {
			$list = array(
				'left top'	   => esc_html__('Left Top', 'booklovers'),
				'center top'   => esc_html__("Center Top", 'booklovers'),
				'right top'    => esc_html__("Right Top", 'booklovers'),
				'left center'  => esc_html__("Left Center", 'booklovers'),
				'center center'=> esc_html__("Center Center", 'booklovers'),
				'right center' => esc_html__("Right Center", 'booklovers'),
				'left bottom'  => esc_html__("Left Bottom", 'booklovers'),
				'center bottom'=> esc_html__("Center Bottom", 'booklovers'),
				'right bottom' => esc_html__("Right Bottom", 'booklovers')
			);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_bg_image_positions', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'booklovers_get_list_bg_image_repeats' ) ) {
	function booklovers_get_list_bg_image_repeats($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_bg_image_repeats'))=='') {
			$list = array(
				'repeat'	=> esc_html__('Repeat', 'booklovers'),
				'repeat-x'	=> esc_html__('Repeat X', 'booklovers'),
				'repeat-y'	=> esc_html__('Repeat Y', 'booklovers'),
				'no-repeat'	=> esc_html__('No Repeat', 'booklovers')
			);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_bg_image_repeats', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'booklovers_get_list_bg_image_attachments' ) ) {
	function booklovers_get_list_bg_image_attachments($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_bg_image_attachments'))=='') {
			$list = array(
				'scroll'	=> esc_html__('Scroll', 'booklovers'),
				'fixed'		=> esc_html__('Fixed', 'booklovers'),
				'local'		=> esc_html__('Local', 'booklovers')
			);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_bg_image_attachments', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'booklovers_get_list_bg_tints' ) ) {
	function booklovers_get_list_bg_tints($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_bg_tints'))=='') {
			$list = array(
				'white'	=> esc_html__('White', 'booklovers'),
				'light'	=> esc_html__('Light', 'booklovers'),
				'dark'	=> esc_html__('Dark', 'booklovers')
			);
			$list = apply_filters('booklovers_filter_bg_tints', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_bg_tints', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'booklovers_get_list_field_types' ) ) {
	function booklovers_get_list_field_types($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_field_types'))=='') {
			$list = array(
				'text'     => esc_html__('Text',  'booklovers'),
				'textarea' => esc_html__('Text Area','booklovers'),
				'password' => esc_html__('Password',  'booklovers'),
				'radio'    => esc_html__('Radio',  'booklovers'),
				'checkbox' => esc_html__('Checkbox',  'booklovers'),
				'select'   => esc_html__('Select',  'booklovers'),
				'date'     => esc_html__('Date','booklovers'),
				'time'     => esc_html__('Time','booklovers'),
				'button'   => esc_html__('Button','booklovers')
			);
			$list = apply_filters('booklovers_filter_field_types', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_field_types', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'booklovers_get_list_googlemap_styles' ) ) {
	function booklovers_get_list_googlemap_styles($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_googlemap_styles'))=='') {
			$list = array(
				'default' => esc_html__('Default', 'booklovers')
			);
			$list = apply_filters('booklovers_filter_googlemap_styles', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_googlemap_styles', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'booklovers_get_list_icons' ) ) {
	function booklovers_get_list_icons($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_icons'))=='') {
			$list = booklovers_parse_icons_classes(booklovers_get_file_dir("css/fontello/css/fontello-codes.css"));
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_icons', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'booklovers_get_list_socials' ) ) {
	function booklovers_get_list_socials($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_socials'))=='') {
			$list = booklovers_get_list_images("images/socials", "png");
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_socials', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'booklovers_get_list_yesno' ) ) {
	function booklovers_get_list_yesno($prepend_inherit=false) {
		$list = array(
			'yes' => esc_html__("Yes", 'booklovers'),
			'no'  => esc_html__("No", 'booklovers')
		);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'booklovers_get_list_onoff' ) ) {
	function booklovers_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on" => esc_html__("On", 'booklovers'),
			"off" => esc_html__("Off", 'booklovers')
		);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'booklovers_get_list_showhide' ) ) {
	function booklovers_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'booklovers'),
			"hide" => esc_html__("Hide", 'booklovers')
		);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'booklovers_get_list_orderings' ) ) {
	function booklovers_get_list_orderings($prepend_inherit=false) {
		$list = array(
			"asc" => esc_html__("Ascending", 'booklovers'),
			"desc" => esc_html__("Descending", 'booklovers')
		);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'booklovers_get_list_directions' ) ) {
	function booklovers_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'booklovers'),
			"vertical" => esc_html__("Vertical", 'booklovers')
		);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'booklovers_get_list_shapes' ) ) {
	function booklovers_get_list_shapes($prepend_inherit=false) {
		$list = array(
			"round"  => esc_html__("Round", 'booklovers'),
			"square" => esc_html__("Square", 'booklovers')
		);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'booklovers_get_list_sizes' ) ) {
	function booklovers_get_list_sizes($prepend_inherit=false) {
		$list = array(
			"tiny"   => esc_html__("Tiny", 'booklovers'),
			"small"  => esc_html__("Small", 'booklovers'),
			"medium" => esc_html__("Medium", 'booklovers'),
			"large"  => esc_html__("Large", 'booklovers')
		);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with slider (scroll) controls positions
if ( !function_exists( 'booklovers_get_list_controls' ) ) {
	function booklovers_get_list_controls($prepend_inherit=false) {
		$list = array(
			"hide" => esc_html__("Hide", 'booklovers'),
			"side" => esc_html__("Side", 'booklovers'),
			"bottom" => esc_html__("Bottom", 'booklovers')
		);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'booklovers_get_list_floats' ) ) {
	function booklovers_get_list_floats($prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'booklovers'),
			"left" => esc_html__("Float Left", 'booklovers'),
			"right" => esc_html__("Float Right", 'booklovers')
		);
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'booklovers_get_list_alignments' ) ) {
	function booklovers_get_list_alignments($justify=false, $prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'booklovers'),
			"left" => esc_html__("Left", 'booklovers'),
			"center" => esc_html__("Center", 'booklovers'),
			"right" => esc_html__("Right", 'booklovers')
		);
		if ($justify) $list["justify"] = esc_html__("Justify", 'booklovers');
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with horizontal positions
if ( !function_exists( 'booklovers_get_list_hpos' ) ) {
	function booklovers_get_list_hpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['left'] = esc_html__("Left", 'booklovers');
		if ($center) $list['center'] = esc_html__("Center", 'booklovers');
		$list['right'] = esc_html__("Right", 'booklovers');
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with vertical positions
if ( !function_exists( 'booklovers_get_list_vpos' ) ) {
	function booklovers_get_list_vpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['top'] = esc_html__("Top", 'booklovers');
		if ($center) $list['center'] = esc_html__("Center", 'booklovers');
		$list['bottom'] = esc_html__("Bottom", 'booklovers');
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'booklovers_get_list_sortings' ) ) {
	function booklovers_get_list_sortings($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_sortings'))=='') {
			$list = array(
				"date" => esc_html__("Date", 'booklovers'),
				"title" => esc_html__("Alphabetically", 'booklovers'),
				"views" => esc_html__("Popular (views count)", 'booklovers'),
				"comments" => esc_html__("Most commented (comments count)", 'booklovers'),
				"author_rating" => esc_html__("Author rating", 'booklovers'),
				"users_rating" => esc_html__("Visitors (users) rating", 'booklovers'),
				"random" => esc_html__("Random", 'booklovers')
			);
			$list = apply_filters('booklovers_filter_list_sortings', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_sortings', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'booklovers_get_list_columns' ) ) {
	function booklovers_get_list_columns($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_columns'))=='') {
			$list = array(
				"none" => esc_html__("None", 'booklovers'),
				"1_1" => esc_html__("100%", 'booklovers'),
				"1_2" => esc_html__("1/2", 'booklovers'),
				"1_3" => esc_html__("1/3", 'booklovers'),
				"2_3" => esc_html__("2/3", 'booklovers'),
				"1_4" => esc_html__("1/4", 'booklovers'),
				"3_4" => esc_html__("3/4", 'booklovers'),
				"1_5" => esc_html__("1/5", 'booklovers'),
				"2_5" => esc_html__("2/5", 'booklovers'),
				"3_5" => esc_html__("3/5", 'booklovers'),
				"4_5" => esc_html__("4/5", 'booklovers'),
				"1_6" => esc_html__("1/6", 'booklovers'),
				"5_6" => esc_html__("5/6", 'booklovers'),
				"1_7" => esc_html__("1/7", 'booklovers'),
				"2_7" => esc_html__("2/7", 'booklovers'),
				"3_7" => esc_html__("3/7", 'booklovers'),
				"4_7" => esc_html__("4/7", 'booklovers'),
				"5_7" => esc_html__("5/7", 'booklovers'),
				"6_7" => esc_html__("6/7", 'booklovers'),
				"1_8" => esc_html__("1/8", 'booklovers'),
				"3_8" => esc_html__("3/8", 'booklovers'),
				"5_8" => esc_html__("5/8", 'booklovers'),
				"7_8" => esc_html__("7/8", 'booklovers'),
				"1_9" => esc_html__("1/9", 'booklovers'),
				"2_9" => esc_html__("2/9", 'booklovers'),
				"4_9" => esc_html__("4/9", 'booklovers'),
				"5_9" => esc_html__("5/9", 'booklovers'),
				"7_9" => esc_html__("7/9", 'booklovers'),
				"8_9" => esc_html__("8/9", 'booklovers'),
				"1_10"=> esc_html__("1/10", 'booklovers'),
				"3_10"=> esc_html__("3/10", 'booklovers'),
				"7_10"=> esc_html__("7/10", 'booklovers'),
				"9_10"=> esc_html__("9/10", 'booklovers'),
				"1_11"=> esc_html__("1/11", 'booklovers'),
				"2_11"=> esc_html__("2/11", 'booklovers'),
				"3_11"=> esc_html__("3/11", 'booklovers'),
				"4_11"=> esc_html__("4/11", 'booklovers'),
				"5_11"=> esc_html__("5/11", 'booklovers'),
				"6_11"=> esc_html__("6/11", 'booklovers'),
				"7_11"=> esc_html__("7/11", 'booklovers'),
				"8_11"=> esc_html__("8/11", 'booklovers'),
				"9_11"=> esc_html__("9/11", 'booklovers'),
				"10_11"=> esc_html__("10/11", 'booklovers'),
				"1_12"=> esc_html__("1/12", 'booklovers'),
				"5_12"=> esc_html__("5/12", 'booklovers'),
				"7_12"=> esc_html__("7/12", 'booklovers'),
				"10_12"=> esc_html__("10/12", 'booklovers'),
				"11_12"=> esc_html__("11/12", 'booklovers')
			);
			$list = apply_filters('booklovers_filter_list_columns', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_columns', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'booklovers_get_list_dedicated_locations' ) ) {
	function booklovers_get_list_dedicated_locations($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_dedicated_locations'))=='') {
			$list = array(
				"default" => esc_html__('As in the post defined', 'booklovers'),
				"center"  => esc_html__('Above the text of the post', 'booklovers'),
				"left"    => esc_html__('To the left the text of the post', 'booklovers'),
				"right"   => esc_html__('To the right the text of the post', 'booklovers'),
				"alter"   => esc_html__('Alternates for each post', 'booklovers')
			);
			$list = apply_filters('booklovers_filter_list_dedicated_locations', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_dedicated_locations', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'booklovers_get_post_format_name' ) ) {
	function booklovers_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'booklovers') : esc_html__('galleries', 'booklovers');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'booklovers') : esc_html__('videos', 'booklovers');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'booklovers') : esc_html__('audios', 'booklovers');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'booklovers') : esc_html__('images', 'booklovers');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'booklovers') : esc_html__('quotes', 'booklovers');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'booklovers') : esc_html__('links', 'booklovers');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'booklovers') : esc_html__('statuses', 'booklovers');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'booklovers') : esc_html__('asides', 'booklovers');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'booklovers') : esc_html__('chats', 'booklovers');
		else						$name = $single ? esc_html__('standard', 'booklovers') : esc_html__('standards', 'booklovers');
		return apply_filters('booklovers_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'booklovers_get_post_format_icon' ) ) {
	function booklovers_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('booklovers_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'booklovers_get_list_fonts_styles' ) ) {
	function booklovers_get_list_fonts_styles($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_fonts_styles'))=='') {
			$list = array(
				'i' => esc_html__('I','booklovers'),
				'u' => esc_html__('U', 'booklovers')
			);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_fonts_styles', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'booklovers_get_list_fonts' ) ) {
	function booklovers_get_list_fonts($prepend_inherit=false) {
		if (($list = booklovers_storage_get('list_fonts'))=='') {
			$list = array();
			$list = booklovers_array_merge($list, booklovers_get_list_font_faces());
			$list = booklovers_array_merge($list, array(
				'Advent Pro' => array('family'=>'sans-serif'),
				'Alegreya Sans' => array('family'=>'sans-serif'),
				'Arimo' => array('family'=>'sans-serif'),
				'Asap' => array('family'=>'sans-serif'),
				'Averia Sans Libre' => array('family'=>'cursive'),
				'Averia Serif Libre' => array('family'=>'cursive'),
				'Bree Serif' => array('family'=>'serif',),
				'Cabin' => array('family'=>'sans-serif'),
				'Cabin Condensed' => array('family'=>'sans-serif'),
				'Caudex' => array('family'=>'serif'),
				'Comfortaa' => array('family'=>'cursive'),
				'Cousine' => array('family'=>'sans-serif'),
				'Crimson Text' => array('family'=>'serif'),
				'Cuprum' => array('family'=>'sans-serif'),
				'Dosis' => array('family'=>'sans-serif'),
				'Economica' => array('family'=>'sans-serif'),
				'Exo' => array('family'=>'sans-serif'),
				'Expletus Sans' => array('family'=>'cursive'),
				'Karla' => array('family'=>'sans-serif'),
				'Lato' => array('family'=>'sans-serif'),
				'Lekton' => array('family'=>'sans-serif'),
				'Lobster Two' => array('family'=>'cursive'),
				'Maven Pro' => array('family'=>'sans-serif'),
				'Merriweather' => array('family'=>'serif'),
				'Montserrat' => array('family'=>'sans-serif'),
				'Neuton' => array('family'=>'serif'),
				'Noticia Text' => array('family'=>'serif'),
				'Old Standard TT' => array('family'=>'serif'),
				'Open Sans' => array('family'=>'sans-serif'),
				'Orbitron' => array('family'=>'sans-serif'),
				'Oswald' => array('family'=>'sans-serif'),
				'Overlock' => array('family'=>'cursive'),
				'Oxygen' => array('family'=>'sans-serif'),
				'Philosopher' => array('family'=>'serif'),
				'PT Serif' => array('family'=>'serif'),
				'Puritan' => array('family'=>'sans-serif'),
				'Raleway' => array('family'=>'sans-serif'),
				'Roboto' => array('family'=>'sans-serif'),
				'Roboto Slab' => array('family'=>'sans-serif'),
				'Roboto Condensed' => array('family'=>'sans-serif'),
				'Rosario' => array('family'=>'sans-serif'),
				'Share' => array('family'=>'cursive'),
				'Signika' => array('family'=>'sans-serif'),
				'Signika Negative' => array('family'=>'sans-serif'),
				'Source Sans Pro' => array('family'=>'sans-serif'),
				'Tinos' => array('family'=>'serif'),
				'Ubuntu' => array('family'=>'sans-serif'),
				'Vollkorn' => array('family'=>'serif')
				)
			);
			$list = apply_filters('booklovers_filter_list_fonts', $list);
			if (booklovers_get_theme_setting('use_list_cache')) booklovers_storage_set('list_fonts', $list);
		}
		return $prepend_inherit ? booklovers_array_merge(array('inherit' => esc_html__("Inherit", 'booklovers')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'booklovers_get_list_font_faces' ) ) {
	function booklovers_get_list_font_faces($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$list = array();
		$dir = booklovers_get_folder_dir("css/font-face");
		if ( is_dir($dir) ) {
			$hdir = @ opendir( $dir );
			if ( $hdir ) {
				while (($file = readdir( $hdir ) ) !== false ) {
					$pi = pathinfo( ($dir) . '/' . ($file) );
					if ( substr($file, 0, 1) == '.' || ! is_dir( ($dir) . '/' . ($file) ) )
						continue;
					$css = file_exists( ($dir) . '/' . ($file) . '/' . ($file) . '.css' ) 
						? booklovers_get_folder_url("css/font-face/".($file).'/'.($file).'.css')
						: (file_exists( ($dir) . '/' . ($file) . '/stylesheet.css' ) 
							? booklovers_get_folder_url("css/font-face/".($file).'/stylesheet.css')
							: '');
					if ($css != '')
						$list[$file.' ('.esc_html__('uploaded font', 'booklovers').')'] = array('css' => $css);
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}
?>