<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'booklovers_template_404_theme_setup' ) ) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_template_404_theme_setup', 1 );
	function booklovers_template_404_theme_setup() {
		booklovers_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			)
		));
	}
}

// Template output
if ( !function_exists( 'booklovers_template_404_output' ) ) {
	function booklovers_template_404_output() {
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
				<span class="icon_404 icon-layer_84"></span>
				<h2 class="page_subtitle"><?php echo '<span>' . esc_html('We Are Sorry!', 'booklovers') . '</span> ' . esc_html('Error 404.', 'booklovers'); ?></h2>
				<p class="page_description"><?php echo wp_kses_data( sprintf( __('Can\'t find what you need? Take a moment and do <br> a search below or start from <a href="%s">our homepage</a>.', 'booklovers'), esc_url(home_url('/')) ) ); ?></p>
				<div class="page_search"><?php if (function_exists('booklovers_sc_search')) booklovers_show_layout(booklovers_sc_search(array('state'=>'fixed', 'title'=>__('To search type and hit enter', 'booklovers')))); ?></div>
			</div>
		</article>
		<?php
	}
}
?>