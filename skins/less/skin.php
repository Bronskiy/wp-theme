<?php
/**
 * Skin file for the theme.
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('booklovers_action_skin_theme_setup')) {
	add_action( 'booklovers_action_init_theme', 'booklovers_action_skin_theme_setup', 1 );
	function booklovers_action_skin_theme_setup() {

		// Add skin fonts in the used fonts list
		add_filter('booklovers_filter_used_fonts',			'booklovers_filter_skin_used_fonts');
		// Add skin fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('booklovers_filter_list_fonts',			'booklovers_filter_skin_list_fonts');

		// Add skin stylesheets
		add_action('booklovers_action_add_styles',			'booklovers_action_skin_add_styles');
		// Add skin inline styles
		add_filter('booklovers_filter_add_styles_inline',		'booklovers_filter_skin_add_styles_inline');
		// Add skin responsive styles
		add_action('booklovers_action_add_responsive',		'booklovers_action_skin_add_responsive');
		// Add skin responsive inline styles
		add_filter('booklovers_filter_add_responsive_inline',	'booklovers_filter_skin_add_responsive_inline');

		// Add skin scripts
		add_action('booklovers_action_add_scripts',			'booklovers_action_skin_add_scripts');
		// Add skin scripts inline
		add_filter('booklovers_action_add_scripts_inline',	'booklovers_action_skin_add_scripts_inline');

		// Add skin less files into list for compilation
		add_filter('booklovers_filter_compile_less',			'booklovers_filter_skin_compile_less');


		// Add color schemes
		booklovers_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'booklovers'),

			// Accent colors
			'accent1'				=> '#de3241',
			'accent1_hover'			=> '#b52733',
//			'accent2'				=> '#ff0000',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#797979',
			'text_light'			=> '#fefefe',
			'text_dark'				=> '#121212',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#e4e7e8',
			'bg_color'				=> '#ffffff',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#d8dce5',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#de3241',
			'alter_hover'			=> '#b52733',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#eeeeee',
			'alter_bg_color2'		=> '#f5f5f4',
			'alter_bg_color3'		=> '#e3e3e3',
			'alter_bg_hover'		=> '#f0f0f0',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		// Add color schemes
		booklovers_add_color_scheme('blue', array(

			'title'					=> esc_html__('Blue', 'booklovers'),

			// Accent colors
			'accent1'				=> '#3ac8d4',
			'accent1_hover'			=> '#0c98a5',
//			'accent2'				=> '#ff0000',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#797979',
			'text_light'			=> '#fefefe',
			'text_dark'				=> '#121212',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#e4e7e8',
			'bg_color'				=> '#ffffff',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#d8dce5',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#3ac8d4',
			'alter_hover'			=> '#0c98a5',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#eeeeee',
			'alter_bg_color2'		=> '#f5f5f4',
			'alter_bg_color3'		=> '#e3e3e3',
			'alter_bg_hover'		=> '#f0f0f0',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		// Add color schemes
		booklovers_add_color_scheme('yellow', array(

			'title'					=> esc_html__('Yellow', 'booklovers'),

			// Accent colors
			'accent1'				=> '#febb52',
			'accent1_hover'			=> '#da8500',
//			'accent2'				=> '#ff0000',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#797979',
			'text_light'			=> '#fefefe',
			'text_dark'				=> '#121212',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#e4e7e8',
			'bg_color'				=> '#ffffff',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#d8dce5',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#febb52',
			'alter_hover'			=> '#da8500',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#eeeeee',
			'alter_bg_color2'		=> '#f5f5f4',
			'alter_bg_color3'		=> '#e3e3e3',
			'alter_bg_hover'		=> '#f0f0f0',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		// Add color schemes
		booklovers_add_color_scheme('green', array(

			'title'					=> esc_html__('Green', 'booklovers'),

			// Accent colors
			'accent1'				=> '#89ca18',
			'accent1_hover'			=> '#6ca508',
//			'accent2'				=> '#ff0000',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#797979',
			'text_light'			=> '#fefefe',
			'text_dark'				=> '#121212',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#e4e7e8',
			'bg_color'				=> '#ffffff',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#d8dce5',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#89ca18',
			'alter_hover'			=> '#6ca508',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#eeeeee',
			'alter_bg_color2'		=> '#f5f5f4',
			'alter_bg_color3'		=> '#e3e3e3',
			'alter_bg_hover'		=> '#f0f0f0',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
		booklovers_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'booklovers'),
			'description'	=> '',
			'font-family'	=> 'Playfair Display',
			'font-size' 	=> '4.064em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.5em',
			'margin-bottom'	=> '0.24em'
			)
		);
		booklovers_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'booklovers'),
			'description'	=> '',
			'font-family'	=> 'Playfair Display',
			'font-size' 	=> '3.235em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.45em'
			)
		);
		booklovers_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'booklovers'),
			'description'	=> '',
			'font-family'	=> 'Playfair Display',
			'font-size' 	=> '2.941em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.5em'
			)
		);
		booklovers_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'booklovers'),
			'description'	=> '',
			'font-family'	=> 'Playfair Display',
			'font-size' 	=> '2.647em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '0.76em'
			)
		);
		booklovers_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'booklovers'),
			'description'	=> '',
			'font-family'	=> 'PT Sans',
			'font-size' 	=> '1em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '2.35em'
			)
		);
		booklovers_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'booklovers'),
			'description'	=> '',
			'font-family'	=> 'PT Sans',
			'font-size' 	=> '1em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '1.25em',
			'margin-bottom'	=> '2.35em'
			)
		);
		booklovers_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'booklovers'),
			'description'	=> '',
			'font-family'	=> 'PT Sans',
			'font-size' 	=> '17px',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.45em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1.5em'
			)
		);
		booklovers_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'booklovers'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		booklovers_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'booklovers'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.8571em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '',
			'margin-bottom'	=> '1.5em'
			)
		);
		booklovers_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'booklovers'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '1.25em',
			'margin-bottom'	=> '1.25em'
			)
		);
		booklovers_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'booklovers'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		booklovers_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'booklovers'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		booklovers_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'booklovers'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> ''
			)
		);
		booklovers_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'booklovers'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> ''
			)
		);

	}
}





//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
if (!function_exists('booklovers_filter_skin_used_fonts')) {
	//Handler of add_filter('booklovers_filter_used_fonts', 'booklovers_filter_skin_used_fonts');
	function booklovers_filter_skin_used_fonts($theme_fonts) {
		$theme_fonts['Playfair Display'] = 1;
		$theme_fonts['PT Sans'] = 1;
		$theme_fonts['Lato'] = 1;
		//$theme_fonts['Love Ya Like A Sister'] = 1;
		return $theme_fonts;
	}
}

// Add skin fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('booklovers_filter_skin_list_fonts')) {
	//Handler of add_filter('booklovers_filter_list_fonts', 'booklovers_filter_skin_list_fonts');
	function booklovers_filter_skin_list_fonts($list) {
		// Example:
		// if (!isset($list['Advent Pro'])) {
		//		$list['Advent Pro'] = array(
		//			'family' => 'sans-serif',																						// (required) font family
		//			'link'   => 'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
		//			'css'    => booklovers_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
		//			);
		// }
		if (!isset($list['Playfair Display']))	$list['Playfair Display'] = array('family'=>'serif', 'link'=>'Playfair+Display:400,400italic,700,700italic');
		if (!isset($list['PT Sans']))	$list['PT Sans'] = array('family'=>'sans-serif', 'link'=>'PT+Sans:700,400');
		if (!isset($list['Lato']))	$list['Lato'] = array('family'=>'sans-serif', 'link'=>'Lato:400');
		return $list;
	}
}



//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------
// Add skin stylesheets
if (!function_exists('booklovers_action_skin_add_styles')) {
	//Handler of add_action('booklovers_action_add_styles', 'booklovers_action_skin_add_styles');
	function booklovers_action_skin_add_styles() {
		// Add stylesheet files
		wp_enqueue_style( 'booklovers-skin-style', booklovers_get_file_url('skin.css'), array(), null );
		if (file_exists(booklovers_get_file_dir('skin.customizer.css')))
			wp_enqueue_style( 'booklovers-skin-customizer-style', booklovers_get_file_url('skin.customizer.css'), array(), null );
	}
}

// Add skin inline styles
if (!function_exists('booklovers_filter_skin_add_styles_inline')) {
	//Handler of add_filter('booklovers_filter_add_styles_inline', 'booklovers_filter_skin_add_styles_inline');
	function booklovers_filter_skin_add_styles_inline($custom_style) {
		// Todo: add skin specific styles in the $custom_style to override
		//       rules from style.css and shortcodes.css
		// Example:
		//		$scheme = booklovers_get_custom_option('body_scheme');
		//		if (empty($scheme)) $scheme = 'original';
		//		$clr = booklovers_get_scheme_color('accent1');
		//		if (!empty($clr)) {
		// 			$custom_style .= '
		//				a,
		//				.bg_tint_light a,
		//				.top_panel .content .search_wrap.search_style_regular .search_form_wrap .search_submit,
		//				.top_panel .content .search_wrap.search_style_regular .search_icon,
		//				.search_results .post_more,
		//				.search_results .search_results_close {
		//					color:'.esc_attr($clr).';
		//				}
		//			';
		//		}
		return $custom_style;	
	}
}

// Add skin responsive styles
if (!function_exists('booklovers_action_skin_add_responsive')) {
	//Handler of add_action('booklovers_action_add_responsive', 'booklovers_action_skin_add_responsive');
	function booklovers_action_skin_add_responsive() {
		$suffix = booklovers_param_is_off(booklovers_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
		if (file_exists(booklovers_get_file_dir('skin.responsive'.($suffix).'.css'))) 
			wp_enqueue_style( 'theme-skin-responsive-style', booklovers_get_file_url('skin.responsive'.($suffix).'.css'), array(), null );
	}
}

// Add skin responsive inline styles
if (!function_exists('booklovers_filter_skin_add_responsive_inline')) {
	//Handler of add_filter('booklovers_filter_add_responsive_inline', 'booklovers_filter_skin_add_responsive_inline');
	function booklovers_filter_skin_add_responsive_inline($custom_style) {
		return $custom_style;	
	}
}

// Add skin.less into list files for compilation
if (!function_exists('booklovers_filter_skin_compile_less')) {
	//Handler of add_filter('booklovers_filter_compile_less', 'booklovers_filter_skin_compile_less');
	function booklovers_filter_skin_compile_less($files) {
		if (file_exists(booklovers_get_file_dir('skin.less'))) {
		 	$files[] = booklovers_get_file_dir('skin.less');
		}
		return $files;	
	}
}



//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
if (!function_exists('booklovers_action_skin_add_scripts')) {
	//Handler of add_action('booklovers_action_add_scripts', 'booklovers_action_skin_add_scripts');
	function booklovers_action_skin_add_scripts() {
		if (file_exists(booklovers_get_file_dir('skin.js')))
			wp_enqueue_script( 'theme-skin-script', booklovers_get_file_url('skin.js'), array(), null, true );
		if (booklovers_get_theme_option('show_theme_customizer') == 'yes' && file_exists(booklovers_get_file_dir('skin.customizer.js')))
			wp_enqueue_script( 'theme-skin-customizer-script', booklovers_get_file_url('skin.customizer.js'), array(), null );
	}
}

//// Add skin scripts inline
//if (!function_exists('booklovers_action_skin_add_scripts_inline')) {
//	//Handler of add_action('booklovers_action_add_scripts_inline', 'booklovers_action_skin_add_scripts_inline');
//	function booklovers_action_skin_add_scripts_inline() {
//		// Todo: add skin specific scripts
//		// Example:
//		// echo '<script type="text/javascript">'
//		//	. 'jQuery(document).ready(function() {'
//		//	. "if (BOOKLOVERS_STORAGE['theme_font']=='') BOOKLOVERS_STORAGE['theme_font'] = '" . booklovers_get_custom_font_settings('p', 'font-family') . "';"
//		//	. "BOOKLOVERS_STORAGE['theme_skin_color'] = '" . booklovers_get_scheme_color('accent1') . "';"
//		//	. "});"
//		//	. "< /script>";
//	}
//}

// Add skin scripts inline
if (!function_exists('booklovers_action_skin_add_scripts_inline')) {
    //Handler of add_filter('booklovers_action_add_scripts_inline', 'booklovers_action_skin_add_scripts_inline');
    function booklovers_action_skin_add_scripts_inline($vars=array()) {
        // Todo: add skin specific script's vars
        return $vars;
    }
}

?>