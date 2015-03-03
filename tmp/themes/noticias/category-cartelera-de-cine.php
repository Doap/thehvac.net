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
<style>
 .button { background:#05A1F5 ! important; }
</style>
<script type='text/javascript'>
googletag.cmd.push(function() {

/* home slots */
googletag.defineSlot('/11648707/Portada-Bottom-300x250px', [300, 250], 'div-gpt-ad-1403198971774-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Top-728x90', [728, 90], 'div-gpt-ad-1403199951031-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Top-270x90', [270, 90], 'div-gpt-ad-1403223429448-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Top-300x250px', [300, 250], 'div-gpt-ad-1403198971774-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Bottom-728x90', [728, 90], 'div-gpt-ad-1403199951031-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Left-160x600', [160, 600], 'div-gpt-ad-1403200779714-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Right-160x600', [160, 600], 'div-gpt-ad-1403200779714-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Middle-728x90', [728, 90], 'div-gpt-ad-1403199951031-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/120x600-Top', [120, 600], 'div-gpt-ad-1403371468819-0').addService(googletag.pubads());

/* botones 1-5 sidebar slots */
googletag.defineSlot('/11648707/Portada-boton-1-300x120', [300, 120], 'div-gpt-ad-1403222233029-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-2-300x120', [300, 120], 'div-gpt-ad-1403222233029-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-3-300x120', [300, 120], 'div-gpt-ad-1403222233029-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-4-300x120', [300, 120], 'div-gpt-ad-1403222233029-3').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-5-300x120', [300, 120], 'div-gpt-ad-1403222233029-4').addService(googletag.pubads());

googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>

<?php
global  $wpdb; $user_id = get_current_user_id(); $qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'"; $avalidgoogleid = $wpdb->get_results( $qry ); foreach ( $avalidgoogleid as $avalidgoogleid ) { $gid = $avalidgoogleid ->identifier; $uemail  = $avalidgoogleid ->email; $websiteurl = $avalidgoogleid ->websiteurl; }
if ($gid > 10000000 )  {
        include(STYLESHEETPATH . '/page-wing-ads-loggedin.php');
        include(STYLESHEETPATH . '/top-loggedin.php');
} else {
        include(STYLESHEETPATH . '/page-wing-ads.php');
        include(STYLESHEETPATH . '/banner-ad-widget-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-home-270x90.php');
}
responsive_wrapper(); // before wrapper container hook 
?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook 
responsive_in_wrapper(); // wrapper hook 
echo '<div id="content-archive" style="margin-top:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';
$max_posts = 9;
//$category = get_the_category(); 
$themaincat = 23782;
$single_cat_title = 'Cartelera de cine'; 
$single_cat_url = strtolower(str_replace(' ', '-', $single_cat_title)); 
$sub_cat_title = 'CARTELERA DE HOY';
$max_width = 'max-width:100%;';
//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="twodots"></div></a>[/doap_heading]'); 
echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.$single_cat_url.'"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');

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
			if ( has_post_thumbnail() )
			{
				$image_info = wp_get_attachment_metadata( get_post_thumbnail_id($post->ID) );
			$img_width = $image_info['width'];
			$img_height = $image_info['height'];
			$feat_post[] = $post->ID;
			$pix_orient = 'horizontal';
			$pix_class = 'catpic-hori';
			$pix_size = 'Video-Poster-640x360';
			$pix_width = '100%;';
			$pix_img_width = '657px;';
			$story_pre = '<div style="clear:both;"></div>';
	//		$story_post = '</div><div class="su-column" style="width:100%;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
			$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $pix_size );
			$post_url = get_permalink($post->ID);
			$feat_image = $feat_image_array[0];
	
		//$theexcerpt = get_doap_excerpt(30,1);
			$theexcerpt = $post->post_excerpt;
			$theexcerpt = '<div class="category-excerpt" style="line-height:1;width:100%;position:relative;float:left;color:#fff;font-size:12pt;display:table;padding:4px 4px 4px 20px;">' . $theexcerpt . '</div>' . PHP_EOL;
			echo $story_pre;
			echo '<div class="' . $pix_class . '" style="position:relative;float:left;border: 1px solid #ccc;max-width:' . $pix_width . '">' . PHP_EOL;
			echo '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . '">' . PHP_EOL;
			echo '<div style="position:absolute;border:0px;margin:0px;display:table;bottom:0px;left:0px;height:auto;width:100%;max-width:100%;color:#fff;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;">' . $theexcerpt;
	//		echo '<div style="float:right;margin:0px 5px 5px 65px;text-align:right;padding:5px;color:#fff;">';
	//		echo $write_comments;
			//echo '</div></div></a></div></div>';
			echo '</div></a></div><style>.title-archive {display:none;}</style>';
	//		echo $theexcerpt;
			echo $story_post;
			}
		}
	}
}
//var_dump($the_query);
//echo do_shortcode('[doap_slider source="category: '.$themaincat.'" limit="1"  autoplay="0" arrows="no" width="640" height="360" link="post" mousewheel="no" pages="no" class="deportes-slider"]');
include(STYLESHEETPATH . '/templates/car-posts.php');
?>
<div style="width:100%">
<div style="position:relative;width:100%;color:#000;font-size:1.9em;font-weight:700;padding:8px 0px 8px 8px;background-color:#ccc;margin-bottom:4px;">Próximamente</div>
<?php echo do_shortcode('[doap_carousel source="category: 64448" limit="5" items="5" link="post" width="500" height="160" mousewheel="no" autoplay="0" speed="800" titles="no" class="cart-prox"]'); ?>
</div>

</div><!-- end of #content-archive -->


<?php //my_pagination(); ?>
<?php get_sidebar('cartelera-del-cine'); ?>
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

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

<?php //echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); ?>
<?php get_footer(); ?>
