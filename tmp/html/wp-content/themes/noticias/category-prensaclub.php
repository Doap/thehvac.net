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

$max_posts = 4;
$right_col_start = 5;
$right_col_pix = 1;
//$category = get_the_category(); 
//$themaincat = $category[0]->cat_ID;
//$single_cat_title = $category[0]->cat_name;
$themaincat = 64059;
$single_cat_title = "PrensaClub";

$max_width = 'max-width:100%;';
echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'"><div class="title-left">PRENSA CLUB</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');

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
		//add_filter('posts_clauses', 'filterEdiciones');
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
				$right_col_start = 3;
				$right_col_pix = 0;
				$pix_orient = 'horizontal';
				$pix_class = 'catpic-hori';
				$pix_size = 'Video-Poster-640x360';
				$pix_width = '100%;';
				$pix_img_width = '667px;';
				$story_pre = '<div style="clear:both;">';
				$story_post = '</div>';
			}

			include(STYLESHEETPATH . '/templates/cat-feat-img-extract.php');
		}
	}
	else
	{
		echo '<div> No hay notas en esta categoria </div>'; 
		$max_posts = 9;
	}
}
wp_reset_query();
global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'cat' => $themaincat, 'post__not_in' => $feat_post ) );
add_filter('posts_clauses', 'filterEdiciones');
add_filter('posts_clauses', 'filterNoBreves');
$the_query = new WP_Query( $args );

//var_dump($the_query);
$even = 0; 
	if( $the_query->have_posts() ) 
	{
		//get_template_part( 'deportes-loop-header' ); 
		//while( $the_query->have_posts() && $even < $max_posts )
		while( $the_query->have_posts() )
		{ 
			$the_query->the_post();

			//var_dump($query);
			$even++;
			//$float='left';
			echo '<div style="clear:both;"></div>';
			//echo $post->ID;
			if ($paged < 2)
			{
				if ($even < $right_col_start)
				{
				//	$max_width = 'width:420px;';
				}
	//		$float='right';

			}

			$max_width = 'width:667px;';
			if ($even == $right_col_start)
			{
				//$max_width = 'width:100%;';
			}
 
			echo '<div style="clear:both;"></div>';
			if ($even == 6111 && $pix_orient == 'horizontal' && $paged < 2)
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
					$show_img = 1;	
				}
				else
				{
					$show_img = 1;	
				}
				$show_comments = 0;
				//include(STYLESHEETPATH . '/templates/normal.php');
				responsive_entry_before(); 
				echo '<div id="su-post-' . get_the_ID() . '" ' . $float_class . ' style="position:relative;max-' . $max_width . '">';
				//echo '<div id="su-post-' . get_the_ID() . '" style="position:relative;">';
				responsive_entry_top(); 
				$theexcerpt = get_doap_excerpt(300,1,1);
				$theexcerpt = '<div class="category-excerpt" style="padding:4px;text-align:justify;">' . $theexcerpt . '</div>' . PHP_EOL;
				$thepermalink = get_the_permalink();
				//echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>');
				//echo '<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo."><div class="su-heading su-heading-style-modern-1-blue su-heading-align-left fp-title-bar" style="font-size:20px;"><div class="su-heading-inner" style="display:inline;">' . ucfirst(get_the_title()) . '</div></div></a>';
				if ($show_comments)
				{
					if ($show_cat_in_comments)
					{
						echo addCatForComments($single_cat_title, $single_cat_slug) . writeComments('black', $post->ID);
					}
					else echo writeComments('black', $post->ID);
				}
				echo '<div class="post-entry">';
				$gmt_timestamp = get_post_time('U', true); 
				if ( has_post_thumbnail() && $show_img )
				{
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-600' );
					$post_url = get_permalink($post->ID);
					$feat_image = $feat_image_array[0];
					echo '<div class="img-div" style="margin-top:10px;border: 1px solid #ccc;' . $max_width .'">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"style="width:100%"></a>' . PHP_EOL;
					echo '</div>';
				}
				echo $theexcerpt;
				wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
				echo '</div>';
				responsive_entry_bottom(); 
				echo '</div>';
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
		include('templates/mas-en-prensaclub.php');
	}
	//	wp_reset_postdata();
	//echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';

//echo '<a href=http://noticias.laprensa.com.ni/productos><img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/anuncioprensaclub1.svg" style="max-width:100%;margin-top:10px;" alt=""> `</a>';
?>
</div><!-- end of #content-archive -->


<?php //my_pagination(); ?>
<?php get_sidebar('prensaclub'); ?>

<div class="home-728x90" style="margin-left:135px;">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6970273280466483";
/* nica-728x90banner */
google_ad_slot = "4717436669";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<?php removeQueryFilter(); ?>
<?php //get_sidebar(); ?> 

<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-ad-widget-nacionales-bottom-728x90.php'); echo ""; } ?>

<?php get_footer(); ?>
