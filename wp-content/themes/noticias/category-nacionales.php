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

get_header(); ?>

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
$themaincat = 21;
$single_cat_title = "Nacionales";

$max_width = 'max-width:100%;';
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/nacionales/"><div class="title-left">NACIONALES</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); 

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
	if( !$the_query->have_posts() ) 
	{
		$args = array(
			'cat' => $themaincat,
			'posts_per_page' => 1,
			'meta_key' => '_thumbnail_id',
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
			if ( has_post_thumbnail() )
			{
				$image_info = wp_get_attachment_metadata( get_post_thumbnail_id($post->ID) );
				$img_width = $image_info['width'];
				$img_height = $image_info['height'];
				$feat_post[] = $post->ID;
				if ($img_height > $img_width)
				{
					$right_col_start = 4;
					$right_col_pix = 1;
					$max_posts = 9;
					$pix_class = 'catpic-vert';
					$pix_size = 'responsive-450';
					$pix_width = '430px;position:relative;float:left;';
					$pix_img_width = '450px;';
					//$story_pre = '<div class="su-column su-column-size-2-3" style="width:420px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
					$story_pre = '<div class="su-column su-column-size-2-3"><div class="su-column-inner su-clearfix"></div>';
					$story_post = '';
				}
				else
				{
					$right_col_start = 3;
					$right_col_pix = 0;
					$max_posts = 6;
					$pix_orient = 'horizontal';
					$pix_class = 'catpic-hori';
					$pix_size = 'Video-Poster-640x360';
					$pix_width = '100%;';
					$pix_img_width = '667px;';
					$story_pre = '<div style="clear:both;">';
					$story_post = '</div><div class="su-column su-column-size-2-3""><div class="su-column-inner su-clearfix"></div>';
				}
			}
			include(STYLESHEETPATH . '/templates/cat-feat-img-extract.php');
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
$even = 0; 
if( $the_query->have_posts() ) 
{
	//get_template_part( 'deportes-loop-header' ); 
	while( $the_query->have_posts() && $even < $max_posts )
	{ 
		$the_query->the_post();
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
				echo '<div class="adbox-centered-300x250">';
				if ($gid > 10000000)
				{
					include(STYLESHEETPATH . '/middle-300x250-loggedin.php');
				}
				else
				{
					include(STYLESHEETPATH . '/ad-300x250-category-page-center-nacionales.php');
					echo "";
				}
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
			echo '<div class="adbox-centered-300x250">';
			if ($gid > 10000000)
			{
				include(STYLESHEETPATH . '/middle-300x250-loggedin.php');
			}
			else
			{
				include(STYLESHEETPATH . '/ad-300x250-category-page-center-nacionales.php');
				echo "";
			} 
			echo '</div>';
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
<div style="clear:both;"></div>
<?php
if ( $paged < 2 )
{
include('templates/mas-en.php');
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
