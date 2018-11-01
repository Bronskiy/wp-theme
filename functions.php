<?php
/**
 * Theme sprecific functions and definitions
 */

/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */


// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'booklovers_theme_setup' ) ) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_theme_setup', 1 );
	function booklovers_theme_setup() {

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );

        // Custom header setup
        add_theme_support( 'custom-header', array('header-text'=>false));

        // Custom backgrounds setup
        add_theme_support( 'custom-background');

        // Supported posts formats
        add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') );

        // Autogenerate title tag
        add_theme_support('title-tag');

        // Add user menu
        add_theme_support('nav-menus');

        // WooCommerce Support
        add_theme_support( 'woocommerce' );

        // Add wide and full blocks support
        add_theme_support( 'align-wide' );

		// Register theme menus
		add_filter( 'booklovers_filter_add_theme_menus',		'booklovers_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'booklovers_filter_add_theme_sidebars',	'booklovers_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'booklovers_filter_importer_options',		'booklovers_set_importer_options' );

		// Add theme specified classes into the body
		add_filter( 'body_class', 'booklovers_body_classes' );

		// Set list of the theme required plugins
		booklovers_storage_set('required_plugins', array(
			'booked',
			'essgrids',
			'instagram_widget',
			'revslider',
			'mailchimp',
			'tribe_events',
			'trx_utils',
			'visual_composer',
			'woocommerce',
			'sociallogin',
            'wp_gdpr_compliance',
			)
		);

		// Set list of the theme required custom fonts from folder /css/font-faces
		// Attention! Font's folder must have name equal to the font's name
		booklovers_storage_set('required_custom_fonts', array(
			'Amadeus'
			)
		);
		
		//booklovers_storage_set('demo_data_url',  esc_url(booklovers_get_protocol() . '://booklovers.ancorathemes.com/demo/'));

		booklovers_storage_set('list_skins',  array(
			'less' => 'Less'
			));

		
	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'booklovers_add_theme_menus' ) ) {
	function booklovers_add_theme_menus($menus) {
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'booklovers_add_theme_sidebars' ) ) {
	function booklovers_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'booklovers' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'booklovers' ),
				'single_sidebar'	=> esc_html__( 'Single Widget Sidebar', 'booklovers' )
			);
			if (function_exists('booklovers_exists_woocommerce') && booklovers_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'booklovers' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme specified classes into the body
if ( !function_exists('booklovers_body_classes') ) {
	function booklovers_body_classes( $classes ) {

		$classes[] = 'booklovers_body';
		$classes[] = 'body_style_' . trim(booklovers_get_custom_option('body_style'));
		$classes[] = 'body_' . (booklovers_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent');
		$classes[] = 'theme_skin_' . trim(booklovers_get_custom_option('theme_skin'));
		$classes[] = 'article_style_' . trim(booklovers_get_custom_option('article_style'));
		
		$blog_style = booklovers_get_custom_option(is_singular() && !booklovers_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		$classes[] = 'layout_' . trim($blog_style);
		$classes[] = 'template_' . trim(booklovers_get_template_name($blog_style));
		
		$body_scheme = booklovers_get_custom_option('body_scheme');
		if (empty($body_scheme)  || booklovers_is_inherit_option($body_scheme)) $body_scheme = 'original';
		$classes[] = 'scheme_' . $body_scheme;

		$top_panel_position = booklovers_get_custom_option('top_panel_position');
		if (!booklovers_param_is_off($top_panel_position)) {
			$classes[] = 'top_panel_show';
			$classes[] = 'top_panel_' . trim($top_panel_position);
		} else 
			$classes[] = 'top_panel_hide';
		$classes[] = booklovers_get_sidebar_class();

		if (booklovers_get_custom_option('show_video_bg')=='yes' && (booklovers_get_custom_option('video_bg_youtube_code')!='' || booklovers_get_custom_option('video_bg_url')!=''))
			$classes[] = 'video_bg_show';

		if (booklovers_get_theme_option('page_preloader')!='')
			$classes[] = 'preloader';

		return $classes;
	}
}


//// Set theme specific importer options
//if ( !function_exists( 'booklovers_set_importer_options' ) ) {
//	//Handler of add_filter( 'booklovers_filter_importer_options',	'booklovers_set_importer_options' );
//	function booklovers_set_importer_options($options=array()) {
//		if (is_array($options)) {
//			// Default demo
//			$options['demo_url'] = booklovers_storage_get('demo_data_url');
//			// Default demo
//			$options['files']['default']['title'] = esc_html__('Default Demo', 'booklovers');
//			$options['files']['default']['domain_dev'] = esc_url(booklovers_get_protocol().'://booklovers.dv.ancorathemes.com');		// Developers domain
//			$options['files']['default']['domain_demo']= esc_url(booklovers_get_protocol().'://booklovers.ancorathemes.com');		// Demo-site domain
//		}
//		return $options;
//	}
//}


//------------------------------------------------------------------------ 
// One-click import support 
//------------------------------------------------------------------------ 

// Set theme specific importer options 
if ( ! function_exists( 'booklovers_importer_set_options' ) ) {
    add_filter( 'trx_utils_filter_importer_options', 'booklovers_importer_set_options', 9 );
    function booklovers_importer_set_options( $options=array() ) {
        if ( is_array( $options ) ) {
            // Save or not installer's messages to the log-file 
            $options['debug'] = false;
            // Prepare demo data 
            if ( is_dir( BOOKLOVERS_THEME_PATH . 'demo/' ) ) {
                $options['demo_url'] = BOOKLOVERS_THEME_PATH . 'demo/';
            } else {
                $options['demo_url'] = esc_url( booklovers_get_protocol().'://demofiles.ancorathemes.com/booklovers/' ); // Demo-site domain
            }

            // Required plugins 
            $options['required_plugins'] =  array(
                'booked',
                'essential-grid',
                'instagram-feed',
                'revslider',
                'mailchimp-for-wp',
                'the-events-calendar',
                'trx_utils',
                'js_composer',
                'woocommerce',
                'sociallogin'
            );

            $options['theme_slug'] = 'booklovers';

            // Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images) 
            // Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images) 
            $options['regenerate_thumbnails'] = 3;
            // Default demo 
            $options['files']['default']['title'] = esc_html__( 'Education Demo', 'booklovers' );
            $options['files']['default']['domain_dev'] = esc_url(booklovers_get_protocol().'://booklovers.dv.ancorathemes.com'); // Developers domain
            $options['files']['default']['domain_demo']= esc_url(booklovers_get_protocol().'://booklovers.ancorathemes.com'); // Demo-site domain

        }
        return $options;
    }
}

// Add theme required plugins
if ( !function_exists( 'booklovers_add_trx_utils' ) ) {
    add_filter( 'trx_utils_active', 'booklovers_add_trx_utils' );
    function booklovers_add_trx_utils($enable=true) {
        return true;
    }
}

/* Include framework core files
------------------------------------------------------------------- */
require_once( get_template_directory().'/fw/loader.php' );
?>