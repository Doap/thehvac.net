<?php
/**
 * This file loads the required files and sets the global variables used in the theme.
 *
 * It's higly adviced not to edit this file or anyother file in the theme for that matter. Use child themes instead.
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features.  Use a priority of 9 if wanting to run before the parent theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package Swift
 * @subpackage Functions
 * @version 6.1.0
 * @author Satish Gandham <satish@swiftthemes.com>
 * @copyright Copyright (c) 2008 - 2012, Satish Gandham
 * @link http://swiftthemes.com/
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

require_once get_template_directory().'/lib/load-core.php';
require_once( get_template_directory() . '/lib/functions/Mobile_Detect.php' );
$swift_is_mobile = new Mobile_Detect();

// Setting the global variables used in the theme
GLOBAL $swift_options;
GLOBAL $swift_design_options;
GLOBAL $swift_thumbnail_sizes;
GLOBAL $swift_is_mobile;
GLOBAL $swift_post_meta;

$temp_options = get_option('SwiftOptions');
$swift_options = $temp_options['site_options'];
$swift_design_options = $temp_options['design_options'];
$swift_thumbnail_sizes 	= get_option( 'swift_dimensions');

if ( ! isset( $content_width ) ) $content_width = 900;

add_action( 'wp_head', 'swift_cms_mode');
/**
 * Remove WordPress formatting and adding page specific CSS
 *
 * WordPress auto formatting makes it difficult to design static pages. This function
 * stops WP from adding <p> tags and removing line breaks.
 *
 * Second part of this function pulls the CSS added through the page through custom fields
 * and adds it to the head
 *
 * @since Swift 6.0
*/
function swift_cms_mode(){
	if(!is_singular())
		return ;

	global $wp_query, $swift_post_meta;
	$swift_post_meta = get_post_meta( $wp_query->post->ID,'_swift_post_meta',true);
	// Removing wpautop
	if( isset($swift_post_meta['disable_oversmart_tinymce']) && (bool)$swift_post_meta['disable_oversmart_tinymce'] ){
		remove_filter ('the_content',  'wpautop');

	}
	// Adding page specific CSS
	if( isset($swift_post_meta['page_css']) && $swift_post_meta['page_css'] != ''){
		echo '<style>'. stripslashes($swift_post_meta['page_css']).'</style>';
	}
}

/**
 * A small wrapper function for yoast_breadcrumb
 */
function swift_breadcrumb_output() {
	if(function_exists('yoast_breadcrumb'))
		yoast_breadcrumb('<div id="breadcrumbs">','</div>');
	return;
}

/**
 * Add yoast breadcrumbs before the content div
 *
 * We don't want breadcrumbs on home page and front page of the blog. So the first if condition
 * takes care of it, but the is_home() and is_front_page() are not availble until the wp_head is
 * loaded. So we hook this fucntion to wp_head action hook.
 *
 */
add_action('swift_before_content_singular','swift_breadcrumb_output',8,1);
add_action('swift_before_content_archive','swift_breadcrumb_output',8,1);
add_action('swift_before_content_search','swift_breadcrumb_output',8,1);

/**
 * Adds CSS to WordPress admin to add icon to Swift theme widgets
*/
function swift_admin_custom_css() {
	echo '<style type="text/css">
			div[id*="swift"] .widget-title{background:url("'.THEME_URI.'/lib/admin/images/icon.png") no-repeat 5px 50%;padding-left:50px}
					</style>';
}
add_action( 'admin_head', 'swift_admin_custom_css' );
add_action('wp_loaded','download_colors',0);
add_action('admin_init','download_css_js',100);
/*add_action('wp_loaded','test',100);
 function test(){
GLOBAL $wp_filesystem;
var_dump($wp_filesystem);
}*/

/* Loading Google Fonts */
add_action('wp_head','swift_load_gfonts',1);
function swift_load_gfonts(){
	GLOBAL $swift_design_options;
	if(isset($swift_design_options['swift_gfonts']) && is_array($swift_design_options['swift_gfonts']))
		$fonts = $swift_design_options['swift_gfonts'];
	else
		return;
	$list = '';
	foreach($fonts as $font){
		if($font[1] && $font[2]){
			echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$font[0].'&text='.urlencode(get_bloginfo( 'name').get_bloginfo( 'description')).'">';
		}else{
			if($font[1])
				echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$font[0].'&text='.urlencode(get_bloginfo( 'name')).'">';
			if($font[2])
				echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$font[0].'&text='.urlencode(get_bloginfo( 'description')).'">';
		}
		if( !$font[1] && !$font[2]){
			$list .= $font[0].'|';
		}
	}
	echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$list.'">';
}
function swift_limit_posts_per_archive_page() {
	GLOBAL $swift_design_options;
	if ( is_archive() )
		set_query_var('posts_per_archive_page', $swift_design_options['archive_post_count']); // or use variable key: posts_per_page
}
if(isset($swift_design_options['archive_post_count_enable']) && $swift_design_options['archive_post_count_enable'] && isset($swift_design_options['archive_post_count']))
	add_filter('pre_get_posts', 'swift_limit_posts_per_archive_page');


add_action('template_redirect','swift_random_template');
function swift_random_template() {
	if (isset($_GET['random']) && $_GET['random'] == 1) {

		$posts = get_posts('post_type=post&orderby=rand&numberposts=1');
		foreach($posts as $post) {
			$link = get_permalink($post);
		}
		wp_redirect($link,307);
		exit;
	}
}
?>