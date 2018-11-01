<?php
/* Tribe Events (TE) support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('booklovers_tribe_events_theme_setup')) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_tribe_events_theme_setup', 1 );
	function booklovers_tribe_events_theme_setup() {
		if (booklovers_exists_tribe_events()) {

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('booklovers_filter_get_blog_type',					'booklovers_tribe_events_get_blog_type', 9, 2);
			add_filter('booklovers_filter_get_blog_title',				'booklovers_tribe_events_get_blog_title', 9, 2);
			add_filter('booklovers_filter_get_current_taxonomy',			'booklovers_tribe_events_get_current_taxonomy', 9, 2);
			add_filter('booklovers_filter_is_taxonomy',					'booklovers_tribe_events_is_taxonomy', 9, 2);
			add_filter('booklovers_filter_get_stream_page_title',			'booklovers_tribe_events_get_stream_page_title', 9, 2);
			add_filter('booklovers_filter_get_stream_page_link',			'booklovers_tribe_events_get_stream_page_link', 9, 2);
			add_filter('booklovers_filter_get_stream_page_id',			'booklovers_tribe_events_get_stream_page_id', 9, 2);
			add_filter('booklovers_filter_get_period_links',				'booklovers_tribe_events_get_period_links', 9, 3);
			add_filter('booklovers_filter_detect_inheritance_key',		'booklovers_tribe_events_detect_inheritance_key', 9, 1);

			add_action('booklovers_action_add_styles',					'booklovers_tribe_events_frontend_scripts' );

			add_filter('tribe_events_google_maps_api',     'booklovers_tribe_events_google_maps_api');

			add_filter('booklovers_filter_list_post_types', 				'booklovers_tribe_events_list_post_types', 10, 1);
			add_filter('booklovers_filter_post_date',	 					'booklovers_tribe_events_post_date', 9, 3);

			add_filter('booklovers_filter_add_sort_order', 				'booklovers_tribe_events_add_sort_order', 10, 3);
			add_filter('booklovers_filter_orderby_need',					'booklovers_tribe_events_orderby_need', 9, 2);

			// Advanced Calendar filters
			add_filter('booklovers_filter_calendar_get_month_link',		'booklovers_tribe_events_calendar_get_month_link', 9, 2);
			add_filter('booklovers_filter_calendar_get_prev_month',		'booklovers_tribe_events_calendar_get_prev_month', 9, 2);
			add_filter('booklovers_filter_calendar_get_next_month',		'booklovers_tribe_events_calendar_get_next_month', 9, 2);
			add_filter('booklovers_filter_calendar_get_curr_month_posts',	'booklovers_tribe_events_calendar_get_curr_month_posts', 9, 2);

			// Add query params to show events in the blog
			add_filter( 'posts_join',									'booklovers_tribe_events_posts_join', 10, 2 );
			add_filter( 'getarchives_join',								'booklovers_tribe_events_getarchives_join', 10, 2 );
			add_filter( 'posts_where',									'booklovers_tribe_events_posts_where', 10, 2 );
			add_filter( 'getarchives_where',							'booklovers_tribe_events_getarchives_where', 10, 2 );

			// Extra column for events lists
			if (booklovers_get_theme_option('show_overriden_posts')=='yes') {
				add_filter('manage_edit-'.Tribe__Events__Main::POSTTYPE.'_columns',			'booklovers_post_add_options_column', 9);
				add_filter('manage_'.Tribe__Events__Main::POSTTYPE.'_posts_custom_column',	'booklovers_post_fill_options_column', 9, 2);
			}

			// Register shortcode [trx_events] in the list
			add_action('booklovers_action_shortcodes_list',				'booklovers_tribe_events_reg_shortcodes');
			if (function_exists('booklovers_exists_visual_composer') && booklovers_exists_visual_composer())
				add_action('booklovers_action_shortcodes_list_vc',		'booklovers_tribe_events_reg_shortcodes_vc');

			// One-click installer
			if (is_admin()) {
				add_filter( 'booklovers_filter_importer_options',			'booklovers_tribe_events_importer_set_options' );
			}
		}
		if (is_admin()) {
			add_filter( 'booklovers_filter_importer_required_plugins',	'booklovers_tribe_events_importer_required_plugins', 10, 2 );
			add_filter( 'booklovers_filter_required_plugins',				'booklovers_tribe_events_required_plugins' );
		}
	}
}

if ( !function_exists( 'booklovers_tribe_events_settings_theme_setup2' ) ) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_tribe_events_settings_theme_setup2', 3 );
	function booklovers_tribe_events_settings_theme_setup2() {
		if (booklovers_exists_tribe_events()) {
			booklovers_add_theme_inheritance( array('tribe_events' => array(
				'stream_template' => 'tribe-events/default-template',
				'single_template' => '',
				'taxonomy' => array(Tribe__Events__Main::TAXONOMY),
				'taxonomy_tags' => array(),
				'post_type' => array(
					Tribe__Events__Main::POSTTYPE,
					Tribe__Events__Main::VENUE_POST_TYPE,
					Tribe__Events__Main::ORGANIZER_POST_TYPE
				),
				'override' => 'post'
				) )
			);
	
			// Add Tribe Events specific options in the Theme Options
	
			booklovers_storage_set_array_before('options', 'partition_reviews', array(
			
				"partition_tribe_events" => array(
						"title" => __('Events', 'booklovers'),
						"icon" => "iconadmin-clock",
						"type" => "partition"),
			
				"info_tribe_events_1" => array(
						"title" => __('Events settings', 'booklovers'),
						"desc" => __('Set up events posts behaviour in the blog.', 'booklovers'),
						"type" => "info"),
			
				"show_tribe_events_in_blog" => array(
						"title" => __('Show events in the blog',  'booklovers'),
						"desc" => __("Show events in stream pages (blog, archives) or only in special pages", 'booklovers'),
						"divider" => false,
						"std" => "yes",
						"options" => booklovers_get_options_param('list_yes_no'),
						"type" => "switch")
				)
			);	
		}
	}
}

// Check if Tribe Events installed and activated
if (!function_exists('booklovers_exists_tribe_events')) {
	function booklovers_exists_tribe_events() {
		return class_exists( 'Tribe__Events__Main' );
	}
}


// Return true, if current page is any TE page
if ( !function_exists( 'booklovers_is_tribe_events_page' ) ) {
	function booklovers_is_tribe_events_page() {
		$is = false;
		if (booklovers_exists_tribe_events()) {
			$is = in_array(booklovers_storage_get('page_template'), array('tribe-events/default-template'));
			if (!$is) {
				if (booklovers_storage_empty('pre_query')) {
					if (!is_search()) $is = tribe_is_event() || tribe_is_event_query() || tribe_is_event_category() || tribe_is_event_venue() || tribe_is_event_organizer();
				} else {
					$is = booklovers_storage_get_obj_property('pre_query', 'tribe_is_event')
							|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_multi_posttype')
							|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_event_category')
							|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_event_venue')
							|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_event_organizer')
							|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_event_query')
							|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_past');
				}
			}
		}
		return $is;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'booklovers_tribe_events_detect_inheritance_key' ) ) {
	//Handler of add_filter('booklovers_filter_detect_inheritance_key',	'booklovers_tribe_events_detect_inheritance_key', 9, 1);
	function booklovers_tribe_events_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return booklovers_is_tribe_events_page() ? 'tribe_events' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'booklovers_tribe_events_get_blog_type' ) ) {
	//Handler of add_filter('booklovers_filter_get_blog_type',	'booklovers_tribe_events_get_blog_type', 10, 2);
	function booklovers_tribe_events_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if (!is_search() && booklovers_is_tribe_events_page()) {
			//$tribe_ecp = Tribe__Events__Main::instance();
			if (/*tribe_is_day()*/ isset($query->query_vars['eventDisplay']) && $query->query_vars['eventDisplay']=='day') 			$page = 'tribe_day';
			else if (/*tribe_is_month()*/ isset($query->query_vars['eventDisplay']) && $query->query_vars['eventDisplay']=='month')	$page = 'tribe_month';
			else if (is_single())																									$page = 'tribe_event';
			else if (/*tribe_is_event_venue()*/		isset($query->tribe_is_event_venue) && $query->tribe_is_event_venue)			$page = 'tribe_venue';
			else if (/*tribe_is_event_organizer()*/	isset($query->tribe_is_event_organizer) && $query->tribe_is_event_organizer)	$page = 'tribe_organizer';
			else if (/* tribe_is_event_category()*/	isset($query->tribe_is_event_category) && $query->tribe_is_event_category)		$page = 'tribe_category';
			else if (/*is_tax($tribe_ecp->get_event_taxonomy())*/ is_tag())															$page = 'tribe_tag';
			else if (isset($query->query_vars['eventDisplay']) && $query->query_vars['eventDisplay']=='upcoming')					$page = 'tribe_list';
			else																													$page = 'tribe';
		}
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'booklovers_tribe_events_get_blog_title' ) ) {
	//Handler of add_filter('booklovers_filter_get_blog_title',	'booklovers_tribe_events_get_blog_title', 10, 2);
	function booklovers_tribe_events_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( booklovers_strpos($page, 'tribe')!==false ) {
			//return tribe_get_events_title();
			if ( $page == 'tribe_category' ) {
				$cat = get_term_by( 'slug', get_query_var( 'tribe_events_cat' ), 'tribe_events_cat', ARRAY_A);
				$title = $cat['name'];
			} else if ( $page == 'tribe_tag' ) {
				$title = sprintf( esc_html__( 'Tag: %s', 'booklovers' ), single_tag_title( '', false ) );
			} else if ( $page == 'tribe_venue' ) {
				$title = sprintf( esc_html__( 'Venue: %s', 'booklovers' ), tribe_get_venue());
			} else if ( $page == 'tribe_organizer' ) {
				$title = sprintf( esc_html__( 'Organizer: %s', 'booklovers' ), tribe_get_organizer());
			} else if ( $page == 'tribe_day' ) {
				$title = sprintf( esc_html__( 'Daily Events: %s', 'booklovers' ), date_i18n(tribe_get_date_format(true), strtotime(get_query_var( 'start_date' ))) );
			} else if ( $page == 'tribe_month' ) {
				$title = sprintf( esc_html__( 'Monthly Events: %s', 'booklovers' ), date_i18n(tribe_get_option('monthAndYearFormat', 'F Y' ), strtotime(tribe_get_month_view_date())));
			} else if ( $page == 'tribe_event' ) {
				$title = booklovers_get_post_title();
			} else {
				$title = esc_html__( 'All Events', 'booklovers' );
			}
		}
		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'booklovers_tribe_events_get_stream_page_title' ) ) {
	//Handler of add_filter('booklovers_filter_get_stream_page_title',	'booklovers_tribe_events_get_stream_page_title', 9, 2);
	function booklovers_tribe_events_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (booklovers_strpos($page, 'tribe')!==false) {
			if (($page_id = booklovers_tribe_events_get_stream_page_id(0, $page)) > 0)
				$title = booklovers_get_post_title($page_id);
			else
				$title = esc_html__( 'All Events', 'booklovers');
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'booklovers_tribe_events_get_stream_page_id' ) ) {
	//Handler of add_filter('booklovers_filter_get_stream_page_id',	'booklovers_tribe_events_get_stream_page_id', 9, 2);
	function booklovers_tribe_events_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (booklovers_strpos($page, 'tribe')!==false) $id = booklovers_get_template_page_id('tribe-events/default-template');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'booklovers_tribe_events_get_stream_page_link' ) ) {
	//Handler of add_filter('booklovers_filter_get_stream_page_link',	'booklovers_tribe_events_get_stream_page_link', 9, 2);
	function booklovers_tribe_events_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (booklovers_strpos($page, 'tribe')!==false) $url = tribe_get_events_link();
		return $url;
	}
}

// Filter to return breadcrumbs links to the parent period
if ( !function_exists( 'booklovers_tribe_events_get_period_links' ) ) {
	//Handler of add_filter('booklovers_filter_get_period_links',	'booklovers_tribe_events_get_period_links', 9, 3);
	function booklovers_tribe_events_get_period_links($links, $page, $delimiter='') {
		if (!empty($links)) return $links;
		global $post;
		if ($page == 'tribe_day' && is_object($post))
			$links = '<a class="breadcrumbs_item cat_parent" href="' . tribe_get_gridview_link(false) . '">' . date_i18n(tribe_get_option('monthAndYearFormat', 'F Y' ), strtotime(tribe_get_month_view_date())) . '</a>';
		return $links;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'booklovers_tribe_events_get_current_taxonomy' ) ) {
	//Handler of add_filter('booklovers_filter_get_current_taxonomy',	'booklovers_tribe_events_get_current_taxonomy', 9, 2);
	function booklovers_tribe_events_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( booklovers_strpos($page, 'tribe')!==false ) {
			$tax = Tribe__Events__Main::TAXONOMY;
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'booklovers_tribe_events_is_taxonomy' ) ) {
	//Handler of add_filter('booklovers_filter_is_taxonomy',	'booklovers_tribe_events_is_taxonomy', 10, 2);
	function booklovers_tribe_events_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else
			return $query && isset($query->tribe_is_event_category) && $query->tribe_is_event_category || is_tax(Tribe__Events__Main::TAXONOMY) ? Tribe__Events__Main::TAXONOMY : '';
	}
}

// Add custom post type into list
if ( !function_exists( 'booklovers_tribe_events_list_post_types' ) ) {
	//Handler of add_filter('booklovers_filter_list_post_types', 	'booklovers_tribe_events_list_post_types', 10, 1);
	function booklovers_tribe_events_list_post_types($list) {
		if (booklovers_get_theme_option('show_tribe_events_in_blog')=='yes') {
			$list['tribe_events'] = esc_html__('Events', 'booklovers');
	    }
		return $list;
	}
}



// Return previous month and year with published posts
if ( !function_exists( 'booklovers_tribe_events_calendar_get_month_link' ) ) {
	//Handler of add_filter('booklovers_filter_calendar_get_month_link',	'booklovers_tribe_events_calendar_get_month_link', 9, 2);
	function booklovers_tribe_events_calendar_get_month_link($link, $opt) {
		if (!empty($opt['posts_types']) && in_array(Tribe__Events__Main::POSTTYPE, $opt['posts_types']) && count($opt['posts_types'])==1) {
			$events = Tribe__Events__Main::instance();
			$link = $events->getLink('month', ($opt['year']).'-'.($opt['month']), null);			
		}
		return $link;
	}
}

// Return previous month and year with published posts
if ( !function_exists( 'booklovers_tribe_events_calendar_get_prev_month' ) ) {
	//Handler of add_filter('booklovers_filter_calendar_get_prev_month',	'booklovers_tribe_events_calendar_get_prev_month', 9, 2);
	function booklovers_tribe_events_calendar_get_prev_month($prev, $opt) {
		if (!empty($opt['posts_types']) && !in_array(Tribe__Events__Main::POSTTYPE, $opt['posts_types'])) return $prev;
		if (!empty($prev['done']) && in_array(Tribe__Events__Main::POSTTYPE, $prev['done'])) return $prev;
		$args = array(
			'suppress_filters' => true,
			'post_type' => Tribe__Events__Main::POSTTYPE,
			'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
			'posts_per_page' => 1,
			'ignore_sticky_posts' => true,
			'orderby' => 'meta_value',
			'meta_key' => '_EventStartDate',
			'order' => 'desc',
			'meta_query' => array(
				array(
					'key' => '_EventStartDate',
					'value' => ($opt['year']).'-'.($opt['month']).'-01',
					'compare' => '<',
					'type' => 'DATE'
				)
			)
		);
		$q = new WP_Query($args);
		$month = $year = 0;
		if ($q->have_posts()) {
			while ($q->have_posts()) { $q->the_post();
				$dt = strtotime(get_post_meta(get_the_ID(), '_EventStartDate', true));
				$year  = date('Y', $dt);
				$month = date('m', $dt);
			}
			wp_reset_postdata();
		}
		if (empty($prev) || ($year+$month > 0 && ($prev['year']+$prev['month']==0 || ($prev['year']).($prev['month']) < ($year).($month)))) {
			$prev['year'] = $year;
			$prev['month'] = $month;
		}
		if (empty($prev['done'])) $prev['done'] = array();
		$prev['done'][] = Tribe__Events__Main::POSTTYPE;
		return $prev;
	}
}

// Return next month and year with published posts
if ( !function_exists( 'booklovers_tribe_events_calendar_get_next_month' ) ) {
	//Handler of add_filter('booklovers_filter_calendar_get_next_month',	'booklovers_tribe_events_calendar_get_next_month', 9, 2);
	function booklovers_tribe_events_calendar_get_next_month($next, $opt) {
		if (!empty($opt['posts_types']) && !in_array(Tribe__Events__Main::POSTTYPE, $opt['posts_types'])) return $next;
		if (!empty($next['done']) && in_array(Tribe__Events__Main::POSTTYPE, $next['done'])) return $next;
		$args = array(
			'suppress_filters' => true,
			'post_type' => Tribe__Events__Main::POSTTYPE,
			'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
			'posts_per_page' => 1,
			'orderby' => 'meta_value',
			'ignore_sticky_posts' => true,
			'meta_key' => '_EventStartDate',
			'order' => 'asc',
			'meta_query' => array(
				array(
					'key' => '_EventStartDate',
					'value' => ($opt['year']).'-'.($opt['month']).'-'.($opt['last_day']).' 23:59:59',
					'compare' => '>',
					'type' => 'DATE'
				)
			)
		);
		$q = new WP_Query($args);
		$month = $year = 0;
		if ($q->have_posts()) {
			while ($q->have_posts()) { $q->the_post();
				$dt = strtotime(get_post_meta(get_the_ID(), '_EventStartDate', true));
				$year  = date('Y', $dt);
				$month = date('m', $dt);
			}
			wp_reset_postdata();
		}
		if (empty($next) || ($year+$month > 0 && ($next['year']+$next['month'] ==0 || ($next['year']).($next['month']) > ($year).($month)))) {
			$next['year'] = $year;
			$next['month'] = $month;
		}
		if (empty($next['done'])) $next['done'] = array();
		$next['done'][] = Tribe__Events__Main::POSTTYPE;
		return $next;
	}
}

// Return current month published posts
if ( !function_exists( 'booklovers_tribe_events_calendar_get_curr_month_posts' ) ) {
	//Handler of add_filter('booklovers_filter_calendar_get_curr_month_posts',	'booklovers_tribe_events_calendar_get_curr_month_posts', 9, 2);
	function booklovers_tribe_events_calendar_get_curr_month_posts($posts, $opt) {
		if (!empty($opt['posts_types']) && !in_array(Tribe__Events__Main::POSTTYPE, $opt['posts_types'])) return $posts;
		if (!empty($posts['done']) && in_array(Tribe__Events__Main::POSTTYPE, $posts['done'])) return $posts;
		$args = array(
			'suppress_filters' => true,
			'post_type' => Tribe__Events__Main::POSTTYPE,
			'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
			'posts_per_page' => -1,
			'ignore_sticky_posts' => true,
			'orderby' => 'meta_value',
			'meta_key' => '_EventStartDate',
			'order' => 'asc',
			'meta_query' => array(
				array(
					'key' => '_EventStartDate',
					'value' => array(($opt['year']).'-'.($opt['month']).'-01', ($opt['year']).'-'.($opt['month']).'-'.($opt['last_day']).' 23:59:59'),
					'compare' => 'BETWEEN',
					'type' => 'DATE'
				)
			)
		);
		$q = new WP_Query($args);
		if ($q->have_posts()) {
			if (empty($posts)) $posts = array();
			$events = Tribe__Events__Main::instance();
			while ($q->have_posts()) { $q->the_post();
				$dt = strtotime(get_post_meta(get_the_ID(), '_EventStartDate', true));
				$day = (int) date('d', $dt);
				$title = get_the_title();	//apply_filters('the_title', get_the_title());
				if (empty($posts[$day])) 
					$posts[$day] = array();
				if (empty($posts[$day]['link']) && count($opt['posts_types'])==1)
					$posts[$day]['link'] = $events->getLink('day', ($opt['year']).'-'.($opt['month']).'-'.($day), null);
				if (empty($posts[$day]['titles']))
					$posts[$day]['titles'] = $title;
				else
					$posts[$day]['titles'] = is_int($posts[$day]['titles']) ? $posts[$day]['titles']+1 : 2;
				if (empty($posts[$day]['posts'])) $posts[$day]['posts'] = array();
				$posts[$day]['posts'][] = array(
					'post_id' => get_the_ID(),
					'post_type' => get_post_type(),
					'post_date' => date(get_option('date_format'), $dt),
					'post_title' => $title,
					'post_link' => get_permalink()
				);
			}
			wp_reset_postdata();
		}
		if (empty($posts['done'])) $posts['done'] = array();
		$posts['done'][] = Tribe__Events__Main::POSTTYPE;
		return $posts;
	}
}



// Enqueue Tribe Events custom styles
if ( !function_exists( 'booklovers_tribe_events_frontend_scripts' ) ) {
	//Handler of add_action( 'booklovers_action_add_styles', 'booklovers_tribe_events_frontend_scripts' );
	function booklovers_tribe_events_frontend_scripts() {
		//global $wp_styles;
		//$wp_styles->done[] = 'tribe-events-custom-jquery-styles';
		wp_deregister_style('tribe-events-custom-jquery-styles');
		if (file_exists(booklovers_get_file_dir('css/plugin.tribe-events.css')))
			wp_enqueue_style( 'booklovers-plugin.tribe-events-style',  booklovers_get_file_url('css/plugin.tribe-events.css'), array(), null );
	}
}




// Before main content
if ( !function_exists( 'booklovers_tribe_events_wrapper_start' ) ) {
	//Handler of add_filter('tribe_events_before_html', 'booklovers_tribe_events_wrapper_start');
	function booklovers_tribe_events_wrapper_start($html) {
		return '
		<section class="post tribe_events_wrapper">
			<article class="post_content">
		' . ($html);
	}
}

// After main content
if ( !function_exists( 'booklovers_tribe_events_wrapper_end' ) ) {
	//Handler of add_filter('tribe_events_after_html', 'booklovers_tribe_events_wrapper_end');
	function booklovers_tribe_events_wrapper_end($html) {
		return $html . '
			</article><!-- .post_content -->
		</section>
		';
	}
}

// Add sorting parameter in query arguments
if (!function_exists('booklovers_tribe_events_add_sort_order')) {
	function booklovers_tribe_events_add_sort_order($q, $orderby, $order) {
		if ($orderby == 'event_date') {
			$q['orderby'] = 'meta_value';
			$q['meta_key'] = '_EventStartDate';
		}
		return $q;
	}
}

// Return false if current plugin not need theme orderby setting
if ( !function_exists( 'booklovers_tribe_events_orderby_need' ) ) {
	//Handler of add_filter('booklovers_filter_orderby_need',	'booklovers_tribe_events_orderby_need', 9, 1);
	function booklovers_tribe_events_orderby_need($need) {
		if ($need == false || booklovers_storage_empty('pre_query'))
			return $need;
		else {
			return ! ( booklovers_storage_get_obj_property('pre_query', 'tribe_is_event')
					|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_multi_posttype')
					|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_event_category')
					|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_event_venue')
					|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_event_organizer')
					|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_event_query')
					|| booklovers_storage_get_obj_property('pre_query', 'tribe_is_past')
					);
		}
	}
}


/* Query params to show Events in blog stream
-------------------------------------------------------------------------- */

// Pre query: Join tables into main query
if ( !function_exists( 'booklovers_tribe_events_posts_join' ) ) {
	//Handler of add_action( 'posts_join', 'booklovers_tribe_events_posts_join', 10, 2 );
	function booklovers_tribe_events_posts_join($join_sql, $query) {
		if (booklovers_get_theme_option('show_tribe_events_in_blog')=='yes' && !is_admin() && $query->is_main_query()) {
			if ($query->is_day || $query->is_month || $query->is_year || $query->is_archive || $query->is_posts_page) {
				global $wpdb;
				$join_sql .= " LEFT JOIN " . esc_sql($wpdb->postmeta) . " AS _tribe_events_meta ON " . esc_sql($wpdb->posts) . ".ID = _tribe_events_meta.post_id AND  _tribe_events_meta.meta_key = '_EventStartDate'";
			}
		}
		return $join_sql;
	}
}

// Pre query: Join tables into archives widget query
if ( !function_exists( 'booklovers_tribe_events_getarchives_join' ) ) {
	//Handler of add_action( 'getarchives_join', 'booklovers_tribe_events_getarchives_join', 10, 2 );
	function booklovers_tribe_events_getarchives_join($join_sql, $r) {
		if (booklovers_get_theme_option('show_tribe_events_in_blog')=='yes') {
			global $wpdb;
			$join_sql .= " LEFT JOIN " . esc_sql($wpdb->postmeta) . " AS _tribe_events_meta ON " . esc_sql($wpdb->posts) . ".ID = _tribe_events_meta.post_id AND  _tribe_events_meta.meta_key = '_EventStartDate'";
		}
		return $join_sql;
	}
}

// Pre query: Where section into main query
if ( !function_exists( 'booklovers_tribe_events_posts_where' ) ) {
	//Handler of add_action( 'posts_where', 'booklovers_tribe_events_posts_where', 10, 2 );
	function booklovers_tribe_events_posts_where($where_sql, $query) {
		if (booklovers_get_theme_option('show_tribe_events_in_blog')=='yes' && !is_admin() && $query->is_main_query()) {
			if ($query->is_day || $query->is_month || $query->is_year || $query->is_archive || $query->is_posts_page) {
				global $wpdb;
				$where_sql .= " OR (1=1";
				// Posts status
				if ((!isset($_REQUEST['preview']) || $_REQUEST['preview']!='true') && (!isset($_REQUEST['vc_editable']) || $_REQUEST['vc_editable']!='true')) {
					if (current_user_can('read_private_pages') && current_user_can('read_private_posts'))
						$where_sql .= " AND (" . esc_sql($wpdb->posts) . ".post_status='publish' OR " . esc_sql($wpdb->posts) . ".post_status='private')";
					else
						$where_sql .= " AND " . esc_sql($wpdb->posts) . ".post_status='publish'";
				}
				// Posts type and date
				$dt = $query->get('m');
				$y = $query->get('year');
				if (empty($y)) $y = (int) booklovers_substr($dt, 0, 4);
				$where_sql .= " AND " . esc_sql($wpdb->posts) . ".post_type='".esc_sql(Tribe__Events__Main::POSTTYPE)."' AND YEAR(_tribe_events_meta.meta_value)=".esc_sql($y);
				if ($query->is_month || $query->is_day) {
					$m = $query->get('monthnum');
					if (empty($m)) $m = (int) booklovers_substr($dt, 4, 2);
					$where_sql .= " AND MONTH(_tribe_events_meta.meta_value)=".esc_sql($m);
				}
				if ($query->is_day) {
					$d = $query->get('day');
					if (empty($d)) $d = (int) booklovers_substr($dt, 6, 2);
					$where_sql .= " AND DAYOFMONTH(_tribe_events_meta.meta_value)=".esc_sql($d);
				}
				$where_sql .= ')';
			}
		}
		return $where_sql;
	}
}

// Pre query: Where section into archives widget query
if ( !function_exists( 'booklovers_tribe_events_getarchives_where' ) ) {
	//Handler of add_action( 'getarchives_where', 'booklovers_tribe_events_getarchives_where', 10, 2 );
	function booklovers_tribe_events_getarchives_where($where_sql, $r) {
		if (booklovers_get_theme_option('show_tribe_events_in_blog')=='yes') {
			global $wpdb;
			// Posts type and date
			$where_sql .= " OR " . esc_sql($wpdb->posts) . ".post_type='".esc_sql(Tribe__Events__Main::POSTTYPE)."'";
		}
		return $where_sql;
	}
}

// Return tribe_events start date instead post publish date
if ( !function_exists( 'booklovers_tribe_events_post_date' ) ) {
	//Handler of add_filter('booklovers_filter_post_date', 'booklovers_tribe_events_post_date', 9, 3);
	function booklovers_tribe_events_post_date($post_date, $post_id, $post_type) {
		if ($post_type == Tribe__Events__Main::POSTTYPE) {
			$post_date = get_post_meta($post_id, '_EventStartDate', true);
		}
		return $post_date;
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'booklovers_tribe_events_required_plugins' ) ) {
	//Handler of add_filter('booklovers_filter_required_plugins',	'booklovers_tribe_events_required_plugins');
	function booklovers_tribe_events_required_plugins($list=array()) {
		if (in_array('tribe_events', booklovers_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> 'Tribe Events Calendar',
					'slug' 		=> 'the-events-calendar',
					'required' 	=> false
				);

		return $list;
	}
}


 // Add Google API key to the map's link
if ( !function_exists( 'booklovers_tribe_events_google_maps_api' ) ) {
   //Handler of add_filter('tribe_events_google_maps_api', 'booklovers_tribe_events_google_maps_api');
	function booklovers_tribe_events_google_maps_api($url) {
		$api_key = booklovers_get_theme_option('api_google');
		if ($api_key) {
			$url = booklovers_add_to_url($url, array(
				'key' => $api_key
				));
		}
		return $url;
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check in the required plugins
if ( !function_exists( 'booklovers_tribe_events_importer_required_plugins' ) ) {
	//Handler of add_filter( 'booklovers_filter_importer_required_plugins',	'booklovers_tribe_events_importer_required_plugins', 10, 2 );
	function booklovers_tribe_events_importer_required_plugins($not_installed='', $list='') {
		if (booklovers_strpos($list, 'tribe_events')!==false && !booklovers_exists_tribe_events() )
			$not_installed .= '<br>' . esc_html__('Tribe Events Calendar', 'booklovers');
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'booklovers_tribe_events_importer_set_options' ) ) {
	//Handler of add_filter( 'booklovers_filter_importer_options',	'booklovers_tribe_events_importer_set_options' );
	function booklovers_tribe_events_importer_set_options($options=array()) {
		if ( in_array('tribe_events', booklovers_storage_get('required_plugins')) && booklovers_exists_tribe_events() ) {
			// Add slugs to export options for this plugin
			$options['additional_options'][] = 'tribe_events_calendar_options';
		}
		return $options;
	}
}





// Shortcodes
//------------------------------------------------------------------------

/*
[trx_events id="unique_id" columns="4" count="4" style="events-1|events-2|..." title="Block title" subtitle="xxx" description="xxxxxx"]
*/
if ( !function_exists( 'booklovers_sc_events' ) ) {
	function booklovers_sc_events($atts, $content=null){	
		if (booklovers_in_shortcode_blogger()) return '';
		extract(booklovers_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "events-1",
			"columns" => 4,
			"slider" => "no",
			"slides_space" => 0,
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"align" => "",
			"ids" => "",
			"cat" => "",
			"count" => 4,
			"offset" => "",
			"orderby" => "event_date",
			"order" => "asc",
			"readmore" => esc_html__('Read more', 'booklovers'),
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
	
		if (empty($id)) $id = "sc_events_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && booklovers_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);
		
		$class .= ($class ? ' ' : '') . booklovers_get_css_position_as_classes($top, $right, $bottom, $left);

		$ws = booklovers_get_css_dimensions_from_values($width);
		$hs = booklovers_get_css_dimensions_from_values('', $height);
		$css .= ($hs) . ($ws);

		$count = max(1, (int) $count);
		$columns = max(1, min(12, (int) $columns));
		if ($count < $columns) $columns = $count;

		if (booklovers_param_is_on($slider)) booklovers_enqueue_slider('swiper');

		$output = '<div' . ($id ? ' id="'.esc_attr($id).'_wrap"' : '') 
						. ' class="sc_events_wrap'
						. ($scheme && !booklovers_param_is_off($scheme) && !booklovers_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						.'">'
					. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_events'
							. ' sc_events_style_'.esc_attr($style)
							. ' ' . esc_attr(booklovers_get_template_property($style, 'container_classes'))
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. ($align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
							. '"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. (!booklovers_param_is_off($animation) ? ' data-animation="'.esc_attr(booklovers_get_animation_classes($animation)).'"' : '')
					. '>'
					. (!empty($subtitle) ? '<h6 class="sc_events_subtitle sc_item_subtitle">' . trim(booklovers_strmacros($subtitle)) . '</h6>' : '')
					. (!empty($title) ? '<h2 class="sc_events_title sc_item_title">' . trim(booklovers_strmacros($title)) . '</h2>' : '')
					. (!empty($description) ? '<div class="sc_events_descr sc_item_descr">' . trim(booklovers_strmacros($description)) . '</div>' : '')
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
								. '>'
							. '<div class="slides swiper-wrapper">')
						: ($columns > 1 
							? '<div class="sc_columns columns_wrap">' 
							: '')
						);
	
		$content = do_shortcode($content);
	
		global $post;
	
		if (!empty($ids)) {
			$posts = explode(',', $ids);
			$count = count($posts);
		}
		
		$args = array(
			'post_type' => Tribe__Events__Main::POSTTYPE,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'ignore_sticky_posts' => true,
			'order' => $order=='asc' ? 'asc' : 'desc',
			'readmore' => $readmore
		);
	
		if ($offset > 0 && empty($ids)) {
			$args['offset'] = $offset;
		}
	
		$args = booklovers_query_add_sort_order($args, $orderby, $order);
		$args = booklovers_query_add_posts_and_cats($args, $ids, Tribe__Events__Main::POSTTYPE, $cat, Tribe__Events__Main::TAXONOMY);
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
				'readmore' => $readmore,
				'columns_count' => $columns,
				'slider' => $slider,
				'tag_id' => $id ? $id . '_' . $post_number : '',
				'tag_class' => '',
				'tag_animation' => '',
				'tag_css' => '',
				'tag_css_wh' => $ws . $hs
			);
			$output .= booklovers_show_post_layout($args);
		}
		wp_reset_postdata();
	
		if (booklovers_param_is_on($slider)) {
			$output .= '</div>'
				. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
				. '<div class="sc_slider_pagination_wrap"></div>'
				. '</div>';
		} else if ($columns > 1) {
			$output .= '</div>';
		}

		$output .=  (!empty($link) ? '<div class="sc_events_button sc_item_button">'.booklovers_do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
					. '</div><!-- /.sc_events -->'
				. '</div><!-- /.sc_envents_wrap -->';
	
		// Add template specific scripts and styles
		do_action('booklovers_action_blog_scripts', $style);
	
		return apply_filters('booklovers_shortcode_output', $output, 'trx_events', $atts, $content);
	}
	booklovers_require_shortcode('trx_events', 'booklovers_sc_events');
}
// ---------------------------------- [/trx_events] ---------------------------------------



// Add [trx_events] in the shortcodes list
if (!function_exists('booklovers_tribe_events_reg_shortcodes')) {
	//Handler of add_filter('booklovers_action_shortcodes_list',	'booklovers_tribe_events_reg_shortcodes');
	function booklovers_tribe_events_reg_shortcodes() {
		if (booklovers_storage_isset('shortcodes')) {

			$groups		= booklovers_get_list_terms(false, Tribe__Events__Main::TAXONOMY);
			$styles		= booklovers_get_list_templates('events');
			$sorting	= array(
				"event_date"=> esc_html__("Start Date", 'booklovers'),
				"title" 	=> esc_html__("Alphabetically", 'booklovers'),
				"random"	=> esc_html__("Random", 'booklovers')
				);
			$controls	= booklovers_get_list_slider_controls();

			booklovers_sc_map_before('trx_form', "trx_events", array(
					"title" => esc_html__("Events", 'booklovers'),
					"desc" => esc_html__("Insert events list in your page (post)", 'booklovers'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", 'booklovers'),
							"desc" => esc_html__("Title for the block", 'booklovers'),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", 'booklovers'),
							"desc" => esc_html__("Subtitle for the block", 'booklovers'),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", 'booklovers'),
							"desc" => esc_html__("Short description for the block", 'booklovers'),
							"value" => "",
							"type" => "textarea"
						),
						"style" => array(
							"title" => esc_html__("Style", 'booklovers'),
							"desc" => esc_html__("Select style to display events list", 'booklovers'),
							"value" => "events-1",
							"type" => "select",
							"options" => $styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", 'booklovers'),
							"desc" => esc_html__("How many columns use to show events list", 'booklovers'),
							"value" => 4,
							"min" => 2,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", 'booklovers'),
							"desc" => esc_html__("Select color scheme for this block", 'booklovers'),
							"value" => "",
							"type" => "checklist",
							"options" => booklovers_get_sc_param('schemes')
						),
						"slider" => array(
							"title" => esc_html__("Slider", 'booklovers'),
							"desc" => esc_html__("Use slider to show events", 'booklovers'),
							"dependency" => array(
								'style' => array('events-1')
							),
							"value" => "no",
							"type" => "switch",
							"options" => booklovers_get_sc_param('yes_no')
						),
						"controls" => array(
							"title" => esc_html__("Controls", 'booklovers'),
							"desc" => esc_html__("Slider controls style and position", 'booklovers'),
							"dependency" => array(
								'slider' => array('yes')
							),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $controls
						),
						"slides_space" => array(
							"title" => esc_html__("Space between slides", 'booklovers'),
							"desc" => esc_html__("Size of space (in px) between slides", 'booklovers'),
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
							"desc" => esc_html__("Slides change interval (in milliseconds: 1000ms = 1s)", 'booklovers'),
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
							"desc" => esc_html__("Change whole slider's height (make it equal current slide's height)", 'booklovers'),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => booklovers_get_sc_param('yes_no')
						),
						"align" => array(
							"title" => esc_html__("Alignment", 'booklovers'),
							"desc" => esc_html__("Alignment of the events block", 'booklovers'),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => booklovers_get_sc_param('align')
						),
						"cat" => array(
							"title" => esc_html__("Categories", 'booklovers'),
							"desc" => esc_html__("Select categories (groups) to show events list. If empty - select events from any category (group) or from IDs list", 'booklovers'),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => booklovers_array_merge(array(0 => esc_html__('- Select category -', 'booklovers')), $groups)
						),
						"count" => array(
							"title" => esc_html__("Number of posts", 'booklovers'),
							"desc" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", 'booklovers'),
							"value" => 4,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Offset before select posts", 'booklovers'),
							"desc" => esc_html__("Skip posts before select next part.", 'booklovers'),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Post order by", 'booklovers'),
							"desc" => esc_html__("Select desired posts sorting method", 'booklovers'),
							"value" => "title",
							"type" => "select",
							"options" => $sorting
						),
						"order" => array(
							"title" => esc_html__("Post order", 'booklovers'),
							"desc" => esc_html__("Select desired posts order", 'booklovers'),
							"value" => "asc",
							"type" => "switch",
							"size" => "big",
							"options" => booklovers_get_sc_param('ordering')
						),
						"ids" => array(
							"title" => esc_html__("Post IDs list", 'booklovers'),
							"desc" => esc_html__("Comma separated list of posts ID. If set - parameters above are ignored!", 'booklovers'),
							"value" => "",
							"type" => "text"
						),
						"readmore" => array(
							"title" => esc_html__("Read more", 'booklovers'),
							"desc" => esc_html__("Caption for the Read more link (if empty - link not showed)", 'booklovers'),
							"value" => "",
							"type" => "text"
						),
						"link" => array(
							"title" => esc_html__("Button URL", 'booklovers'),
							"desc" => esc_html__("Link URL for the button at the bottom of the block", 'booklovers'),
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", 'booklovers'),
							"desc" => esc_html__("Caption for the button at the bottom of the block", 'booklovers'),
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
					)
				)
			);
		}
	}
}


// Add [trx_events] in the VC shortcodes list
if (!function_exists('booklovers_tribe_events_reg_shortcodes_vc')) {
	//Handler of add_filter('booklovers_action_shortcodes_list_vc',	'booklovers_tribe_events_reg_shortcodes_vc');
	function booklovers_tribe_events_reg_shortcodes_vc() {

		$groups		= booklovers_get_list_terms(false, Tribe__Events__Main::TAXONOMY);
		$styles		= booklovers_get_list_templates('events');
		$sorting	= array(
			"event_date"=> esc_html__("Start Date", 'booklovers'),
			"title" 	=> esc_html__("Alphabetically", 'booklovers'),
			"random"	=> esc_html__("Random", 'booklovers')
			);
		$controls	= booklovers_get_list_slider_controls();

		// Events
		vc_map( array(
				"base" => "trx_events",
				"name" => esc_html__("Events", 'booklovers'),
				"description" => esc_html__("Insert events list", 'booklovers'),
				"category" => esc_html__('Content', 'booklovers'),
				"icon" => 'icon_trx_events',
				"class" => "trx_sc_single trx_sc_events",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", 'booklovers'),
						"description" => esc_html__("Select style to display events list", 'booklovers'),
						"class" => "",
						"admin_label" => true,
						"std" => "events-1",
						"value" => array_flip($styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", 'booklovers'),
						"description" => esc_html__("Select color scheme for this block", 'booklovers'),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(booklovers_get_sc_param('schemes')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", 'booklovers'),
						"description" => esc_html__("Use slider to show events", 'booklovers'),
						"admin_label" => true,
						'dependency' => array(
							'element' => 'style',
							'value' => 'events-1'
						),
						"group" => esc_html__('Slider', 'booklovers'),
						"class" => "",
						"std" => "no",
						"value" => array_flip(booklovers_get_sc_param('yes_no')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", 'booklovers'),
						"description" => esc_html__("Slider controls style and position", 'booklovers'),
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
						"description" => esc_html__("Size of space (in px) between slides", 'booklovers'),
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
						"description" => esc_html__("Slides change interval (in milliseconds: 1000ms = 1s)", 'booklovers'),
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
						"description" => esc_html__("Change whole slider's height (make it equal current slide's height)", 'booklovers'),
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
						"param_name" => "align",
						"heading" => esc_html__("Alignment", 'booklovers'),
						"description" => esc_html__("Alignment of the events block", 'booklovers'),
						"class" => "",
						"value" => array_flip(booklovers_get_sc_param('align')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", 'booklovers'),
						"description" => esc_html__("Title for the block", 'booklovers'),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", 'booklovers'),
						"description" => esc_html__("Subtitle for the block", 'booklovers'),
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", 'booklovers'),
						"description" => esc_html__("Description for the block", 'booklovers'),
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Categories", 'booklovers'),
						"description" => esc_html__("Select category to show events. If empty - select events from any category (group) or from IDs list", 'booklovers'),
						"group" => esc_html__('Query', 'booklovers'),
						"class" => "",
						"value" => array_flip(booklovers_array_merge(array(0 => esc_html__('- Select category -', 'booklovers')), $groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'booklovers'),
						"description" => esc_html__("How many columns use to show events list", 'booklovers'),
						"group" => esc_html__('Query', 'booklovers'),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Number of posts", 'booklovers'),
						"description" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", 'booklovers'),
						"admin_label" => true,
						"group" => esc_html__('Query', 'booklovers'),
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", 'booklovers'),
						"description" => esc_html__("Skip posts before select next part.", 'booklovers'),
						"group" => esc_html__('Query', 'booklovers'),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post sorting", 'booklovers'),
						"description" => esc_html__("Select desired posts sorting method", 'booklovers'),
						"group" => esc_html__('Query', 'booklovers'),
						"class" => "",
						"value" => array_flip($sorting),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", 'booklovers'),
						"description" => esc_html__("Select desired posts order", 'booklovers'),
						"group" => esc_html__('Query', 'booklovers'),
						"class" => "",
						"value" => array_flip(booklovers_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("Event's IDs list", 'booklovers'),
						"description" => esc_html__("Comma separated list of event's ID. If set - parameters above (category, count, order, etc.)  are ignored!", 'booklovers'),
						"group" => esc_html__('Query', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "readmore",
						"heading" => esc_html__("Read more", 'booklovers'),
						"description" => esc_html__("Caption for the Read more link (if empty - link not showed)", 'booklovers'),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Button URL", 'booklovers'),
						"description" => esc_html__("Link URL for the button at the bottom of the block", 'booklovers'),
						"group" => esc_html__('Captions', 'booklovers'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_caption",
						"heading" => esc_html__("Button caption", 'booklovers'),
						"description" => esc_html__("Caption for the button at the bottom of the block", 'booklovers'),
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
				)
			) );
			
		class WPBakeryShortCode_Trx_Events extends BOOKLOVERS_VC_ShortCodeSingle {}

	}
}
?>