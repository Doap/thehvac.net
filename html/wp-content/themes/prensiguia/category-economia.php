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
$left_300_story = 5;
?>


<script type='text/javascript'>
googletag.cmd.push(function() {

/* economia slots */
googletag.defineSlot('/11648707/Economia-Top-270x90', [270, 90], 'div-gpt-ad-1403210392163-4').addService(googletag.pubads());
googletag.defineSlot('/11648707/Economia-Top-728x90px', [728, 90], 'div-gpt-ad-1403210392163-6').addService(googletag.pubads());
googletag.defineSlot('/11648707/Economia-Left-160x600px', [160, 600], 'div-gpt-ad-1403210392163-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Economia-Right-160x600px', [160, 600], 'div-gpt-ad-1403210392163-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Economia-Top-300x250px', [300, 250], 'div-gpt-ad-1403210392163-5').addService(googletag.pubads());
googletag.defineSlot('/11648707/Economia-Sidebar-300x250px', [300, 250], 'div-gpt-ad-1403211432106-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Economia-bottom-728x90px', [728, 90], 'div-gpt-ad-1403210392163-0').addService(googletag.pubads());


googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>

<?php
global  $wpdb; $user_id = get_current_user_id(); $qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'"; $avalidgoogleid = $wpdb->get_results( $qry ); foreach ( $avalidgoogleid as $avalidgoogleid ) { $gid = $avalidgoogleid ->identifier; $uemail  = $avalidgoogleid ->email; $websiteurl = $avalidgoogleid ->websiteurl; }
?>

<?php 
if ($gid > 10000000 )  { 
        include(STYLESHEETPATH . '/page-wing-ads-loggedin.php');
        include(STYLESHEETPATH . '/backpages-top-loggedin.php');
} else {  
        include(STYLESHEETPATH . '/economia-page-wing-ads.php');
        include(STYLESHEETPATH . '/banner-ad-widget-economia-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-economia-270x90.php');
}            

?>

<?php
responsive_wrapper(); // before wrapper container hook 
echo '<div id="wrapper" class="clearfix">';
responsive_wrapper_top(); // before wrapper content hook 
responsive_in_wrapper(); // wrapper hook 
echo '<div id="content-archive" class="' . implode( ' ', responsive_get_content_classes() ) . '">';
$max_posts = 9;
$right_col_start = 5;
$right_col_pix = 1;
//$category = get_the_category(); 
$themaincat = 31;
$single_cat_title = 'Economía'; 
$max_width = 'max-width:100%;';
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); 

if ( $paged < 2 )
{
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
		'ignore_sticky_posts' => 1
	);
	$story_count = 0;
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) 
	{
		while ( $the_query->have_posts() )
		{
			$the_query->the_post();
			$posted_time = get_the_time('h:i A');
			if ( has_post_thumbnail() )
			{
				$image_info = wp_get_attachment_metadata( get_post_thumbnail_id($post->ID) );
				$img_width = $image_info['width'];
				$img_height = $image_info['height'];
				$feat_post[] = $post->ID;

				$right_col_start = 3;
				$right_col_pix = 0;
				$max_posts = 7;
				$pix_orient = 'horizontal';
				$pix_class = 'catpic-hori';
				$pix_size = 'Video-Poster-640x360';
				$pix_width = '100%;';
				$pix_img_width = ($img_width < 640) ? round($img_width * 1.065625) . 'px;' : '682px;';
		
				$pix_img_height = '384px;';
				$story_pre = '<div style="clear:both;">';
				$story_post = '</div><div class="su-column su-column-size-1-3" style="width:250px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
				$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $pix_size );
				$post_url = get_permalink($post->ID);
				$feat_image = $feat_image_array[0];
	
				$theexcerpt = get_doap_excerpt(300,1,1);
				//		$theexcerpt = get_doap_excerpt(30,1);
				$theexcerpt = '<div class="category-excerpt" style="padding:4px;">' . $theexcerpt . '</div>' . PHP_EOL;
				echo $story_pre;
				echo do_shortcode('<a href="' . $post_url . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="25" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>');
				echo '<div class="' . $pix_class . '" style="position:relative;float:left;border: 1px solid #ccc;max-width:' . $pix_width . '">' . PHP_EOL;
				echo '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . 'height:' . $pix_img_height . '">' . PHP_EOL;
				echo '<div style="position:absolute;display:block;bottom:0px;left:0px;height:30px;width:100%;max-width:100%;color:#fff;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;font-size:11pt;"><div><div style="position:absolute;width:60px;margin:0px 5px 5px 0px;padding:5px;color:#fff;"> ' . $posted_time . '</div>';
				echo '<div style="float:right;margin:0px 5px 5px 65px;text-align:right;padding:5px;color:#fff;">';
		//		echo $write_comments;
				echo '</div></div></a></div></div>';
				echo '<div style="clear:both;"></div>';
				echo $theexcerpt;
				echo $story_post;
			}
		}
	}
	else
	{
		$max_posts = 9;
	}
}
wp_reset_query();
global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post ) );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
$even = 0; 
if( $the_query->have_posts() ) 
{
	while( $the_query->have_posts() && $even < $max_posts )
	{ 
		$the_query->the_post();
		$even++;
		$float='float:left;';
		if ($even == 1)
		{
			echo '<div class="econ-left"><div class="su-column-inner su-clearfix"></div>';
		}
		if ($paged < 2)
		{
			if ($even < 5)
			{
				$max_width = 'width:250px;';
			}
			//		$float='float:right;';
			if ($even == 5)
			{
				echo '</div>';
				echo '<div style="clear:both;"></div>';
				echo '<div style="margin:0px auto 0px auto;width:300px;position:relative;float:left;padding-right:10px;">';
				if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-category-page-center-economia.php'); echo ""; } 
				//	include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-300x250-category-page-center.php');
				echo '</div>';
				$max_width = 'width:350px;';
			}
		}
		if ($even == 2 && paged < 2)
		{
			echo do_shortcode('[table id=23 /]');
			echo '</div>';
			echo '</div>';
			echo do_shortcode('<div id="comport-graph">[xyz-ips snippet="economy-graphs"]</div>');
			echo '<div style="clear:both;"></div>';
			echo '<div style="width:100%;height:auto;">';
		}
		if ($even > 5 && $even < 8 && paged < 2)
		{
			$float_class = ($even == 7) ? 'class="su-post float_right"' : 'class="su-post float_left"';
			$max_width = 'width:330px;';
		}
		if ($even > 1 && $even < 6)
		{
			include(STYLESHEETPATH . '/templates/left_300.php');
		}
		else
		{
			$show_img = 1;
			include(STYLESHEETPATH . '/templates/normal.php');
			responsive_entry_after();
		}
	}		
		//get_template_part( 'loop-nav' );
}
else 
{
	get_template_part( 'loop-no-posts' );
}
echo '<div style="clear:both;"></div>';
if ( $paged < 2 )
{
	include('templates/mas-en.php');
}

	wp_reset_postdata();
//echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
?>
</div><!-- end of #content-archive -->
<?php get_sidebar('economia'); ?> 
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php if ($gid > 10000000)  { 
include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); 
} else { 
include(STYLESHEETPATH . '/banner-ad-widget-economia-footer-728x90.php'); 
} ?>

<?php get_footer(); ?>
