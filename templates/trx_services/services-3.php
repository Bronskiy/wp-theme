<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'booklovers_template_services_3_theme_setup' ) ) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_template_services_3_theme_setup', 1 );
	function booklovers_template_services_3_theme_setup() {
		booklovers_add_template(array(
			'layout' => 'services-3',
			'template' => 'services-3',
			'mode'   => 'services',
			'need_columns' => true,
			'title'  => esc_html__('Services /Style 3/', 'booklovers'),
			'thumb_title'  => esc_html__('Medium square image (crop)', 'booklovers'),
			'w'		 => 370,
			'h'		 => 370
		));
	}
}

// Template output
if ( !function_exists( 'booklovers_template_services_3_output' ) ) {
	function booklovers_template_services_3_output($post_options, $post_data) {
		$show_title = !empty($post_data['post_title']);
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($parts[1]) ? (!empty($post_options['columns_count']) ? $post_options['columns_count'] : 1) : (int) $parts[1]));
		if (booklovers_param_is_on($post_options['slider'])) {
			?><div class="swiper-slide" data-style="<?php echo esc_attr($post_options['tag_css_wh']); ?>" style="<?php echo esc_attr($post_options['tag_css_wh']); ?>"><div class="sc_services_item_wrap"><?php
		} else if ($columns > 1) {
			?><div class="column-1_<?php echo esc_attr($columns); ?> column_padding_bottom"><?php
		}
		?>
			<div<?php echo !empty($post_options['tag_id']) ? ' id="'.esc_attr($post_options['tag_id']).'"' : ''; ?>
				class="sc_services_item sc_services_item_<?php echo esc_attr($post_options['number']) . ($post_options['number'] % 2 == 1 ? ' odd' : ' even') . ($post_options['number'] == 1 ? ' first' : '') . (!empty($post_options['tag_class']) ? ' '.esc_attr($post_options['tag_class']) : ''); ?>"
				<?php echo (!empty($post_options['tag_css']) ? ' style="'.esc_attr($post_options['tag_css']).'"' : '') 
					. (!booklovers_param_is_off($post_options['tag_animation']) ? ' data-animation="'.esc_attr(booklovers_get_animation_classes($post_options['tag_animation'])).'"' : ''); ?>>
				<?php 
				if ((!isset($post_options['links']) || $post_options['links']) && !empty($post_data['post_link'])) {
					?><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php
				}
				if ($post_data['post_icon'] && $post_options['tag_type']=='icons') {
					booklovers_show_layout(booklovers_do_shortcode('[trx_icon icon="'.esc_attr($post_data['post_icon']).'" shape="round"]'));
				} else {
					?>
					<div class="sc_services_item_featured post_featured">
						<?php
						booklovers_template_set_args('post-featured', array(
							'post_options' => $post_options,
							'post_data' => $post_data
						));
						get_template_part(booklovers_get_file_slug('templates/_parts/post-featured.php'));
						?>
					</div>
					<?php
				}
				if ($show_title) {
					?><h4 class="sc_services_item_title"><?php booklovers_show_layout($post_data['post_title']); ?></h4><?php
				}
				if ((!isset($post_options['links']) || $post_options['links']) && !empty($post_data['post_link'])) {
					?></a><?php
				}
				?>
			</div>
		<?php
		if (booklovers_param_is_on($post_options['slider'])) {
			?></div></div><?php
		} else if ($columns > 1) {
			?></div><?php
		}
	}
}
?>