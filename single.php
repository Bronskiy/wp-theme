<?php
/**
 * Single post
 */
get_header(); 

$single_style = booklovers_storage_get('single_style');
if (empty($single_style)) $single_style = booklovers_get_custom_option('single_style');

while ( have_posts() ) { the_post();
	booklovers_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !booklovers_param_is_off(booklovers_get_custom_option('show_sidebar_main')),
			'content' => booklovers_get_template_property($single_style, 'need_content'),
			'terms_list' => booklovers_get_template_property($single_style, 'need_terms')
		)
	);
}

get_footer();
?>