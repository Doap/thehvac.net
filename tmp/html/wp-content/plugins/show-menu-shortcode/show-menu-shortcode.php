<?php

/*
Plugin Name: Show Menu Shortcode
Plugin URI: http://www.mokamedianyc.com/dev/show-menu-shortcode/
Description: Provides a [show-menu] <a href="http://codex.wordpress.org/Shortcode_API">shortcodes</a> for displaying a menu within a post or page.  The shortcode accepts most parameters that you can pass to the <a href="http://codex.wordpress.org/Template_Tags/wp_nav_menu">wp_nav_menu()</a> function.  To show a menu, add [show-menu menu="Main-menu"] in the page or post body.
Author: Bob Matsuoka
Version: 1.0
Author URI: http://www.mokamedianyc.com
*/

function shortcode_show_menu( $atts, $content, $tag ) {
	
	global $post;
	
	// Set defaults
	$defaults = array(
		'menu'        	  => '',
		'container'       => 'div', 
		'container_class' => 'menu-container', 
		'container_id'    => '',
		'menu_class'      => 'menu', 
		'menu_id'         => '',
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'depth'			  => 0,
		'echo' 			  => false
	);
	
	// Merge user provided atts with defaults
	$atts = shortcode_atts( $defaults, $atts );
	
	// Create output
	$out = wp_nav_menu( $atts );
	
	return apply_filters( 'shortcode_show_menu', $out, $atts, $content, $tag );
	
}

add_shortcode( 'show-menu', 'shortcode_show_menu' );

?>