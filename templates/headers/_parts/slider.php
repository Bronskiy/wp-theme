<?php
if (booklovers_get_custom_option('show_slider')=='yes') { 
	$slider = booklovers_get_custom_option('slider_engine');
	$slider_alias = $slider_ids = $slider_html = '';

	if ($slider == 'revo' && function_exists('booklovers_exists_revslider') && booklovers_exists_revslider()) {
		$slider_alias = booklovers_get_custom_option('slider_alias');
		if (!empty($slider_alias)) $slider_html = booklovers_do_shortcode('[rev_slider '.esc_attr($slider_alias).']');

	} else if ($slider == 'royal' && function_exists('booklovers_exists_royalslider') && booklovers_exists_royalslider()) {
		$slider_alias = get_new_royalslider($slider_alias);
		if (!empty($slider_alias)) $slider_html = booklovers_do_shortcode('[rev_slider '.esc_attr($slider_alias).']');
		wp_enqueue_style(  'new-royalslider-core-css', NEW_ROYALSLIDER_PLUGIN_URL . 'lib/royalslider/royalslider.css', array(), null );
		wp_enqueue_script( 'new-royalslider-main-js', NEW_ROYALSLIDER_PLUGIN_URL . 'lib/royalslider/jquery.royalslider.min.js', array('jquery'), NEW_ROYALSLIDER_WP_VERSION, true );

	} else if ($slider == 'swiper') {
		$slider_pagination = booklovers_get_custom_option("slider_pagination");
		$slider_alias = booklovers_get_custom_option("slider_category");
		$slider_orderby = booklovers_get_custom_option("slider_orderby");
		$slider_order = booklovers_get_custom_option("slider_order");
		$slider_count = $slider_ids = booklovers_get_custom_option("slider_posts");

		if (booklovers_strpos($slider_ids, ',')!==false) {
			$slider_alias = '';
			$slider_count = 0;
		} else {
			$slider_ids = '';
			if (empty($slider_count)) $slider_count = 3;
		}

		$slider_interval = booklovers_get_custom_option("slider_interval");

		if ($slider_count > 0 || !empty($slider_ids)) {
			$args = array(
				'custom'	=> "no",
				'crop'		=> "no",
				'controls'	=> "no",
				'engine'	=> $slider,
				'height'	=> max(100, booklovers_get_custom_option('slider_height')),
				'titles'	=> booklovers_get_custom_option("slider_infobox")
			);
			if ($slider_interval)	$args['interval'] = $slider_interval;
			if ($slider_alias)		$args['cat'] = $slider_alias;
			if ($slider_ids)		$args['ids'] = $slider_ids;
			if ($slider_count)		$args['count'] = $slider_count;
			if ($slider_orderby)	$args['orderby'] = $slider_orderby;
			if ($slider_order)		$args['order'] = $slider_order;
			if ($slider_pagination)	$args['pagination'] = $slider_pagination;
			
			$slider_html = booklovers_sc_slider($args);
		}
	}

	// if slider selected
	if (!empty($slider_html)) {
		?>
		<section class="slider_wrap slider_<?php echo esc_attr(booklovers_get_custom_option('slider_display')); ?> slider_engine_<?php echo esc_attr($slider); ?> slider_alias_<?php echo esc_attr($slider_alias); ?>">
			<?php booklovers_show_layout($slider_html); ?>
		</section>
		<?php 
		booklovers_profiler_add_point(esc_html__('After show slider', 'booklovers'));
	}
}
?>