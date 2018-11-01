<?php
/**
 * Attachment page
 */
get_header(); 

while ( have_posts() ) { the_post();

	// Move booklovers_set_post_views to the javascript - counter will work under cache system
	if (booklovers_get_custom_option('use_ajax_views_counter')=='no') {
		booklovers_set_post_views(get_the_ID());
	}

	booklovers_show_post_layout(
		array(
			'layout' => 'attachment',
			'sidebar' => !booklovers_param_is_off(booklovers_get_custom_option('show_sidebar_main'))
		)
	);

}

get_footer();
?>