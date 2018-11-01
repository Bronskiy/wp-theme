<?php
/**
 * Booklovers Framework: Clients support
 *
 * @package	booklovers
 * @since	booklovers 1.0
 */

// Theme init
if (!function_exists('booklovers_clients_theme_setup')) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_clients_theme_setup', 1 );
	function booklovers_clients_theme_setup() {

		// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
		add_filter('booklovers_filter_get_blog_type',			'booklovers_clients_get_blog_type', 9, 2);
		add_filter('booklovers_filter_get_blog_title',		'booklovers_clients_get_blog_title', 9, 2);
		add_filter('booklovers_filter_get_current_taxonomy',	'booklovers_clients_get_current_taxonomy', 9, 2);
		add_filter('booklovers_filter_is_taxonomy',			'booklovers_clients_is_taxonomy', 9, 2);
		add_filter('booklovers_filter_get_stream_page_title',	'booklovers_clients_get_stream_page_title', 9, 2);
		add_filter('booklovers_filter_get_stream_page_link',	'booklovers_clients_get_stream_page_link', 9, 2);
		add_filter('booklovers_filter_get_stream_page_id',	'booklovers_clients_get_stream_page_id', 9, 2);
		add_filter('booklovers_filter_query_add_filters',		'booklovers_clients_query_add_filters', 9, 2);
		add_filter('booklovers_filter_detect_inheritance_key','booklovers_clients_detect_inheritance_key', 9, 1);

		// Extra column for clients lists
		if (booklovers_get_theme_option('show_overriden_posts')=='yes') {
			add_filter('manage_edit-clients_columns',			'booklovers_post_add_options_column', 9);
			add_filter('manage_clients_posts_custom_column',	'booklovers_post_fill_options_column', 9, 2);
		}

		// Registar shortcodes [trx_clients] and [trx_clients_item] in the shortcodes list
		add_action('booklovers_action_shortcodes_list',		'booklovers_clients_reg_shortcodes');
		if (function_exists('booklovers_exists_visual_composer') && booklovers_exists_visual_composer())
			add_action('booklovers_action_shortcodes_list_vc','booklovers_clients_reg_shortcodes_vc');
		
		// Add supported data types
		booklovers_theme_support_pt('clients');
		booklovers_theme_support_tx('clients_group');
	}
}

if ( !function_exists( 'booklovers_clients_settings_theme_setup2' ) ) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_clients_settings_theme_setup2', 3 );
	function booklovers_clients_settings_theme_setup2() {
		// Add post type 'clients' and taxonomy 'clients_group' into theme inheritance list
		booklovers_add_theme_inheritance( array('clients' => array(
			'stream_template' => 'blog-clients',
			'single_template' => 'single-client',
			'taxonomy' => array('clients_group'),
			'taxonomy_tags' => array(),
			'post_type' => array('clients'),
			'override' => 'custom'
			) )
		);
	}
}


if (!function_exists('booklovers_clients_after_theme_setup')) {
	add_action( 'booklovers_action_after_init_theme', 'booklovers_clients_after_theme_setup' );
	function booklovers_clients_after_theme_setup() {
		// Update fields in the override options
		if (booklovers_storage_get_array('post_override_options', 'page')=='clients') {
			// Meta box fields
			booklovers_storage_set_array('post_override_options', 'title', esc_html__('Client Options', 'booklovers'));
			booklovers_storage_set_array('post_override_options', 'fields', array(
				"mb_partition_clients" => array(
					"title" => esc_html__('Clients', 'booklovers'),
					"override" => "page,post,custom",
					"divider" => false,
					"icon" => "iconadmin-users",
					"type" => "partition"),
				"mb_info_clients_1" => array(
					"title" => esc_html__('Client details', 'booklovers'),
					"override" => "page,post,custom",
					"divider" => false,
					"desc" => wp_kses_data( __('In this section you can put details for this client', 'booklovers') ),
					"class" => "client_meta",
					"type" => "info"),
				"client_name" => array(
					"title" => esc_html__('Contact name',  'booklovers'),
					"desc" => wp_kses_data( __("Name of the contacts manager", 'booklovers') ),
					"override" => "page,post,custom",
					"class" => "client_name",
					"std" => '',
					"type" => "text"),
				"client_position" => array(
					"title" => esc_html__('Position',  'booklovers'),
					"desc" => wp_kses_data( __("Position of the contacts manager", 'booklovers') ),
					"override" => "page,post,custom",
					"class" => "client_position",
					"std" => '',
					"type" => "text"),
				"client_show_link" => array(
					"title" => esc_html__('Show link',  'booklovers'),
					"desc" => wp_kses_data( __("Show link to client page", 'booklovers') ),
					"override" => "page,post,custom",
					"class" => "client_show_link",
					"std" => "no",
					"options" => booklovers_get_list_yesno(),
					"type" => "switch"),
				"client_link" => array(
					"title" => esc_html__('Link',  'booklovers'),
					"desc" => wp_kses_data( __("URL of the client's site. If empty - use link to this page", 'booklovers') ),
					"override" => "page,post,custom",
					"class" => "client_link",
					"std" => '',
					"type" => "text")
				)
			);
		}
	}
}


// Return true, if current page is clients page
if ( !function_exists( 'booklovers_is_clients_page' ) ) {
	function booklovers_is_clients_page() {
		$is = in_array(booklovers_storage_get('page_template'), array('blog-clients', 'single-client'));
		if (!$is) {
			if (!booklovers_storage_empty('pre_query'))
				$is = booklovers_storage_call_obj_method('pre_query', 'get', 'post_type')=='clients'
						|| booklovers_storage_call_obj_method('pre_query', 'is_tax', 'clients_group') 
						|| (booklovers_storage_call_obj_method('pre_query', 'is_page') 
							&& ($id=booklovers_get_template_page_id('blog-clients')) > 0 
							&& $id==booklovers_storage_get_obj_property('pre_query', 'queried_object_id', 0)
							);
			else
				$is = get_query_var('post_type')=='clients' 
						|| is_tax('clients_group') 
						|| (is_page() && ($id=booklovers_get_template_page_id('blog-clients')) > 0 && $id==get_the_ID());
		}
		return $is;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'booklovers_clients_detect_inheritance_key' ) ) {
	//Handler of add_filter('booklovers_filter_detect_inheritance_key',	'booklovers_clients_detect_inheritance_key', 9, 1);
	function booklovers_clients_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return booklovers_is_clients_page() ? 'clients' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'booklovers_clients_get_blog_type' ) ) {
	//Handler of add_filter('booklovers_filter_get_blog_type',	'booklovers_clients_get_blog_type', 9, 2);
	function booklovers_clients_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax('clients_group') || is_tax('clients_group'))
			$page = 'clients_category';
		else if ($query && $query->get('post_type')=='clients' || get_query_var('post_type')=='clients')
			$page = $query && $query->is_single() || is_single() ? 'clients_item' : 'clients';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'booklovers_clients_get_blog_title' ) ) {
	//Handler of add_filter('booklovers_filter_get_blog_title',	'booklovers_clients_get_blog_title', 9, 2);
	function booklovers_clients_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( booklovers_strpos($page, 'clients')!==false ) {
			if ( $page == 'clients_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'clients_group' ), 'clients_group', OBJECT);
				$title = $term->name;
			} else if ( $page == 'clients_item' ) {
				$title = booklovers_get_post_title();
			} else {
				$title = esc_html__('All clients', 'booklovers');
			}
		}
		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'booklovers_clients_get_stream_page_title' ) ) {
	//Handler of add_filter('booklovers_filter_get_stream_page_title',	'booklovers_clients_get_stream_page_title', 9, 2);
	function booklovers_clients_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (booklovers_strpos($page, 'clients')!==false) {
			if (($page_id = booklovers_clients_get_stream_page_id(0, $page=='clients' ? 'blog-clients' : $page)) > 0)
				$title = booklovers_get_post_title($page_id);
			else
				$title = esc_html__('All clients', 'booklovers');				
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'booklovers_clients_get_stream_page_id' ) ) {
	//Handler of add_filter('booklovers_filter_get_stream_page_id',	'booklovers_clients_get_stream_page_id', 9, 2);
	function booklovers_clients_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (booklovers_strpos($page, 'clients')!==false) $id = booklovers_get_template_page_id('blog-clients');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'booklovers_clients_get_stream_page_link' ) ) {
	//Handler of add_filter('booklovers_filter_get_stream_page_link',	'booklovers_clients_get_stream_page_link', 9, 2);
	function booklovers_clients_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (booklovers_strpos($page, 'clients')!==false) {
			$id = booklovers_get_template_page_id('blog-clients');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'booklovers_clients_get_current_taxonomy' ) ) {
	//Handler of add_filter('booklovers_filter_get_current_taxonomy',	'booklovers_clients_get_current_taxonomy', 9, 2);
	function booklovers_clients_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( booklovers_strpos($page, 'clients')!==false ) {
			$tax = 'clients_group';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'booklovers_clients_is_taxonomy' ) ) {
	//Handler of add_filter('booklovers_filter_is_taxonomy',	'booklovers_clients_is_taxonomy', 9, 2);
	function booklovers_clients_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('clients_group')!='' || is_tax('clients_group') ? 'clients_group' : '';
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'booklovers_clients_query_add_filters' ) ) {
	//Handler of add_filter('booklovers_filter_query_add_filters',	'booklovers_clients_query_add_filters', 9, 2);
	function booklovers_clients_query_add_filters($args, $filter) {
		if ($filter == 'clients') {
			$args['post_type'] = 'clients';
		}
		return $args;
	}
}





// ---------------------------------- [trx_clients] ---------------------------------------

/*
[trx_clients id="unique_id" columns="3" style="clients-1|clients-2|..."]
	[trx_clients_item name="client name" position="director" image="url"]Description text[/trx_clients_item]
	...
[/trx_clients]
*/
if ( !function_exists( 'booklovers_sc_clients' ) ) {
	function booklovers_sc_clients($atts, $content=null){	
		if (booklovers_in_shortcode_blogger()) return '';
		extract(booklovers_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "clients-1",
			"columns" => 4,
			"slider" => "no",
			"slides_space" => 0,
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"custom" => "no",
			"ids" => "",
			"cat" => "",
			"count" => 4,
			"offset" => "",
			"orderby" => "title",
			"order" => "asc",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('Learn more', 'booklovers'),
			"link" => '',
			"scheme" => '',
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));

		if (empty($id)) $id = "sc_clients_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && booklovers_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);

		$class .= ($class ? ' ' : '') . booklovers_get_css_position_as_classes($top, $right, $bottom, $left);

		$ws = booklovers_get_css_dimensions_from_values($width);
		$hs = booklovers_get_css_dimensions_from_values('', $height);
		$css .= ($hs) . ($ws);

		if (booklovers_param_is_on($slider)) booklovers_enqueue_slider('swiper');
	
		$columns = max(1, min(12, $columns));
		$count = max(1, (int) $count);
		if (booklovers_param_is_off($custom) && $count < $columns) $columns = $count;
		booklovers_storage_set('sc_clients_data', array(
			'id'=>$id,
            'style'=>$style,
            'counter'=>0,
            'columns'=>$columns,
            'slider'=>$slider,
            'css_wh'=>$ws . $hs
            )
        );

		$output = '<div' . ($id ? ' id="'.esc_attr($id).'_wrap"' : '') 
						. ' class="sc_clients_wrap'
						. ($scheme && !booklovers_param_is_off($scheme) && !booklovers_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						.'">'
					. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_clients sc_clients_style_'.esc_attr($style)
							. ' ' . esc_attr(booklovers_get_template_property($style, 'container_classes'))
							. (!empty($class) ? ' '.esc_attr($class) : '')
						.'"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. (!booklovers_param_is_off($animation) ? ' data-animation="'.esc_attr(booklovers_get_animation_classes($animation)).'"' : '')
					. '>'
					. (!empty($subtitle) ? '<h6 class="sc_clients_subtitle sc_item_subtitle">' . trim(booklovers_strmacros($subtitle)) . '</h6>' : '')
					. (!empty($title) ? '<h2 class="sc_clients_title sc_item_title">' . trim(booklovers_strmacros($title)) . '</h2>' : '')
					. (!empty($description) ? '<div class="sc_clients_descr sc_item_descr">' . trim(booklovers_strmacros($description)) . '</div>' : '')
					. (booklovers_param_is_on($slider) 
						? ('<div class="sc_slider_swiper swiper-slider-container'
										. ' ' . esc_attr(booklovers_get_slider_controls_classes($controls))
										. (booklovers_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
										. ($hs ? ' sc_slider_height_fixed' : '')
										. '"'
									. (!empty($width) && booklovers_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
									. (!empty($height) && booklovers_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
									. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
									. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
									. ($slides_space > 0 ? ' data-slides-space="' . esc_attr($slides_space) . '"' : '')
									. ($style!='clients-1' ? ' data-slides-min-width="250"' : '')
								. '>'
							. '<div class="slides swiper-wrapper">')
						: ($columns > 1 
							? '<div class="sc_columns columns_wrap">' 
							: '')
						);
	
		$content = do_shortcode($content);
	
		if (booklovers_param_is_on($custom) && $content) {
			$output .= $content;
		} else {
			global $post;
	
			if (!empty($ids)) {
				$posts = explode(',', $ids);
				$count = count($posts);
			}
			
			$args = array(
				'post_type' => 'clients',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = booklovers_query_add_sort_order($args, $orderby, $order);
			$args = booklovers_query_add_posts_and_cats($args, $ids, 'clients', $cat, 'clients_group');

			$query = new WP_Query( $args );
	
			$post_number = 0;

			while ( $query->have_posts() ) { 
				$query->the_post();
				$post_number++;
				$args = array(
					'layout' => $style,
					'show' => false,
					'number' => $post_number,
					'posts_on_page' => ($count > 0 ? $count : $query->found_posts),
					"descr" => booklovers_get_custom_option('post_excerpt_maxlength'.($columns > 1 ? '_masonry' : '')),
					"orderby" => $orderby,
					'content' => false,
					'terms_list' => false,
					'columns_count' => $columns,
					'slider' => $slider,
					'tag_id' => $id ? $id . '_' . $post_number : '',
					'tag_class' => '',
					'tag_animation' => '',
					'tag_css' => '',
					'tag_css_wh' => $ws . $hs
				);
				$post_data = booklovers_get_post_data($args);
				$post_meta = get_post_meta($post_data['post_id'], 'booklovers_post_options', true);
				$thumb_sizes = booklovers_get_thumb_sizes(array('layout' => $style));
				$args['client_name'] = $post_meta['client_name'];
				$args['client_position'] = $post_meta['client_position'];
				$args['client_image'] = $post_data['post_thumb'];
				$args['client_link'] = booklovers_param_is_on('client_show_link')
					? (!empty($post_meta['client_link']) ? $post_meta['client_link'] : $post_data['post_link'])
					: '';
				$output .= booklovers_show_post_layout($args, $post_data);
			}
			wp_reset_postdata();
		}
	
		if (booklovers_param_is_on($slider)) {
			$output .= '</div>'
				. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
				. '<div class="sc_slider_pagination_wrap"></div>'
				. '</div>';
		} else if ($columns > 1) {
			$output .= '</div>';
		}

		$output .= (!empty($link) ? '<div class="sc_clients_button sc_item_button">'.booklovers_do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
				. '</div><!-- /.sc_clients -->'
			. '</div><!-- /.sc_clients_wrap -->';
	
		// Add template specific scripts and styles
		do_action('booklovers_action_blog_scripts', $style);
	
		return apply_filters('booklovers_shortcode_output', $output, 'trx_clients', $atts, $content);
	}
	booklovers_require_shortcode('trx_clients', 'booklovers_sc_clients');
}


if ( !function_exists( 'booklovers_sc_clients_item' ) ) {
	function booklovers_sc_clients_item($atts, $content=null) {
		if (booklovers_in_shortcode_blogger()) return '';
		extract(booklovers_html_decode(shortcode_atts( array(
			// Individual params
			"name" => "",
			"position" => "",
			"image" => "",
			"link" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => ""
		), $atts)));
	
		booklovers_storage_inc_array('sc_clients_data', 'counter');
	
		$id = $id ? $id : (booklovers_storage_get_array('sc_clients_data', 'id') ? booklovers_storage_get_array('sc_clients_data', 'id') . '_' . booklovers_storage_get_array('sc_clients_data', 'counter') : '');
	
		$descr = trim(chop(do_shortcode($content)));
	
		$thumb_sizes = booklovers_get_thumb_sizes(array('layout' => booklovers_storage_get_array('sc_clients_data', 'style')));

		if ($image > 0) {
			$attach = wp_get_attachment_image_src( $image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		$image = booklovers_get_resized_image_tag($image, $thumb_sizes['w'], $thumb_sizes['h']);

		$post_data = array(
			'post_title' => $name,
			'post_excerpt' => $descr
		);
		$args = array(
			'layout' => booklovers_storage_get_array('sc_clients_data', 'style'),
			'number' => booklovers_storage_get_array('sc_clients_data', 'counter'),
			'columns_count' => booklovers_storage_get_array('sc_clients_data', 'columns'),
			'slider' => booklovers_storage_get_array('sc_clients_data', 'slider'),
			'show' => false,
			'descr'  => 0,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => $animation,
			'tag_css' => $css,
			'tag_css_wh' => booklovers_storage_get_array('sc_clients_data', 'css_wh'),
			'client_position' => $position,
			'client_link' => $link,
			'client_image' => $image
		);
		$output = booklovers_show_post_layout($args, $post_data);
		return apply_filters('booklovers_shortcode_output', $output, 'trx_clients_item', $atts, $content);
	}
	booklovers_require_shortcode('trx_clients_item', 'booklovers_sc_clients_item');
}
// ---------------------------------- [/trx_clients] ---------------------------------------



// Add [trx_clients] and [trx_clients_item] in the shortcodes list
if (!function_exists('booklovers_clients_reg_shortcodes')) {
	//Handler of add_filter('booklovers_action_shortcodes_list',	'booklovers_clients_reg_shortcodes');
	function booklovers_clients_reg_shortcodes() {
		if (booklovers_storage_isset('shortcodes')) {

			$users = booklovers_get_list_users();
			$members = booklovers_get_list_posts(false, array(
				'post_type'=>'clients',
				'orderby'=>'title',
				'order'=>'asc',
				'return'=>'title'
				)
			);
			$clients_groups = booklovers_get_list_terms(false, 'clients_group');
			$clients_styles = booklovers_get_list_templates('clients');
			$controls 		= booklovers_get_list_slider_controls();

			booklovers_sc_map_after('trx_chat', array(

				// Clients
				"trx_clients" => array(
					"title" => esc_html__("Clients", 'booklovers'),
					"desc" => wp_kses_data( __("Insert clients list in your page (post)", 'booklovers') ),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", 'booklovers'),
							"desc" => wp_kses_data( __("Title for the block", 'booklovers') ),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", 'booklovers'),
							"desc" => wp_kses_data( __("Subtitle for the block", 'booklovers') ),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", 'booklovers'),
							"desc" => wp_kses_data( __("Short description for the block", 'booklovers') ),
							"value" => "",
							"type" => "textarea"
						),
						"style" => array(
							"title" => esc_html__("Clients style", 'booklovers'),
							"desc" => wp_kses_data( __("Select style to display clients list", 'booklovers') ),
							"value" => "clients-1",
							"type" => "select",
							"options" => $clients_styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", 'booklovers'),
							"desc" => wp_kses_data( __("How many columns use to show clients", 'booklovers') ),
							"value" => 4,
							"min" => 2,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", 'booklovers'),
							"desc" => wp_kses_data( __("Select color scheme for this block", 'booklovers') ),
							"value" => "",
							"type" => "checklist",
							"options" => booklovers_get_sc_param('schemes')
						),
						"slider" => array(
							"title" => esc_html__("Slider", 'booklovers'),
							"desc" => wp_kses_data( __("Use slider to show clients", 'booklovers') ),
							"value" => "no",
							"type" => "switch",
							"options" => booklovers_get_sc_param('yes_no')
						),
						"controls" => array(
							"title" => esc_html__("Controls", 'booklovers'),
							"desc" => wp_kses_data( __("Slider controls style and position", 'booklovers') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"divider" => true,
							"value" => "no",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $controls
						),
						"slides_space" => array(
							"title" => esc_html__("Space between slides", 'booklovers'),
							"desc" => wp_kses_data( __("Size of space (in px) between slides", 'booklovers') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 0,
							"min" => 0,
							"max" => 100,
							"step" => 10,
							"type" => "spinner"
						),
						"interval" => array(
							"title" => esc_html__("Slides change interval", 'booklovers'),
							"desc" => wp_kses_data( __("Slides change interval (in milliseconds: 1000ms = 1s)", 'booklovers') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"autoheight" => array(
							"title" => esc_html__("Autoheight", 'booklovers'),
							"desc" => wp_kses_data( __("Change whole slider's height (make it equal current slide's height)", 'booklovers') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => booklovers_get_sc_param('yes_no')
						),
						"custom" => array(
							"title" => esc_html__("Custom", 'booklovers'),
							"desc" => wp_kses_data( __("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", 'booklovers') ),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => booklovers_get_sc_param('yes_no')
						),
						"cat" => array(
							"title" => esc_html__("Categories", 'booklovers'),
							"desc" => wp_kses_data( __("Select categories (groups) to show team members. If empty - select team members from any category (group) or from IDs list", 'booklovers') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => booklovers_array_merge(array(0 => esc_html__('- Select category -', 'booklovers')), $clients_groups)
						),
						"count" => array(
							"title" => esc_html__("Number of posts", 'booklovers'),
							"desc" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'booklovers') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 4,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Offset before select posts", 'booklovers'),
							"desc" => wp_kses_data( __("Skip posts before select next part.", 'booklovers') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Post order by", 'booklovers'),
							"desc" => wp_kses_data( __("Select desired posts sorting method", 'booklovers') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "title",
							"type" => "select",
							"options" => booklovers_get_sc_param('sorting')
						),
						"order" => array(
							"title" => esc_html__("Post order", 'booklovers'),
							"desc" => wp_kses_data( __("Select desired posts order", 'booklovers') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "asc",
							"type" => "switch",
							"size" => "big",
							"options" => booklovers_get_sc_param('ordering')
						),
						"ids" => array(
							"title" => esc_html__("Post IDs list", 'booklovers'),
							"desc" => wp_kses_data( __("Comma separated list of posts ID. If set - parameters above are ignored!", 'booklovers') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "",
							"type" => "text"
						),
						"link" => array(
							"title" => esc_html__("Button URL", 'booklovers'),
							"desc" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'booklovers') ),
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", 'booklovers'),
							"desc" => wp_kses_data( __("Caption for the button at the bottom of the block", 'booklovers') ),
							"value" => "",
							"type" => "text"
						),
						"width" => booklovers_shortcodes_width(),
						"height" => booklovers_shortcodes_height(),
						"top" => booklovers_get_sc_param('top'),
						"bottom" => booklovers_get_sc_param('bottom'),
						"left" => booklovers_get_sc_param('left'),
						"right" => booklovers_get_sc_param('right'),
						"id" => booklovers_get_sc_param('id'),
						"class" => booklovers_get_sc_param('class'),
						"animation" => booklovers_get_sc_param('animation'),
						"css" => booklovers_get_sc_param('css')
					),
					"children" => array(
						"name" => "trx_clients_item",
						"title" => esc_html__("Client", 'booklovers'),
						"desc" => wp_kses_data( __("Single client (custom parameters)", 'booklovers') ),
						"container" => true,
						"params" => array(
							"name" => array(
								"title" => esc_html__("Name", 'booklovers'),
								"desc" => wp_kses_data( __("Client's name", 'booklovers') ),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"position" => array(
								"title" => esc_html__("Position", 'booklovers'),
								"desc" => wp_kses_data( __("Client's position", 'booklovers') ),
								"value" => "",
								"type" => "text"
							),
							"link" => array(
								"title" => esc_html__("Link", 'booklovers'),
								"desc" => wp_kses_data( __("Link on client's personal page", 'booklovers') ),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"image" => array(
								"title" => esc_html__("Image", 'booklovers'),
								"desc" => wp_kses_data( __("Client's image", 'booklovers') ),
								"value" => "",
								"readonly" => false,
								"type" => "media"
							),
							"_content_" => array(
								"title" => esc_html__("Description", 'booklovers'),
								"desc" => wp_kses_data( __("Client's short description", 'booklovers') ),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => booklovers_get_sc_param('id'),
							"class" => booklovers_get_sc_param('class'),
							"animation" => booklovers_get_sc_param('animation'),
							"css" => booklovers_get_sc_param('css')
						)
					)
				)

			));
		}
	}
}


// Add [trx_clients] and [trx_clients_item] in the VC shortcodes list
if (!function_exists('booklovers_clients_reg_shortcodes_vc')) {
	//Handler of add_filter('booklovers_action_shortcodes_list_vc',	'booklovers_clients_reg_shortcodes_vc');
	function booklovers_clients_reg_shortcodes_vc() {

		$clients_groups = booklovers_get_list_terms(false, 'clients_group');
		$clients_styles = booklovers_get_list_templates('clients');
		$controls		= booklovers_get_list_slider_controls();

		// Clients
		vc_map( array(
				"base" => "trx_clients",
				"name" => esc_html__("Clients", 'booklovers'),
				"description" => wp_kses_data( __("Insert clients list", 'booklovers') ),
				"category" => esc_html__('Content', 'booklovers'),
				'icon' => 'icon_trx_clients',
				"class" => "trx_sc_columns trx_sc_clients",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_clients_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Clients style", 'booklovers'),
						"description" => wp_kses_data( __("Select style to display clients list", 'booklovers') ),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($clients_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", 'booklovers'),
						"description" => wp_kses_data( __("Select color scheme for this block", 'booklovers') ),
						"class" => "",
						"value" => array_flip(booklovers_get_sc_param('schemes')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", 'booklovers'),
						"description" => wp_kses_data( __("Use slider to show testimonials", 'booklovers') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'booklovers'),
						"class" => "",
						"std" => "no",
						"value" => array_flip(booklovers_get_sc_param('yes_no')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", 'booklovers'),
						"description" => wp_kses_data( __("Slider controls style and position", 'booklovers') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'booklovers'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"std" => "no",
						"value" => array_flip($controls),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_space",
						"heading" => esc_html__("Space between slides", 'booklovers'),
						"description" => wp_kses_data( __("Size of space (in px) between slides", 'booklovers') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'booklovers'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Slides change interval", 'booklovers'),
						"description" => wp_kses_data( __("Slides change interval (in milliseconds: 1000ms = 1s)", 'booklovers') ),
						"group" => esc_html__('Slider', 'booklovers'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "autoheight",
						"heading" => esc_html__("Autoheight", 'booklovers'),
						"description" => wp_kses_data( __("Change whole slider's height (make it equal current slide's height)", 'booklovers') ),
						"group" => esc_html__('Slider', 'booklovers'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => array("Autoheight" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", 'booklovers'),
						"description" => wp_kses_data( __("Allow get clients from inner shortcodes (custom) or get it from specified group (cat)", 'booklovers') ),
						"class" => "",
						"value" => array("Custom clients" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", 'booklovers'),
						"description" => wp_kses_data( __("Title for the block", 'booklovers') ),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", 'booklovers'),
						"description" => wp_kses_data( __("Subtitle for the block", 'booklovers') ),
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", 'booklovers'),
						"description" => wp_kses_data( __("Description for the block", 'booklovers') ),
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Categories", 'booklovers'),
						"description" => wp_kses_data( __("Select category to show clients. If empty - select clients from any category (group) or from IDs list", 'booklovers') ),
						"group" => esc_html__('Query', 'booklovers'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(booklovers_array_merge(array(0 => esc_html__('- Select category -', 'booklovers')), $clients_groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'booklovers'),
						"description" => wp_kses_data( __("How many columns use to show clients", 'booklovers') ),
						"group" => esc_html__('Query', 'booklovers'),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Number of posts", 'booklovers'),
						"description" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'booklovers') ),
						"group" => esc_html__('Query', 'booklovers'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", 'booklovers'),
						"description" => wp_kses_data( __("Skip posts before select next part.", 'booklovers') ),
						"group" => esc_html__('Query', 'booklovers'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post sorting", 'booklovers'),
						"description" => wp_kses_data( __("Select desired posts sorting method", 'booklovers') ),
						"group" => esc_html__('Query', 'booklovers'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"std" => "title",
						"class" => "",
						"value" => array_flip(booklovers_get_sc_param('sorting')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", 'booklovers'),
						"description" => wp_kses_data( __("Select desired posts order", 'booklovers') ),
						"group" => esc_html__('Query', 'booklovers'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"std" => "asc",
						"class" => "",
						"value" => array_flip(booklovers_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("client's IDs list", 'booklovers'),
						"description" => wp_kses_data( __("Comma separated list of client's ID. If set - parameters above (category, count, order, etc.)  are ignored!", 'booklovers') ),
						"group" => esc_html__('Query', 'booklovers'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Button URL", 'booklovers'),
						"description" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'booklovers') ),
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_caption",
						"heading" => esc_html__("Button caption", 'booklovers'),
						"description" => wp_kses_data( __("Caption for the button at the bottom of the block", 'booklovers') ),
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					booklovers_vc_width(),
					booklovers_vc_height(),
					booklovers_get_vc_param('margin_top'),
					booklovers_get_vc_param('margin_bottom'),
					booklovers_get_vc_param('margin_left'),
					booklovers_get_vc_param('margin_right'),
					booklovers_get_vc_param('id'),
					booklovers_get_vc_param('class'),
					booklovers_get_vc_param('animation'),
					booklovers_get_vc_param('css')
				),
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
		vc_map( array(
				"base" => "trx_clients_item",
				"name" => esc_html__("Client", 'booklovers'),
				"description" => wp_kses_data( __("Client - all data pull out from it account on your site", 'booklovers') ),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_column_item trx_sc_clients_item",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_clients_item',
				"as_child" => array('only' => 'trx_clients'),
				"as_parent" => array('except' => 'trx_clients'),
				"params" => array(
					array(
						"param_name" => "name",
						"heading" => esc_html__("Name", 'booklovers'),
						"description" => wp_kses_data( __("Client's name", 'booklovers') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "position",
						"heading" => esc_html__("Position", 'booklovers'),
						"description" => wp_kses_data( __("Client's position", 'booklovers') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", 'booklovers'),
						"description" => wp_kses_data( __("Link on client's personal page", 'booklovers') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Client's image", 'booklovers'),
						"description" => wp_kses_data( __("Clients's image", 'booklovers') ),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					booklovers_get_vc_param('id'),
					booklovers_get_vc_param('class'),
					booklovers_get_vc_param('animation'),
					booklovers_get_vc_param('css')
				),
				'js_view' => 'VcTrxColumnItemView'
			) );
			
		class WPBakeryShortCode_Trx_Clients extends BOOKLOVERS_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Clients_Item extends BOOKLOVERS_VC_ShortCodeCollection {}

	}
}
?>