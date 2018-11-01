<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'booklovers_template_products_theme_setup' ) ) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_template_products_theme_setup', 2 );
	function booklovers_template_products_theme_setup() {
		booklovers_add_template(array(
			'layout' => 'products_6',
			'template' => 'products',
			'mode'   => 'blogger',
			'need_isotope' => true,
			'title'  => esc_html__('Product output', 'booklovers'),
			'thumb_title'  => esc_html__('Productssimages', 'booklovers'),
			'w'		 => 320,
			'h'=>  520
			));

		add_action('booklovers_action_blog_scripts', 'booklovers_template_products_add_scripts');
	}
}


// Add template specific scripts
if (!function_exists('booklovers_template_products_add_scripts')) {
	function booklovers_template_products_add_scripts($style) {
		add_action('booklovers_action_blog_scripts', 'booklovers_template_products_add_scripts');
			wp_enqueue_script( 'isotope', booklovers_get_file_url('js/jquery.isotope.min.js'), array(), null, true );
	}
}

// Template output
if(booklovers_exists_woocommerce()){
if ( !function_exists( 'booklovers_template_products_output' ) ) {
	function booklovers_template_products_output($post_options, $post_data) {
		$show_title = !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote'));
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$product = new WC_Product(get_the_ID());
		$custom_fields = get_post_custom();
		$rating_count = $product->get_rating_count();
		$review_count = $product->get_review_count();
		$average      = $product->get_average_rating();
		$columns = max(1, min(12, empty($post_options['columns_count']) 
			? (empty($parts[1]) ? 1 : (int) $parts[1])
			: $post_options['columns_count']
			));
		$tag = booklovers_in_shortcode_blogger(true) ? 'div' : 'article';
		?>
		<div class="isotope_item isotope_item_<?php echo esc_attr($style); ?> isotope_item_<?php echo esc_attr($post_options['layout']); ?> isotope_column_<?php echo esc_attr($columns); ?>
			<?php
			if ($post_options['filters'] != '') {
				if ($post_options['filters']=='categories' && !empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids))
					echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids);
				else if ($post_options['filters']=='tags' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids))
					echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids);
			}
			?>">
			<<?php booklovers_show_layout($tag); ?> class="post_item post_item_<?php echo esc_attr($style); ?> post_item_<?php echo esc_attr($post_options['layout']); ?>
			<?php echo ' post_format_'.esc_attr($post_data['post_format']) 
			. ($post_options['number']%2==0 ? ' even' : ' odd') 
			. ($post_options['number']==0 ? ' first' : '') 
			. ($post_options['number']==$post_options['posts_on_page'] ? ' last' : '');
			?>">

			<?php if ($post_data['post_video'] || $post_data['post_audio'] || $post_data['post_thumb'] ||  $post_data['post_gallery']) { ?>
			<div class="post_featured">
				<?php
								
				booklovers_template_set_args('post-featured', array(
					'post_options' => $post_options,
					'post_data' => $post_data
					));
				get_template_part(booklovers_get_file_slug('templates/_parts/post-featured.php'));
				?>
			</div>
			<?php } ?>

			<div class="post_content isotope_item_content">

				<?php
				if ($show_title) {
					if (!isset($post_options['links']) || $post_options['links']) {
						?>
						<h5 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php booklovers_show_layout($post_data['post_title']); ?></a></h5>
						<?php
					} else {
						?>
						<h5 class="post_title"><?php booklovers_show_layout($post_data['post_title']); ?></h5>
						<?php
					}
				}
				?>

				<div class="post_descr">
					<div class="author_name">
						<?php booklovers_show_layout($custom_fields['author_name'][0]); ?>
					</div>
					<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'booklovers' ), $average ); ?>">
						<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
							<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( __( 'out of %s5%s', 'booklovers' ), '<span itemprop="bestRating">', '</span>' ); ?>
							<?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'booklovers' ), '<span itemprop="ratingCount" class="rating">' . $rating_count . '</span>' ); ?>
						</span>
					</div>
					<div class="reviews_count">
						<?php echo trim($product->get_review_count()) . esc_html__(' Reviews','booklovers');?>
					</div>


				</div>

			</div>				<!-- /.post_content -->
			</<?php booklovers_show_layout($tag); ?>>	<!-- /.post_item -->
		</div>						<!-- /.isotope_item -->
		<?php
	}
}
}
?>