<?php
/**
 * The Header for our theme.
 */

// Theme init - don't remove next row! Load custom options
booklovers_core_init_theme();

booklovers_profiler_add_point(esc_html__('Before Theme HTML output', 'booklovers'));

$theme_skin = booklovers_esc(booklovers_get_custom_option('theme_skin'));
$body_scheme = booklovers_get_custom_option('body_scheme');
if (empty($body_scheme)  || booklovers_is_inherit_option($body_scheme)) $body_scheme = 'original';
$body_style  = booklovers_get_custom_option('body_style');
$top_panel_style = booklovers_get_custom_option('top_panel_style');
$top_panel_position = booklovers_get_custom_option('top_panel_position');
$top_panel_scheme = booklovers_get_custom_option('top_panel_scheme');
$video_bg_show  = booklovers_get_custom_option('show_video_bg')=='yes' && (booklovers_get_custom_option('video_bg_youtube_code')!='' || booklovers_get_custom_option('video_bg_url')!='');

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo 'scheme_' . esc_attr($body_scheme); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1<?php if (booklovers_get_theme_option('responsive_layouts')=='yes') echo ', maximum-scale=1'; ?>">
	<meta name="format-detection" content="telephone=no">

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php
	// Page preloader
	if (($preloader=booklovers_get_theme_option('page_preloader'))!='') {
		$clr = booklovers_get_scheme_color('bg_color');
		?>
	   	<style type="text/css">
   		<!--
			#page_preloader { background-color: <?php echo esc_attr($clr); ?>; background-image:url(<?php echo esc_url($preloader); ?>); background-position:center; background-repeat:no-repeat; position:fixed; z-index:1000000; left:0; top:0; right:0; bottom:0; opacity: 0.8; }
	   	-->
   		</style>
   		<?php
   	}

wp_head();
?>
</head>

<body <?php body_class();?>>
	<?php 
	booklovers_profiler_add_point(esc_html__('BODY start', 'booklovers'));
	
	booklovers_show_layout(booklovers_get_custom_option('gtm_code'));

	// Page preloader
	if (empty($preloader)){$preloader = '';}
	if ($preloader!='') {
		?><div id="page_preloader"></div><?php
	}

	do_action( 'before' );

	// Add TOC items 'Home' and "To top"
	if (booklovers_get_custom_option('menu_toc_home')=='yes' && function_exists('booklovers_sc_anchor'))
		booklovers_show_layout(booklovers_sc_anchor(array(
			'id' => "toc_home",
			'title' => esc_html__('Home', 'booklovers'),
			'description' => esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'booklovers'),
			'icon' => "icon-home",
			'separator' => "yes",
			'url' => esc_url(home_url('/'))
			)
	)); 
	if (booklovers_get_custom_option('menu_toc_top')=='yes' && function_exists('booklovers_sc_anchor'))
		booklovers_show_layout(booklovers_sc_anchor(array(
			'id' => "toc_top",
			'title' => esc_html__('To Top', 'booklovers'),
			'description' => esc_html__('{{Back to top}} - ||scroll to top of the page', 'booklovers'),
			'icon' => "icon-double-up",
			'separator' => "yes")
	)); 
	?>

	<?php if ( !booklovers_param_is_off(booklovers_get_custom_option('show_sidebar_outer')) ) { ?>
	<div class="outer_wrap">
		<?php } ?>

		<?php get_template_part(booklovers_get_file_slug('sidebar_outer.php')); ?>

		<?php
		$class = $style = '';
		if (booklovers_get_custom_option('bg_custom')=='yes' && ($body_style=='boxed' || booklovers_get_custom_option('bg_image_load')=='always')) {
			if (($img = booklovers_get_custom_option('bg_image_custom')) != '')
				$style = 'background: url('.esc_url($img).') ' . str_replace('_', ' ', booklovers_get_custom_option('bg_image_custom_position')) . ' no-repeat fixed;';
			else if (($img = booklovers_get_custom_option('bg_pattern_custom')) != '')
				$style = 'background: url('.esc_url($img).') 0 0 repeat fixed;';
			else if (($img = booklovers_get_custom_option('bg_image')) > 0)
				$class = 'bg_image_'.($img);
			else if (($img = booklovers_get_custom_option('bg_pattern')) > 0)
				$class = 'bg_pattern_'.($img);
			if (($img = booklovers_get_custom_option('bg_color')) != '')
				$style .= 'background-color: '.($img).';';
		}
		?>

		<div class="body_wrap<?php echo !empty($class) ? ' '.esc_attr($class) : ''; ?>"<?php echo !empty($style) ? ' style="'.esc_attr($style).'"' : ''; ?>>

			<?php
			if ($video_bg_show) {
				$youtube = booklovers_get_custom_option('video_bg_youtube_code');
				$video   = booklovers_get_custom_option('video_bg_url');
				$overlay = booklovers_get_custom_option('video_bg_overlay')=='yes';
				if (!empty($youtube)) {
					?>
					<div class="video_bg<?php echo !empty($overlay) ? ' video_bg_overlay' : ''; ?>" data-youtube-code="<?php echo esc_attr($youtube); ?>"></div>
					<?php
				} else if (!empty($video)) {
					$info = pathinfo($video);
					$ext = !empty($info['extension']) ? $info['extension'] : 'src';
					?>
					<div class="video_bg<?php echo !empty($overlay) ? ' video_bg_overlay' : ''; ?>"><video class="video_bg_tag" width="1280" height="720" data-width="1280" data-height="720" data-ratio="16:9" preload="metadata" autoplay loop src="<?php echo esc_url($video); ?>"><source src="<?php echo esc_url($video); ?>" type="video/<?php echo esc_attr($ext); ?>"></source></video></div>
					<?php
				}
			}
			?>

			<div class="page_wrap">

				<?php
				booklovers_profiler_add_point(esc_html__('Before Page Header', 'booklovers'));
			// Top panel 'Above' or 'Over'
				if (in_array($top_panel_position, array('above', 'over'))) {
					booklovers_show_post_layout(array(
						'layout' => $top_panel_style,
						'position' => $top_panel_position,
						'scheme' => $top_panel_scheme
						), false);
					booklovers_profiler_add_point(esc_html__('After show menu', 'booklovers'));
				}
			// Mobile Menu
				get_template_part(booklovers_get_file_slug('templates/headers/_parts/header-mobile.php'));
			// Slider
				get_template_part(booklovers_get_file_slug('templates/headers/_parts/slider.php'));
			// Top panel 'Below'
				if ($top_panel_position == 'below') {
					booklovers_show_post_layout(array(
						'layout' => $top_panel_style,
						'position' => $top_panel_position,
						'scheme' => $top_panel_scheme
						), false);
					booklovers_profiler_add_point(esc_html__('After show menu', 'booklovers'));
				}

			// Top of page section: page title and breadcrumbs
				$show_title = booklovers_get_custom_option('show_page_title')=='yes';
				$show_navi = $show_title && is_single() && booklovers_is_woocommerce_page();
				$show_breadcrumbs = booklovers_get_custom_option('show_breadcrumbs')=='yes';
				if ($show_title || $show_breadcrumbs) {
					?>
					<div class="top_panel_title top_panel_style_<?php echo esc_attr(str_replace('header_', '', $top_panel_style)); ?> <?php echo (!empty($show_title) ? ' title_present'.  ($show_navi ? ' navi_present' : '') : '') . (!empty($show_breadcrumbs) ? ' breadcrumbs_present' : ''); ?> scheme_<?php echo esc_attr($top_panel_scheme); ?>">
						<div class="top_panel_title_inner top_panel_inner_style_<?php echo esc_attr(str_replace('header_', '', $top_panel_style)); ?> <?php echo (!empty($show_title) ? ' title_present_inner' : '') . (!empty($show_breadcrumbs) ? ' breadcrumbs_present_inner' : ''); ?>">
							<div class="content_wrap">
								<?php
								if ($show_title) {
									if ($show_navi) {
										?><div class="post_navi"><?php 
										previous_post_link( '<span class="post_navi_item post_navi_prev">%link</span>', '%title', true, '', 'product_cat' );
										next_post_link( '<span class="post_navi_item post_navi_next">%link</span>', '%title', true, '', 'product_cat' );
										?></div><?php
									} else {
										?><h1 class="page_title"><?php echo strip_tags(booklovers_get_blog_title()); ?></h1><?php
									}
								}
								if ($show_breadcrumbs) {
									?><div class="breadcrumbs"><?php if (!is_404()) booklovers_show_breadcrumbs(); ?></div><?php
								}
								?>
							</div>
						</div>
					</div>
					<?php
				}
				?>

				<div class="page_content_wrap page_paddings_<?php echo esc_attr(booklovers_get_custom_option('body_paddings')); ?>">

					<?php
					booklovers_profiler_add_point(esc_html__('Before Page content', 'booklovers'));
				// Content and sidebar wrapper
					if ($body_style!='fullscreen') booklovers_open_wrapper('<div class="content_wrap">');


				//Header for woocommerce custom heading
					if (booklovers_get_custom_option('show_custom_heading') == 'yes') { 
						$woo_shorcode = booklovers_get_custom_option('show_custom_shortcode');
						$woo_image = booklovers_get_custom_option('custom_header_bg');
						?>
						<div class="content_wrap single_page_heading">
							<div class="custom_header_wrap">	
								<div class="single_custom_header" <?php echo (!empty($woo_image) ? 'style="background-image: url('.esc_url($woo_image).');"' : ''); ?> >
									<div class="shorcodes_in_header"><?php echo (!empty($woo_shorcode) ? do_shortcode($woo_shorcode) : 'error');?></div>
								</div>
							</div>	<!-- /.content_wrap -->
						</div>	<!-- /.contacts_wrap_inner -->
						<?php
					}


				// Main content wrapper
					booklovers_open_wrapper('<div class="content">');

					?>