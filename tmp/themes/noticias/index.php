<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
exit;
}

/**
* Index Template
*
*
* @file           index.php
* @package        Responsive
* @author         Emil Uzelac
* @copyright      2003 - 2013 ThemeID
* @license        license.txt
* @version        Release: 1.0
* @filesource     wp-content/themes/responsive/index.php
* @link           http://codex.wordpress.org/Theme_Development#Index_.28index.php.29
* @since          available since Release 1.0
*/

get_header(); 
$archive_year  = get_the_time('Y'); 
$archive_month = get_the_time('m'); 
$archive_day   = get_the_time('d'); 
//$feat_post[] = 213;
$feat_post[] = 1159585;
$laprensa_home = 1;
?>

<?php include(STYLESHEETPATH . '/home-adblock.php'); ?>

<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>
<div id="content" class="grid col-620">
<?php 
echo do_shortcode('[doap_spacer size="1" class="homespace"]');  ?>
<?php
//get home extra home content like livestream and marcador
$post_id = 213;
$queried_post = get_post($post_id);
echo do_shortcode($queried_post->post_content); 
?>
<?php
echo '<div id="tagbox">';
echo '<div style="color:#34669b;z-index:99;height: 20px;float: left;padding-left:0px;padding-right:5px;left:0px;position:relative;top:0px;" id=destacados-sidebar><div style="padding-left:5px;padding-top:5px;font-size:.8em;width:110px;position:relative;float:left;color:#000;"><img style="-webkit-user-select: none;height:12px;width:12px;background-color:#f5f5f5;" src="http://laprensa13.doap.us/images/tag.png"> Temas del dia:</div>';
echo '<div style="color:#34669b;position:relative;float:right;padding-left:0px;padding-top:5px;padding-right:0px;" id="toptagcloud">';

$how_many_posts = 30;
$args = array(
'post_type' => 'post', 
'post_status' => 'publish',
'posts_per_page' => $how_many_posts,
'orderby' => 'date',
'order' => 'DESC',
);
// get the last $how_many_posts, which we will loop over
// and gather the tags of
query_posts($args);
//
$temp_ids = array();
while (have_posts()) : the_post(); 
// get tags for each post
$posttags = get_the_tags();
if ($posttags) {
foreach($posttags as $tag) {
    // store each tag id value
    $temp_ids[] = $tag->term_id;
}
}
endwhile;
// we're done with that loop, so we need to reset the query now
wp_reset_query();
$id_string = implode(',', array_unique($temp_ids));
// These are the params I use, you'll want to adjust the args
// to suit the look you want    
$args = array(
'smallest'  => 12, 
    'largest'   => 12,
    'unit'      => 'px', 
    'number'    => 7,  
    'format'    => 'flat',
    'separator' => " - \n",
    'orderby'   => 'count', 
    'order'     => 'DESC',
    'include'   => $id_string,  // only include stored ids
    'link'      => 'view', 
    'echo'      => true,

);

echo wp_tag_cloud( $args ) . '</div>';

echo '</div>';

echo '</div>';
echo '<div style="clear:both;"></div>';
?>
<div class="su-row">
<div class="su column su-column-size-3-4" style="width:100%">
<div id="left-col">
<?php
echo do_shortcode('[doap_slider source="category: 35752" limit="3" autoplay="0" arrows="yes" link="post" width="640" height="360" pages="no" mousewheel="no" autoplay="8000" speed="400" meta="edicion" class="slider-home  "]');
echo do_shortcode('[doap_spacer size="2"]');

global $wp_query;
include(STYLESHEETPATH . '/templates/deparamentales.php');
$max_posts = 5;
$args = array( 'post_type' => 'post', 'posts_per_page' => $max_posts, 'meta_query' => array( array( 'key' => 'portada', 'value' => 1, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
$even = 0; 
	if( $the_query->have_posts() ) 
	{
		get_template_part( 'index-loop-header' ); 
		while( $the_query->have_posts() && $even < $max_posts )
		{ 
			$the_query->the_post();
$even++;
$category = get_the_category(); 
$themaincat = $category[0]->cat_ID;
$single_cat_title = $category[0]->cat_name;
$single_cat_slug= $category[0]->slug;
$show_cat_in_comments = 1;
if ($even == 4)
{
	echo '<div class="mobile-clear"></div>';
	echo '<div id="ad-120x600">';
?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/ad-120x600-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-120x600-category-page-center.php'); echo ""; } ?>

<?php
	echo '<div class="mobile-clear"></div>';
	echo '</div>';
	$show_img = 1;
}
if ($even == 2)
{
//	echo '<div style="width:100%;height:40px;background-color:#ccc;"> MARCADOR COMES NEXT </div>';
	echo '<div style="clear:both;"></div>';
	$marcador_key = 'activo_en_portada';
	$args = array(
        'post_type' => 'marcador',
        'post_status' => 'publish',
//      'meta_key' => 'activo_en_deportes',
//      'meta_value' => 1,
        'meta_query' => array(
                array(
                'key' => $marcador_key,
                'value' => 1,
                'compare' => '='
                     )
        ),
        'posts_per_page' => 1
);
$marc_query = new WP_Query( $args );
if( $marc_query->have_posts() )
{
	echo '<div style="padding:4px;">';
	include(STYLESHEETPATH . '/marcadorhome.php');
	echo '</div>';
?>
<script type='text/javascript'>
googletag.defineSlot('/11648707/Marcador-Portada-529x70', [529, 70], 'div-gpt-ad-1403883993058-0').addService(googletag.pubads());
<!-- Marcador-Portada-529x70 -->
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1403883993058-0'); });
</script>
<?php
}
	echo '<div style="clear:both;"></div>';
	echo '<div id="story-2" style="margin:10px 0px 10px 0px;width:100%;clear:initial;">';
	echo '<div style="margin:0px 4px 0px 4px;width:300px;position:relative;float:left;">'; ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-category-page-center.php'); echo ""; } ?>


<?php	
	echo '</div><div class="mobile-clear"></div>';
	echo '<div style="padding:4px;">';
//	echo '<div>' . var_dump($the_query) . '</div>';
	include(STYLESHEETPATH . '/templates/normal.php');
	echo '</div>';
	echo '</div>';
}
if ($even > 3)
{
	echo '<div id="story-no-clear" style="margin:10px 0px 10px 0px;width:100%;max-width:376px;clear:initial;">';
	echo '<div style="padding:4px;">';
	$max_width = 'width:376px;';
	include(STYLESHEETPATH . '/templates/normal.php');
	echo '</div>';
	echo '</div>';
}
if ($even == 200)
{
?>

  
<div style="clear:both;"></div>
<div class="su-spacer" style="height:10px;"></div>

<div id="middle-home-ad-468x60">
</div> 
 
<?php
}
if ($even == 3)
{
?>
<div style="clear:both;"></div>
<div class="su-spacer" style="height:10px;"></div>
<?php
//echo $even;
echo $departamentales_section;
echo '<div class="su-spacer" style="height:10px;"></div>';
}
if ($even == 100)
{
echo '<div id="ipad-only" style="display:none;" class="centercol">';
echo do_shortcode('[[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="/category/noticias/deportes">DEPORTES</a>[/doap_heading][/doap_animate]');
?>
</div> 

<div style="display:none;" id="middle-home-ad-468x60">
</div>
<?php
}
$show_comments = 1;
if ($even != 2)
{
	if ($even < 4)
	{
		include(STYLESHEETPATH . '/templates/normal.php');
	}
}
		}
	}
	else 
	{
	//	var_dump($the_query);
		get_template_part( 'loop-no-posts' );
	}
?>

<div style="clear:both;"></div>

</div>
</div>
<div class="su column su-column-size-1-4">
<?php
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="/deportes"><div id="des-sec" class="title-left">DEPORTES</div><div id="des-dot" class="twodots"></div></a>[/doap_heading]');

$max_posts = 3;
$args = array( 'post_type' => 'post', 'posts_per_page' => $max_posts, 'cat' => 17, 'meta_key' => '_thumbnail_id', 'post__not_in' => $feat_post );
add_filter('posts_clauses', 'filterEdiciones');

$the_query = new WP_Query( $args );
//var_dump($the_query);
include(STYLESHEETPATH . '/templates/teaser-home-center-col.php');

echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="/reportajes-especiales"><div class="title-left">REPORTAJE</div><div class="twodots"></div></a>[/doap_heading]');
$max_posts = 1;
$args = array( 'post_type' => 'post', 'posts_per_page' => $max_posts, 'cat' => 63721, 'meta_key' => '_thumbnail_id', 'post__not_in' => $feat_post );
//add_filter('posts_clauses', 'filterEdiciones');
//add_action('pre_get_posts', 'alter_query_edicion');
$the_query = new WP_Query( $args );
//var_dump($the_query);
include(STYLESHEETPATH . '/templates/teaser-home-center-col.php');
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="/vida"><div id="des-sec" class="title-left">ESPECTACULO</div><div id="des-dot" class="twodots"></div></a>[/doap_heading]');
$max_posts = 4;
$args = array( 'post_type' => 'post', 'posts_per_page' => $max_posts, 'cat' => 22, 'meta_key' => '_thumbnail_id', 'post__not_in' => $feat_post );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
include(STYLESHEETPATH . '/templates/teaser-home-center-col.php');
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="/vida"><div id="des-sec" class="title-left">TECNOLOGÍA</div><div id="des-dot" class="twodots"></div></a>[/doap_heading]');
$max_posts = 4;
$args = array( 'post_type' => 'post', 'posts_per_page' => $max_posts, 'cat' => 991, 'meta_key' => '_thumbnail_id', 'post__not_in' => $feat_post );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
include(STYLESHEETPATH . '/templates/teaser-home-center-col.php');
?>
</div>
</div>


</div><!-- end of #content -->

<?php get_sidebar('index'); ?>

<div style="clear:both"></div>

<?php echo do_shortcode('[doap_spacer size=10]'); ?>

<div style="clear:both"></div>
<div class="destacados-section">

<div class="mobile-hide">
<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-midpage-index-728x90.php'); echo ""; } ?>
</div>

<?php echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="/destacados"><div class="title-left">DESTACADOS</div><div id="des-dot" class="twodots"></div></a>[/doap_heading]'); ?>

<?php
$args = array( 'post_type' => 'post', 'posts_per_page' => 4, 'meta_key'=> '_thumbnail_id', 'meta_query' => array(array('key' => 'bloque_destacado_portada','value' => true,'type' => 'BOOLEAN')), 'post_status' => 'publish' );
add_filter('posts_clauses', 'filterEdiciones');
$myposts = get_posts( $args );
//var_dump($myposts);
$dest_count = 0;
foreach ( $myposts as $post )
{	
	setup_postdata( $post );
	$dest_count++;
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
	$cat_url = '/' . remove_accents(strtolower($single_cat_title));
	$title = the_title_attribute('echo=0');
	$post_url = get_permalink($post->ID);
	$margin_right = ($dest_count == 4) ? 'margin-right:4px;' : 'margin-right:10px;';
	echo '<div class="dest-story" style="position:relative;float:left;min-height:378px;width:240px;' . $margin_right . '">';
	echo '<div style="border: 1px solid #ccc;margin-bottom:10px;min-height:378px;">';
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' ); 
	$feat_image = $feat_image_array[0];
	echo '<div style="position:relative;max-width:300px;margin-top:0px;margin-bottom:0px;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
	echo '</div>';
	echo '<a href="' . $cat_url . '"><div style="background-color:#4c4c4c;color:#fff;position:absolute;top:1px;margin:0 auto;padding: 5px 15px 0px 15px;height:20px;z-index:10;font-family:Arial,Helvetica,sans-serif;font-size:1.125em;font-weight:700;line-height:1.0em;">' . $single_cat_title . '</div></a>';
	echo '<div class="destacados-titles" style="padding:4px;font-weight:700;"><a href="' . $post_url . '">'. $title . '</a></div>' . PHP_EOL;
	echo '<div class="destacados-excerpt" style="padding:4px;">' . PHP_EOL;
	$theexcerpt = get_doap_excerpt(30);
	$theexcerpt = '<div style="text-align:justify;">' . $theexcerpt . '</div>' . PHP_EOL;
	echo $theexcerpt;
	//echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
	wp_reset_postdata();
}
removeQueryFilter();
echo '</div><div style="clear:both;"></div>';
?>

<div class="mobile-hide">
<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-bottom-index-728x90.php'); echo ""; } ?>
</div>
<div style="clear:both;"></div>
<?php 
echo '<div style="height:30px;"></div>';
echo '<div id="bottom-section">';
echo '<div style="clear:both;"></div>';
echo '<div class="su-row">';
echo '<div class="su-column su-column-size-2-3 suplementos-home-bottom" style="position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
include(STYLESHEETPATH . '/supl-sect.php');
echo '</div><div class="ipad-portrait-clear"></div>';
echo '<div class="su-column su-column-size-1-3 portada-home-bottom" style="width:270px;position:relative;float:right;margin:0 10px 0 0;">';
include(STYLESHEETPATH . '/portadaimpresa.php');
echo '</div>';


echo '<div class="su-row">';
echo '<div class="su-column ed-ant" style="position:relative;float:right;width:260px;margin:0 0 0 0;">';

include(STYLESHEETPATH . '/edicionesanteriores.php');

echo '</div>';

echo '<div id="magazine-ad" class="su-column su-column-size-2-3" style="position:relative;float:left;width:734px;"><div class="su-column-inner su-clearfix"></div>';

echo '<div style="height:50px;"></div>';
echo '<div id=magad style="border:1px solid #efefef"><a href=http://magazine.laprensa.com.ni>';
if ($gid > 10000000)  { include(STYLESHEETPATH . '/magazine-ad-loggedin.html'); } else { include(STYLESHEETPATH . '/magazine-ad.html'); echo ""; }
echo '</a></div>';
//echo '<div style="height:30px;"></div>';

echo '</div>';
echo '</div>';


echo '<div class="su-row">';
echo '<div class="su-column su-column-size-1-3 right-ad-home-bottom" style="position:relative;float:right;margin:0 0 0 0;">';

echo '<div style="margin:28px 20px auto 0px;">';
if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/bottom-300x250.php'); echo ""; } 
echo '</div>';

echo '</div>';
echo '<div class="su-column su-column-size-2-3 cartelera-home-bottom" style="position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
include(STYLESHEETPATH . '/cartelera.php');
echo '</div>';
echo '</div>';
?>
<div style="clear:both;"></div>

<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<div id="menubox1"> </div>
<div id="menubox2"> </div>
</div>
</div>
<?php 
get_footer(); ?>
