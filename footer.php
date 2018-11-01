<?php
/**
 * The template for displaying the footer.
 */

				booklovers_close_wrapper();	// <!-- </.content> -->

				booklovers_profiler_add_point(esc_html__('After Page content', 'booklovers'));
	
				// Show main sidebar
				get_sidebar();

				if (booklovers_get_custom_option('body_style')!='fullscreen') booklovers_close_wrapper();	// <!-- </.content_wrap> -->
				?>
			
			</div>		<!-- </.page_content_wrap> -->
			
			<?php
			// Footer Testimonials stream
			if (booklovers_get_custom_option('show_testimonials_in_footer')=='yes') { 
				$count = max(1, booklovers_get_custom_option('testimonials_count'));
				$data = booklovers_sc_testimonials(array('count'=>$count));
				if ($data) {
					?>
					<footer class="testimonials_wrap sc_section scheme_<?php echo esc_attr(booklovers_get_custom_option('testimonials_scheme')); ?>">
						<div class="testimonials_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php booklovers_show_layout($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}
			
			// Footer sidebar
			$footer_show  = booklovers_get_custom_option('show_sidebar_footer');
			$sidebar_name = booklovers_get_custom_option('sidebar_footer');
			if (!booklovers_param_is_off($footer_show) && is_active_sidebar($sidebar_name)) { 
				booklovers_storage_set('current_sidebar', 'footer');
				?>
				<footer class="footer_wrap widget_area scheme_<?php echo esc_attr(booklovers_get_custom_option('sidebar_footer_scheme')); ?>">
					<div class="footer_wrap_inner widget_area_inner">
						<div class="content_wrap">
							<div class="columns_wrap"><?php
							ob_start();
							do_action( 'before_sidebar' );
							if ( !dynamic_sidebar($sidebar_name) ) {
								// Put here html if user no set widgets in sidebar
							}
							do_action( 'after_sidebar' );
							$out = ob_get_contents();
							ob_end_clean();
							booklovers_show_layout(chop(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out)));
							?></div>	<!-- /.columns_wrap -->
						</div>	<!-- /.content_wrap -->
					</div>	<!-- /.footer_wrap_inner -->
				</footer>	<!-- /.footer_wrap -->
				<?php
			}


			// Footer Twitter stream
			if (booklovers_get_custom_option('show_twitter_in_footer')=='yes') { 
				$count = max(1, booklovers_get_custom_option('twitter_count'));
				$data = booklovers_sc_twitter(array('count'=>$count));
				if ($data) {
					?>
					<footer class="twitter_wrap sc_section scheme_<?php echo esc_attr(booklovers_get_custom_option('twitter_scheme')); ?>">
						<div class="twitter_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php booklovers_show_layout($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}


			// Google map
			if ( booklovers_get_custom_option('show_googlemap')=='yes' ) { 
				$map_address = booklovers_get_custom_option('googlemap_address');
				$map_latlng  = booklovers_get_custom_option('googlemap_latlng');
				$map_zoom    = booklovers_get_custom_option('googlemap_zoom');
				$map_style   = booklovers_get_custom_option('googlemap_style');
				$map_height  = booklovers_get_custom_option('googlemap_height');
				if (!empty($map_address) || !empty($map_latlng)) {
					$args = array();
					if (!empty($map_style))		$args['style'] = esc_attr($map_style);
					if (!empty($map_zoom))		$args['zoom'] = esc_attr($map_zoom);
					if (!empty($map_height))	$args['height'] = esc_attr($map_height);
					booklovers_show_layout(booklovers_sc_googlemap($args));
				}
			}

			// Footer contacts
			if (booklovers_get_custom_option('show_contacts_in_footer')=='yes') { 
				$address_1 = booklovers_get_theme_option('contact_address_1');
				$address_2 = booklovers_get_theme_option('contact_address_2');
				$phone = booklovers_get_theme_option('contact_phone');
				$mail = booklovers_get_theme_option('contact_email');
				if (!empty($address_1) || !empty($address_2) || !empty($phone) || !empty($mail)) {
					?>
					<footer class="contacts_wrap scheme_<?php echo esc_attr(booklovers_get_custom_option('contacts_scheme')); ?>">
						<div class="contacts_wrap_inner">
							<div class="content_wrap">
								<?php booklovers_show_logo(false, false, true); ?>
								<div class="contacts_address">
									<address class="address_right">
										<?php if (!empty($phone)) echo '<span>' .esc_html__('Phone:', 'booklovers') .'</span>'. ' ' .'<span class="phone"><a href="tel:'. esc_html($phone).'">'. esc_html($phone).'</a></span>' . '<br>'; ?>
										<?php if (!empty($mail)) echo '<span>' .esc_html__('Fax:', 'booklovers')  .'</span><a href="mailto:'. esc_html($mail).'">'. ' ' . esc_html($mail).'</a>'; ?>
									</address>
									<address class="address_left">
										<?php if (!empty($address_2)) echo '<span>' .esc_html__('Address: ','booklovers') .'</span>'. esc_html($address_2) . '<br>'; ?>
										<?php if (!empty($address_1)) echo esc_html($address_1); ?>
									</address>
								</div>
								<?php booklovers_show_layout(booklovers_sc_socials(array('size' => "small", 'shape' => 'round'))); ?>
							</div>	<!-- /.content_wrap -->
						</div>	<!-- /.contacts_wrap_inner -->
					</footer>	<!-- /.contacts_wrap -->
					<?php
				}
			}

			// Copyright area
			$copyright_style = booklovers_get_custom_option('show_copyright_in_footer');
			if (!booklovers_param_is_off($copyright_style)) {
				?> 
				<div class="copyright_wrap copyright_style_<?php echo esc_attr($copyright_style); ?>  scheme_<?php echo esc_attr(booklovers_get_custom_option('copyright_scheme')); ?>">
					<div class="copyright_wrap_inner">
						<div class="content_wrap">
							<?php
							if ($copyright_style == 'menu') {
								if (($menu = booklovers_get_nav_menu('menu_footer'))!='') {
									booklovers_show_layout($menu);
								}
							} else if ($copyright_style == 'socials') {
								booklovers_show_layout(booklovers_sc_socials(array('size'=>"tiny")));
							}
							?>
							<div class="copyright_text"><?php
                                $booklovers_copyright = booklovers_get_custom_option('footer_copyright');
                                $booklovers_copyright = str_replace(array('{{Y}}', '{Y}'), date('Y'), $booklovers_copyright);
                                booklovers_show_layout($booklovers_copyright); ?></div>
						</div>
					</div>
				</div>
				<?php
			}

			booklovers_profiler_add_point(esc_html__('After Footer', 'booklovers'));
			?>
			
		</div>	<!-- /.page_wrap -->

	</div>		<!-- /.body_wrap -->
	
	<?php if ( !booklovers_param_is_off(booklovers_get_custom_option('show_sidebar_outer')) ) { ?>
	</div>	<!-- /.outer_wrap -->
	<?php } ?>

<?php
// Post/Page views counter
get_template_part(booklovers_get_file_slug('templates/_parts/views-counter.php'));

// Login/Register
if (booklovers_get_theme_option('show_login')=='yes') {
	booklovers_enqueue_popup();
	// Anyone can register ?
	if ( (int) get_option('users_can_register') > 0) {
		get_template_part(booklovers_get_file_slug('templates/_parts/popup-register.php'));
	}
	get_template_part(booklovers_get_file_slug('templates/_parts/popup-login.php'));
}

// Front customizer
if (booklovers_get_custom_option('show_theme_customizer')=='yes') {
	get_template_part(booklovers_get_file_slug('core/core.customizer/front.customizer.php'));
}
?>

<a href="#" class="scroll_to_top icon-up" title="<?php esc_attr_e('Scroll to top', 'booklovers'); ?>"></a>

<div class="custom_html_section">
<?php booklovers_show_layout(booklovers_get_custom_option('custom_code')); ?>
</div>

<?php
booklovers_show_layout(booklovers_get_custom_option('gtm_code2'));

booklovers_profiler_add_point(esc_html__('After Theme HTML output', 'booklovers'));

wp_footer(); 
?>

</body>
</html>