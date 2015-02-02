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
    
/* espectaculo slots */
googletag.defineSlot('/11648707/Espectaculo-Left-160x600px', [160, 600], 'div-gpt-ad-1403212557668-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Espectaculo-Right-160x600px', [160, 600], 'div-gpt-ad-1403212557668-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Espectaculo-Top-728x90px', [728, 90], 'div-gpt-ad-1403212557668-6').addService(googletag.pubads());
googletag.defineSlot('/11648707/Espectaculo-Top-270x90', [270, 90], 'div-gpt-ad-1403212557668-4').addService(googletag.pubads());
googletag.defineSlot('/11648707/Espectaculo-Top-300x250px', [300, 250], 'div-gpt-ad-1403212557668-5').addService(googletag.pubads());
googletag.defineSlot('/11648707/Espectaculo-Sidebar-300x250px', [300, 250], 'div-gpt-ad-1403212557668-3').addService(googletag.pubads());
googletag.defineSlot('/11648707/Espectaculo-bottom-728x90px', [728, 90], 'div-gpt-ad-1403212557668-0').addService(googletag.pubads());

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
        include(STYLESHEETPATH . '/espectaculo-page-wing-ads.php');
        include(STYLESHEETPATH . '/banner-ad-widget-espectaculo-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-espectaculo-270x90.php');
}            

?>

<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>


<?php

echo '<div id="content-archive" class="' . implode( ' ', responsive_get_content_classes() ) . '">';

$esp_slider_cats = array(65427,1148,3637,64847,64846,64848);
$esp_img_widths = array(210,160,140,130,210,160);
$dest_count = 0;
foreach ($esp_slider_cats as $esp_sl_cat)
{
$args = array( 'post_type' => 'post', 'cat' => $esp_sl_cat, 'posts_per_page' => 1, 'meta_key'=> '_thumbnail_id', 'meta_query' => array(array('key' => 'destacado','value' => true,'type' => 'BOOLEAN')), 'post_status' => 'publish' );
add_filter('posts_clauses', 'filterEdiciones');
$esp_query = new WP_Query( $args );
//removeQueryFilter();
if( $esp_query->have_posts() ) 
{
	while ( $esp_query->have_posts() )
	{
		$esp_query->the_post();
//$myposts = get_posts( $args );
//var_dump($myposts);
//foreach ( $myposts as $post )
//{
//        setup_postdata( $post );
		$esp_car_post = '';
		$esp_car_post_horiz = '';
	        $category = get_the_category();
if ($category[0]->cat_ID == 26704)
{
	$themaincat = $category[1]->cat_ID;
	$single_cat_title = $category[1]->cat_name;
}
else
{
	$themaincat = $category[0]->cat_ID;
	$single_cat_title = $category[0]->cat_name;
}
//	        $themaincat = $category[0]->cat_ID;
//	        $single_cat_title = $category[0]->cat_name;
	        $cat_url = '/' . remove_accents(strtolower($single_cat_title));
	        $title = the_title_attribute('echo=0');
	        $post_url = get_permalink($post->ID);
	        $margin_right = ($dest_count == 4) ? 'margin-right:4px;' : 'margin-right:10px;';
	        $feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' );
	        $feat_image = $feat_image_array[0];
$img_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$image = su_image_resize( $img_url, $esp_img_widths[$dest_count], 217 );
$feat_image_horiz = $image['url'];
	        $esp_car_post .= '<div style="position:relative;float:left;width:240px;">';
	        $esp_car_post .= '<div style="position:relative;max-width:300px;margin-top:0px;margin-bottom:0px;">' . PHP_EOL . '<a href="' . $post_url . '" title="' . $title . '"><img src="' . $feat_image . '" alt="' . $title . '"></a>' . PHP_EOL;
	        $esp_car_post .= '</div>';
	        $esp_car_post .= '<a href="' . $cat_url . '"><h5 style="background: rgba(0, 0, 0, 0.5);border-radius:0;opacity: 1;color:#fff;position:absolute;bottom:0;right:0;margin-bottom:0px;padding: 5px 15px 0px 15px;height:35px;z-index:10;font-family:Open Sans;font-size:1.3em;font-weight:100;line-height:1.5em;">' . $single_cat_title . '</h5></a>';
	        $esp_car_post .= '</div>' . PHP_EOL;
		$esp_car_posts[] = $esp_car_post;
	        $esp_car_post_horiz .= '<li><div style="position:relative;float:left;width:' . $esp_img_widths[$dest_count] . 'px;">';
	        $esp_car_post_horiz .= '<div style="position:relative;max-width:300px;margin-top:0px;margin-bottom:0px;">' . PHP_EOL . '<a href="' . $post_url . '" title="' . $title . '"><img src="' . $feat_image_horiz . '" alt="' . $title . '"></a>' . PHP_EOL;
	        $esp_car_post_horiz .= '</div>';
	        $esp_car_post_horiz .= '<a href="' . $cat_url . '"><h5 style="background: rgba(0, 0, 0, 0.5);border-radius:0;opacity: 1;color:#fff;position:absolute;bottom:0;right:0;margin-bottom:0px;padding: 5px 15px 0px 15px;height:35px;z-index:10;font-family:Open Sans;font-size:.7em;font-weight:100;line-height:1.5em;">' . $single_cat_title . '</h5></a>';
	        $esp_car_post_horiz .= '</div></li>' . PHP_EOL;
		$esp_car_posts_horiz[] = $esp_car_post_horiz;
	        $dest_count++;
	        //wp_reset_postdata();
	}

removeQueryFilter();
//echo '</div><div style="clear:both;"</div>';
}
}

$max_posts = 9;
$right_col_start = 5;
$right_col_pix = 1;
//$category = get_the_category(); 
//$themaincat = $category[0]->cat_ID;
//$single_cat_title = $category[0]->cat_name;
$themaincat = 22;
$single_cat_title = "Espectáculo";

$max_width = 'max-width:100%;';
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); 

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
		//$write_comments = writeComments('white', $post->ID);
/*
	$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
	if ( comments_open() ) {
		if ( $num_comments == 0 ) {
			$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/comentarionulo.svg" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios');
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/comentario.svg" style="max-width:100%;border:0px solid #fff;" alt=""> ' . $num_comments . ' Comentarios');
		} else {
			$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/comentariodoble.svg" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario');
		}
		$write_comments = '<a style="color:#fff;" href="' . get_comments_link() .'">'. $comments.'</a>';
	} else {
	$write_comments =  __('Comments are off for this post.');
	}
*/
		if ( has_post_thumbnail() )
		{
			$image_info = wp_get_attachment_metadata( get_post_thumbnail_id($post->ID) );
			$img_width = $image_info['width'];
			$img_height = $image_info['height'];
			$feat_post[] = $post->ID;
			$rel_posts = explode(',', get_post_meta($post->ID, '_yyarpp', true));
			foreach ($rel_posts as $rel_post)
			{
				$rel_post_meta[$rel_post]['edicion'] = get_post_meta($rel_post, 'edicion', true);
				$rel_post_meta[$rel_post]['peso'] = get_post_meta($rel_post, 'peso', true);
			}
$args = array(
	'posts_per_page'   => 1,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post__in'          => $rel_posts,
	'meta_key'         => '_thumbnail_id',
	'post_type'        => 'post',
	'post_status'      => 'publish',
);

 $posts_array = get_posts( $args );
//var_dump ($args);
//var_dump($posts_array);
foreach ($posts_array as $other_post)
{
	setup_postdata($other_post);
$other_title = get_doap_limit_chars($other_post->post_title,31,1);
$other_excerpt = get_doap_limit_chars($other_post->post_excerpt, 51,1);
$other_ID = $other_post->ID;
$other_url = get_permalink($other_ID);
$vid_overlay = (get_post_meta($rel_post, '_video_thumbnail', true)) ? '<div style="width:300px;position:absolute;bottom:0;left:0;height:32px;background: rgba(0, 0, 0, 0.5);border-radius:0;opacity: 1;"><div style="position:relative;float:left;padding:5px 35px 0 20px;"><img src="/images/ver-video.png" height="20" width="20"></div><div style="font-family:Arial;font-size:1em;text-align:left;color:#fff;padding-top:5px;">Ver video</div></div>' : '';
//echo "<br> ID = $other_ID     title = $other_title    excerpt = $other_excerpt    url = $other_url  <br>";
$esp_post .= '<div style="width:300px;">';
$esp_post .= do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="' . $other_url . '"><div class="title-left">'.mb_strtoupper($other_title).'</div></a>[/doap_heading]'); 
	$other_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($other_ID), 'center-top-300x300' ); 
	$other_image = $other_image_array[0];
	$esp_post .= '<div style="position:relative;width:300px;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL . '<a href="' . $other_url . '"><img src="' . $other_image . '" width="300"></a>' . $vid_overlay . '</div>' . PHP_EOL;
	$esp_post .= '<div class="esp-other-excerpt" style="margin-top:5px;">' . $other_excerpt . '</div>';
	$esp_post .= '</div>';
//echo $esp_post;
}

			if ($img_height > $img_width)
			{
				$right_col_start = 4;
				$right_col_pix = 1;
				$max_posts = 9;
				$gal_pics = 5;
				$pix_class = 'catpic-vert';
				$pix_size = 'responsive-450';
				$pix_width = '420px;position:relative;float:left;';
				$pix_img_width = '450px;';
				//$story_pre = '<div class="su-column su-column-size-2-3" style="width:420px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
				$story_pre = '<div class="su-column su-column-size-2-3"><div class="su-column-inner su-clearfix"></div>';
				$story_post = '';
$esp_car_div .= '<script src="/tst/bxslider-4-master/jquery.bxslider.min.js"></script><link href="/tst/bxslider-4-master/jquery.bxslider.css" rel="stylesheet" /><div class="esp-car-vert"><div id="slider1"><ul class="bxslider">';
$esp_car_post = '';
$esp_car_count = 1;
foreach ($esp_car_posts as $esp_car_post)
{
	if ($esp_car_count == 1) $esp_car_div .= '<li><div class="esp-car-page-1" style="width:240px;height:480px;">';
	if ($esp_car_count == 4) $esp_car_div .= '</div></li><li><div class="esp-car-page-2" style="width:240px;height:480px;">';
	$esp_car_div .= $esp_car_post; 
	$esp_car_count++;
}
$esp_car_div .= '</div></li></ul></div></div>';
//$esp_car_div .= '<div class="controls"><a href="#" class="prev-slide"><img src="/images/small-prev.png"></a><a href="#" class="next-slide"><img src="/images/small-next.png"></a></div>';
//$esp_car_div .= '<script src="/tst/jquery-1.6.min.js"></script>';
$esp_car_div .=<<<EOD
<style>
.bx-controls {display:none;}
.bx-pager {display:none;}
</style>

<div class="outside">
<div id="des-dot" class="twodots" style="width:185px;"></div><div id="slider-prev" style="display:table-cell;width:33px;height:22px;"></div> <div id="slider-next" style="display:table-cell;width:23px;height:22px;"></div>
</div>
<script>
jQuery(document).ready(function($){
  $('.bxslider').bxSlider();
  infiniteLoop: true
});
jQuery('.bxslider').bxSlider({
  nextSelector: '#slider-next',
  prevSelector: '#slider-prev',
  nextText: '<img src="/images/small-next.png">',
  prevText: '<img src="/images/small-prev.png" style="margin:0 5px;">'
});
</script>
EOD;



			}
			else
			{
				$right_col_start = 3;
				$right_col_pix = 0;
				$max_posts = 6;
				$gal_pics = 7;
				$pix_orient = 'horizontal';
				$pix_class = 'catpic-hori';
				$pix_size = 'Video-Poster-640x360';
				$pix_width = '100%;';
				$pix_img_width = '657px;';
				$story_pre = '<div style="clear:both;">';
				//$story_post = '</div><div class="su-column su-column-size-2-3" style="width:420px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
				//$story_post = '</div><div class="su-column su-column-size-2-3"><div class="su-column-inner su-clearfix"></div>';
				$story_post = '</div>';
			}
		}
		include(STYLESHEETPATH . '/templates/esp-cat-feat-img-extract.php');
		if ( get_post_gallery() ) 
		{
			echo '<div id="esp-gal">';
			$gallery = get_post_gallery( get_the_ID(), false );
			$gal_short = '[gallery size="thumbnail" link="file" columns="' . $gal_pics . '" ids='. $gallery['ids'] . ']';
			echo do_shortcode($gal_short);		
			/* Loop through all the image and output them one by one */
			/*
			foreach( $gallery['src'] AS $src )
			{
				echo '<img src="' . $src . '" class="img-esp-gal" alt="Imagen de Galeria">';
			}
			*/
			echo '</div>';
	//		var_dump($gallery);
		}

	}
	if ($pix_orient == 'horizontal')
	{

?>
<div style="clear:both;"></div>
	<div class="wrap">
		<div id="slider2" class="slider">
			<ul>
<?php
/*
				<li><div style="width:210px;height:217px;background:#2aa198;"> 1</div></li>
				<li><div style="width:160px;height:217px;background:#268bd2;"> 2</div></li>
				<li><div style="width:140px;height:217px;background:#6c71c4;"> 3</div></li>
				<li><div style="width:130px;height:217px;background:#d33682;"> 4</div></li>
				<li><div style="width:210px;height:217px;background:#dc322f;"> 5</div></li>
				<li><div style="width:160px;height:217px;background:#cb4b16;"> 6</div></li>
*/
foreach ($esp_car_posts_horiz as $horiz_car)
{
	echo $horiz_car;
}
?>
			</ul>
		</div>
		<div class="controls" style="margin:10px 0;">
			<div id="des-dot" class="twodots esp-car" style="width:599px;"></div>
			<div style="display:table-cell;width:33px;height:22px;"><a href="#" class="prev-slide"><img src="/images/small-prev.png" style="margin:0 5px;"></a></div>
			<div style="display:table-cell;width:23px;height:22px;"><a href="#" class="next-slide"><img src="/images/small-next.png"></a></div>
		</div>
	</div>

	<script src="/tst/lemmon-slider.js"></script>
	<script>
	jQuery(document).ready(function(){

		// slider 1
		jQuery( '#slider2' ).lemmonSlider({
			infinite: true
		});

	});
	</script>
	<style type="text/css" media="screen">
	.wrap {width:660px;}
	body div.slider    { overflow:hidden; position:relative; width:100%; height:217px !important; }
	body div.slider ul { margin:0; padding:0; height:217px; }
	body div.slider li { float:left; list-style:none; margin:0 5px 0 0; }
	body div.slider li { text-align:center; line-height:217px; font-size:25px; }
	</style>
<div style="clear:both;"></div>
<div class="su-column su-column-size-2-3"><div class="su-column-inner su-clearfix"></div>
<?php
	}

}
else
{
	$story_pre = '<div class="su-column su-column-size-2-3""><div class="su-column-inner su-clearfix"></div>';
	echo '<div> No hay notas en esta categoria </div>'; 
	echo $story_pre;
	$max_posts = 9;
}
}
wp_reset_query();
global $wp_query;
//$args = array_merge( $wp_query->query_vars, array( 'meta_query' => array( array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ) ), 'post__not_in' => $feat_post ) );
$args = array_merge( $wp_query->query_vars, array( 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post ) );
//$args = array( 'post__not_in' => $feat_post );
//$args = array_merge( $wp_query->query_vars, array( 'post__not_in' => array(get_option( 'sticky_posts' ), $feat_post ) ) );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
//var_dump($query);
//query_posts( $args );
//var_dump($args);
//var_dump($the_query);
//var_dump($feat_post);
$even = 0; 
	if( $the_query->have_posts() ) 
	{
//var_dump($query);
//		get_template_part( 'deportes-loop-header' ); 
//echo 'max posts = ' . $max_posts;
		while( $the_query->have_posts() && $even < $max_posts )
		{ 
			$the_query->the_post();

//var_dump($query);
$even++;
$float='left';
echo '<div style="clear:both;"></div>';
if ($paged > 1 && $even == 1)
{
	$story_pre = '<div class="su-column su-column-size-2-3"><div class="su-column-inner su-clearfix"></div>';
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

if ($gid > 10000000)  
{
	include(STYLESHEETPATH . '/middle-300x250-loggedin.php');
}
else
{
	echo '<div id="esp-ad" style="width:300px;border:1px solid black;z-index:1000;">';
	include(STYLESHEETPATH . '/ad-300x250-category-page-center-espectaculo.php');
	echo "</div>"; 
} 

}
}

if ($even == $right_col_start)
{
	echo '</div>';
	//echo '<div class="su-column su-column-size-1-3" style="width:229px;position:relative;float:right;margin:0 0 0 0;">';
	echo '<div class="su-column su-column-size-1-3">';
	$max_width = 'width:100%;';
	if ($pix_orient != 'horizontal') echo $esp_car_div;
}
 
echo '<div style="clear:both;"></div>';
if ($even == 1 && $pix_orient == 'horizontal' && $paged < 2)
{
			$pix_class = 'cat-dest-mini';
			$pix_size = 'caricatura-home';
			$pix_width = '210px;';
			$pix_img_width = '210px;';

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $pix_size );
$feat_image = $feat_image_array[0];
$post_url = get_permalink($post->ID);
$sec_story_img = '<div style="position:relative;float:left;"><a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . 'border: 1px solid #ccc;margin-right:5px;margin-bottom:2px;"></a></div>' . PHP_EOL;
$sec_story_title = '<a href="' . $post_url . '" title="Haz clic aqui para leer el nota completo."><div class="su-heading su-heading-style-modern-1-blue su-heading-align-left fp-title-bar" style="font-size:20px;margin-bottom:0px;"><div class="su-heading-inner" style="display:inline;">' . ucfirst(get_the_title()) . '</div></div></a>';
echo '<div style="height:10px;clear:both;"></div>';
echo '<div class="cat-sec-dest" style="width:100%;">' . $sec_story_img . $sec_story_title;
?>
 <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a>
<?php
$theexcerpt = get_doap_excerpt(30,1); 
$sec_story_excerpt = '<div class="category-excerpt" style="padding:4px;text-align:justify;">' . $theexcerpt . '</div>' . PHP_EOL;

echo $sec_story_excerpt . '</div>';
echo '<div style="clear:both;"></div>';
        //echo '<div style="margin:50px auto 50px auto;width:300px;position:relative;">';
?>

                <?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { echo "<div style=border:1px solid black;z-index:10000;>"; include(STYLESHEETPATH . '/ad-300x250-category-page-center-espectaculo.php'); echo "</div>"; } ?>


<?php
        //echo '</div>';
}
else
{
responsive_entry_before(); 
echo '<div id="su-post-' . get_the_ID() . '" style="position:relative;">';
responsive_entry_top(); 
	$theexcerpt = get_doap_excerpt(30,1);
	$theexcerpt = '<div class="category-excerpt" style="padding:4px;text-align:justify;">' . $theexcerpt . '</div>' . PHP_EOL;
$thepermalink = get_the_permalink();
echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>');
?>

 <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a>

				<div class="post-entry">
<?php $gmt_timestamp = get_post_time('U', true); 
if (!$right_col_pix && $even >= $right_col_start)
{
	$show_img = 0;	
}
else
{
	$show_img = 1;	
}
if ( has_post_thumbnail() && $show_img )
{
$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-300' );
$post_url = get_permalink($post->ID);
$feat_image = $feat_image_array[0];
echo '<div style="border: 1px solid #ccc;' . $max_width .'">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"style="width:100%"></a>' . PHP_EOL;
echo '</div>';
}
 ?> 
<?php
echo $theexcerpt;
					wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
					?>
				</div>
				<!-- end of .post-entry -->

				<?php //get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>
		<?php
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
<?php echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/espectaculo/page/2"><div class="title-left">MÁS EN ' . mb_strtoupper($single_cat_title) . '</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); ?>

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
<?php get_sidebar('espectaculo'); ?> 

<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-ad-widget-espectaculo-bottom-728x90.php'); echo ""; } ?>

<?php get_footer(); ?>
