<?php
// Get template args
extract(booklovers_template_get_args('post-featured'));

if (!empty($post_data['post_video'])) {
	booklovers_show_layout(booklovers_get_video_frame($post_data['post_video'], $post_data['post_video_image'] ? $post_data['post_video_image'] : $post_data['post_thumb']));
} else if (!empty($post_data['post_audio'])) {
	if (booklovers_get_custom_option('substitute_audio')=='no' || !booklovers_in_shortcode_blogger(true))
		booklovers_show_layout(booklovers_get_audio_frame($post_data['post_audio'], $post_data['post_audio_image'] ? $post_data['post_audio_image'] : $post_data['post_thumb_url']));
	else
		booklovers_show_layout($post_data['post_audio']);
} else if (!empty($post_data['post_thumb']) && ($post_data['post_format']!='gallery' || !$post_data['post_gallery'] || booklovers_get_custom_option('gallery_instead_image')=='no')) {
	?>
	<div class="post_thumb" data-image="<?php echo esc_url($post_data['post_attachment']); ?>" data-title="<?php echo esc_attr($post_data['post_title']); ?>">
	<?php
	if ($post_data['post_format']=='link' && $post_data['post_url']!='')
		echo '<a class="hover_icon hover_icon_link" href="'.esc_url($post_data['post_url']).'"'.($post_data['post_url_target'] ? ' target="'.esc_attr($post_data['post_url_target']).'"' : '').'>'.($post_data['post_thumb']).'</a>';
	else if ($post_data['post_link']!='')
		echo '<a class="hover_icon hover_icon_link" href="'.esc_url($post_data['post_link']).'">'.($post_data['post_thumb']).'</a>';
	else
		booklovers_show_layout($post_data['post_thumb']);
	?>
	</div>
	<?php
} else if (!empty($post_data['post_gallery'])) {
	booklovers_enqueue_slider();
	booklovers_show_layout($post_data['post_gallery']);
}
?>