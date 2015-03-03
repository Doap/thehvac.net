<?php 
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
	
	add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
	function my_theme_wrapper_start() { 
		get_template_part('pink','header');
		echo '<div class="container"><div class="row-fluid"><div class="span12">'; 
		}


	function my_theme_wrapper_end() {		
			 echo '</div></div></div>';
		} ?>