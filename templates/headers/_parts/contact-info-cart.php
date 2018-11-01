<?php
$cart_items = WC()->cart->get_cart_contents_count();
$cart_summa = strip_tags(WC()->cart->get_cart_subtotal());
$header = booklovers_get_custom_option('top_panel_style');
?>
<a href="#" class="top_panel_cart_button" data-items="<?php echo esc_attr($cart_items); ?>" data-summa="<?php echo esc_attr($cart_summa); ?>">
	<span class="contact_icon icon-cart"></span>
	<?php 
		if ($header == 'header_2'){
		echo '<span class="contact_cart_totals"><span class="title">' . esc_html('Your cart: ','booklovers').'</span>
		<span class="cart_items">'. esc_html($cart_items) . esc_html(' Items - ','booklovers') . $cart_summa .'</span></span>';
		}else{
		echo '<span class="contact_cart_totals">
		<span class="cart_items">' . esc_html($cart_items). '</span></span>';
		}


	?>
</a>
<ul class="widget_area sidebar_cart sidebar"><li>
	<?php
	do_action( 'before_sidebar' );
	booklovers_storage_set('current_sidebar', 'cart');
	if ( !dynamic_sidebar( 'sidebar-cart' ) ) { 
		the_widget( 'WC_Widget_Cart', 'title=&hide_if_empty=1' );
	}
	?>
</li></ul>




