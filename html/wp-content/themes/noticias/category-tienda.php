<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */

get_header();
switch_to_blog('13');
 ?>

<script type='text/javascript'>
googletag.cmd.push(function() {
    
/* nacionales slots */
googletag.defineSlot('/11648707/Nacionales-Top-728x90px', [728, 90], 'div-gpt-ad-1403196057127-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nacionales-Top-270x90', [270, 90], 'div-gpt-ad-1403203008472-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nacionales-bottom-728x90px', [728, 90], 'div-gpt-ad-1403197158457-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nacionales-Left-160x600px', [160, 600], 'div-gpt-ad-1403196624432-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nacionales-Right-160x600px', [160, 600], 'div-gpt-ad-1403196955810-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nacionales-Top-300x250px', [300, 250], 'div-gpt-ad-1403201478352-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nacionales-Sidebar-300x250px', [300, 250], 'div-gpt-ad-1403211182544-0').addService(googletag.pubads());

googletag.pubads().enableSingleRequest();
googletag.enableServices(); 
});      
</script> 


<?php global  $wpdb; $user_id = get_current_user_id(); $qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'"; $avalidgoogleid = $wpdb->get_results( $qry ); foreach ( $avalidgoogleid as $avalidgoogleid ) { $gid = $avalidgoogleid ->identifier; $uemail  = $avalidgoogleid ->email; $websiteurl = $avalidgoogleid ->websiteurl; }
 ?>

<?php 
if ($gid > 10000000 )  { 
	include(STYLESHEETPATH . '/page-wing-ads-loggedin.php'); 
	include(STYLESHEETPATH . '/backpages-top-loggedin.php'); 
} else { 
	include(STYLESHEETPATH . '/nacionales-page-wing-ads.php'); 
	include(STYLESHEETPATH . '/banner-ad-widget-nacionales-728x90.php'); 
	include(STYLESHEETPATH . '/banner-ad-widget-nacionales-270x90.php'); 
}

responsive_wrapper(); // before wrapper container hook 
echo '<div id="wrapper" class="clearfix">';
responsive_wrapper_top(); // before wrapper content hook 
responsive_in_wrapper(); // wrapper hook 
echo '<div id="content-archive" class="' . implode( ' ', responsive_get_content_classes() ) . '">';

$max_posts = 9;
$right_col_start = 5;
$right_col_pix = 1;
//$category = get_the_category(); 
//$themaincat = $category[0]->cat_ID;
//$single_cat_title = $category[0]->cat_name;
/*
$themaincat = 1;
$single_cat_title = "Nacionales";

$max_width = 'max-width:100%;';
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/nacionales/"><div class="title-left">NACIONALES</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); 

if ( $paged < 2 )
{
//wp_reset_query();
//$args = array( 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => false, 'type' => 'BOOLEAN' ) ), 'post__not_in' => $feat_post );
$args = array(
	'cat' => $themaincat,
	'posts_per_page' => 1,
	'meta_key' => '_thumbnail_id',
	'meta_query' => array(
		array(
		 'key' => 'destacado',
		 'value' => true,
		 'type' => 'BOOLEAN'
		     )
        ),
//	'tag_id' => 24124
//	'post__in'  => get_option( 'sticky_posts' ),
	'ignore_sticky_posts' => 1
);
$story_count = 0;
$the_query = new WP_Query( $args );
if( !$the_query->have_posts() ) 
{
//wp_reset_query();
$args = array(
	'cat' => $themaincat,
	'posts_per_page' => 1,
	'meta_key' => '_thumbnail_id',
//	'tag_id' => 24124
//	'post__in'  => get_option( 'sticky_posts' ),
	'ignore_sticky_posts' => 1
);
$story_count = 0;
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
//removeQueryFilter();
}
if( $the_query->have_posts() ) 
{
while ( $the_query->have_posts() )
{
	$the_query->the_post();
	$posted_time = get_the_time('h:i A');
$write_comments = writeComments('white', $post->ID);

}
}
else
{
	$story_pre = '<div class="su-column su-column-size-2-3" style="width:420px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
	echo '<div> No hay notas en esta categoria </div>'; 
	echo $story_pre;
	$max_posts = 9;
}
}
wp_reset_query();
global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post ) );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
*/
global $wp_query;
var_dump($wp_query);
var_dump($query);
$even = 0; 
	if( have_posts() ) 
	{
		//get_template_part( 'deportes-loop-header' ); 
		while( have_posts() && $even < $max_posts )
		{ 
			the_post();

//var_dump($query);
$even++;
//$float='left';
echo '<div style="clear:both;"></div>';
if ($paged > 1 && $even == 1)
{
	$story_pre = '<div class="su-column su-column-size-2-3" style="width:420px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
	echo $story_pre;
}
if ($paged < 2)
{
if ($even < $right_col_start)
{
	$max_width = 'width:420px;';
}
//		$float='right';

if ($pix_orient != 'horizontal' && $even == 1)
{
	echo '<div class="adbox-centered-300x250">'; ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-category-page-center-nacionales.php'); echo ""; } ?>

<?php
	echo '</div>';
}
}

if ($even == $right_col_start)
{
echo '</div>';
echo '<div class="su-column su-column-size-1-3">';
$max_width = 'width:100%;';
}
 
echo '<div style="clear:both;"></div>';
if ($even == 1 && $pix_orient == 'horizontal' && $paged < 2)
{
$exp_words = 30;
$extract_chars = 180;
include(STYLESHEETPATH . '/templates/cat-mini.php');

	echo '<div class="adbox-centered-300x250">'; ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-category-page-center-nacionales.php'); echo ""; } ?>

<?php	echo '</div>';
}
else
{
if (!$right_col_pix && $even >= $right_col_start)
{
	$show_img = 0;	
}
else
{
	$show_img = 1;	
}
$show_comments = 1;
include(STYLESHEETPATH . '/templates/normal.php');

}
}		
		//get_template_part( 'loop-nav' );
}
	else 
{
		get_template_part( 'loop-no-posts' );
}
	?>
</div><!-- end of 2-3 column -->
<?php
echo '<div style="clear:both;"></div>';
if ( $paged < 2 )
{
include('templates/mas-en.php');
/*
?>
<div class="destacados-section">
<?php echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/nacionales/page/2"><div class="title-left">MÁS EN ' . mb_strtoupper($single_cat_title) . '</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); ?>

<?php
$args = array( 'posts_per_page' => 4, 'offset'=> 11, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => $themaincat, 'ignore_sticky_posts' => 1 );
$myposts = get_posts( $args );
foreach ( $myposts as $post )
{	
	setup_postdata( $post );
	$title = the_title_attribute('echo=0');
	$post_url = get_permalink($post->ID);
	echo '<div style="position:relative;float:left;width:150px;margin-right:10px;padding-left:4px;">';
	echo '<div class="tcp-product-list tcpf" style="width:150px;margin-bottom:10px;min-height:300px;">';
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' ); 
	$feat_image = $feat_image_array[0];
	echo '<div style="position:relative;width:150px;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:150;"></a>' . PHP_EOL;
	echo '</div>';
	echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}
	echo '</div>' . PHP_EOL;
*/
}
	wp_reset_postdata();
//echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
?>
</div><!-- end of #content-archive -->
<?php removeQueryFilter(); ?>
<?php get_sidebar('nacionales'); ?> 

<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-ad-widget-nacionales-bottom-728x90.php'); echo ""; } ?>

<?php get_footer(); ?>
