<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Sequential
 */

function sequential_jetpack_setup() {
	/**
	 * Add theme support for Infinite Scroll.
	 * See: http://jetpack.me/support/infinite-scroll/
	 */
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'main',
		'footer_widgets' => array(
			'sidebar-2',
		),
		'footer'         => 'page',
	) );

	/**
	 * Add theme support for Responsive Videos.
	 */
	add_theme_support( 'jetpack-responsive-videos' );

	/**
	 * Add theme support for Logo upload.
	 */
	add_image_size( 'sequential-logo', 624, 624 );
	add_theme_support( 'site-logo', array( 'size' => 'sequential-logo' ) );
}
add_action( 'after_setup_theme', 'sequential_jetpack_setup' );

/**
 * Return early if Site Logo is not available.
 */
function sequential_the_site_logo() {
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		return;
	} else {
		jetpack_the_site_logo();
	}
}

/**
 * Remove sharedaddy script.
 */
function sequential_remove_sharedaddy_script() {
    remove_action( 'wp_head', 'sharing_add_header', 1 );
}
add_action( 'template_redirect', 'sequential_remove_sharedaddy_script' );

/**
 * Remove related-posts and likes scripts.
 */
function sequential_remove_jetpack_scripts() {
    wp_dequeue_style( 'jetpack_related-posts' );
    wp_dequeue_style( 'jetpack_likes' );
}
add_action( 'wp_enqueue_scripts', 'sequential_remove_jetpack_scripts' );

/**
 * Remove sharedaddy from excerpt.
 */
function sequential_remove_sharedaddy() {
    remove_filter( 'the_excerpt', 'sharing_display', 19 );
}
add_action( 'loop_start', 'sequential_remove_sharedaddy' );
