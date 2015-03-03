<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single Posts Template
 *
 *
 * @file           single.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/single.php
 * @link           http://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<div style="clear:both;"></div>
<?php include('page-wing-ads.php'); ?>
<?php include('banner-ad-widget.php'); ?>
<?php include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-ad-widget-270x90.php'); 
responsive_wrapper(); // before wrapper container hook 
echo '<div id="wrapper" class="clearfix">';
responsive_wrapper_top(); // before wrapper content hook 
responsive_in_wrapper(); // wrapper hook
?>
<div style="clear:both;"></div>

<div id="content" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">

<?php 
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
//$themaincat = $category[0]->cat_ID;
//$single_cat_title = $category[0]->cat_name;
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]');

echo do_shortcode('<div style="width:100%;height:40px;position:relative;align:right;float:right;border:1px solid #fff;padding:0px;margin:0px;"><div style="width:450px;float:right;">[hupso]</div></div>');
get_template_part( 'loop-header' );  

if( have_posts() ) 
{
	while( have_posts() )
	{
		the_post();
		responsive_entry_before(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php responsive_entry_top(); ?>
		<?php get_template_part( 'post-meta' ); ?>
		<div class="post-entry">
<?php
$home_meta_id = get_post_meta( $post->ID, 'en_casa', true );
$away_meta_id = get_post_meta( $post->ID, 'visitante', true );
$home_meta_array = get_term($home_meta_id, 'equipos', 'ARRAY_A');
$away_meta_array = get_term($away_meta_id, 'equipos', 'ARRAY_A');
$home_meta = $home_meta_array['name'];
$away_meta = $away_meta_array['name'];
//$home_logo = $home_team_thumb_id['0'];
$home_score_meta = get_post_meta( $post->ID, 'puntos_en_casa', true );
$away_score_meta = get_post_meta( $post->ID, 'puntos_visitante', true );
$game_title = ucfirst(get_the_title());
$game_status = get_doap_excerpt('10');
if ($home_score_meta > $away_score_meta)
{
	$home_color='background-color:#333;';
	$away_color='background-color:#606060;';
}
elseif ($home_score_meta < $away_score_meta)
{
	$home_color='background-color:#606060;';
	$away_color='background-color:#333;';
}
else
{
	$home_color='background-color:#333;';
	$away_color='background-color:#333;';
}
if ($home_meta_id)
{
wp_reset_query();
$args = array(
	'posts_per_page' => 1,
	'post_type' => 'logo',
//	'tag_id' => $away_meta_array['term_id']
//	'equipos' => $away_meta_array['term_id']
	'tax_query' => array(
        array(
            'taxonomy' => 'equipos',
            'field' => 'id',
            'terms' => $away_meta_array['term_id']
        ),
    )
);
$away_logos = new WP_Query( $args );
if( $away_logos->have_posts() ) 
{
while ( $away_logos->have_posts() )
{
	$away_logos->the_post();
	$away_team_logo_id = $post->ID;
	$away_team_thumb_id[] = get_post_thumbnail_id($away_team_logo_id);
}
}
else
{
	echo 'NO LOGOS FOUND';
//	var_dump($away_logos);
}
$away_logo = $away_team_thumb_id['0'];
$away_logo_thumb_array = wp_get_attachment_image_src( $away_logo, 'thumbnail' );
$away_logo_thumb = $away_logo_thumb_array[0];
$args = array(
	'posts_per_page' => 1,
	'post_type' => 'logo',
//	'tag_id' => $home_meta_array['term_id']
	'tax_query' => array(
        array(
            'taxonomy' => 'equipos',
            'field' => 'id',
            'terms' => $home_meta_array['term_id']
        ),
    )
);
wp_reset_query();
$home_logos = new WP_Query( $args );
if( $home_logos->have_posts() ) 
{
while ( $home_logos->have_posts() )
{
	$home_logos->the_post();
	$home_team_logo_id = $post->ID;
	$home_team_thumb_id[] = get_post_thumbnail_id($home_team_logo_id);
}
}
else
{
	echo 'NO LOGOS FOUND';
//	var_dump($home_logos);
}
$home_logo = $home_team_thumb_id['0'];
$home_logo_thumb_array = wp_get_attachment_image_src( $home_logo, '150,150' );
$home_logo_thumb = $home_logo_thumb_array[0];
echo '<div style="top:17px;position:relative;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/futbol-transparent.png" alt="futbol" width="22" height="22" class="alignleft size-thumbnail wp-image-1146384" /></div>';
echo '<div style="top:21px;left:-9px;position:relative;font-size:1.2em;font-weight:900;color:#fff;">'. $game_status . '</div>';
echo '<div id="scoreboard-strip" style="border:0px;max-width:100%;"></div>';
echo '<div style="clear:both;"></div>';
echo '<div class="shawn-marcador" style="width:100%;position:relative;float:left;border: 1px solid #ccc;">';
echo '<div class="shawn-marcador-inner" style="width:100%;height:80px;position:relative;float:left;">';
echo '<div style="text-align:center;line-height:5;width:130px;height:80px;color:#606060;font:Arial;font-size:22;font-weight:900;position:relative;float:left;">'. $home_meta . '</div>';
//echo '<div>'. $home_logo. '</div>';
echo '<div style="padding-right:4px;padding-left:4px;position:relative;float:left;width:89x;height:80px;"><img src="' . $home_logo_thumb . '" style="width:89px;height:80px;"></div>';
echo '<div style="line-height:1.6;'. $home_color . 'color:#fff;font-family:Arial;font-size:3.5em;font-weight:bold;width:100px;height:80px;text-align:center;vertical-align:middle;position:relative;float:left;">'. $home_score_meta . '</div>';
echo '<div style="line-height:1.6;' . $away_color . 'color:#fff;font-family:Arial;font-size:3.5em;font-weight:bold;width:100px;height:80px;text-align:center;vertical-align:middle;position:relative;float:left;">'. $away_score_meta . '</div>';
//echo '<div>'. $away_logo. '</div>';
echo '<div style="padding-left:4px;padding-right:4px;position:relative;float:left;width:89px;height:80px;"><img src="' . $away_logo_thumb . '" style="width:89px;height:80px;"></div>';
echo '<div style="text-align:center;line-height:5;width:130px;height:80px;color:#606060;font:Arial;font-size:22;font-weight:900;position:relative;float:left">'. $away_meta . '</div>';
echo '</div>';
echo '<div style="clear:both;"></div>';
echo '<div style="display:table-cell;border-top: 1px solid #ccc;border-collapse:collapse;width:100%;min-height:10px;color:#606060;font:Arial;font-size:22;font-weight:400;text-align:center;position:relative;float:left">'. $game_title . '</div>';
echo '</div>';

}

?>

				</div>
				<!-- end of .post-entry -->
				<?php get_template_part( 'post-data-single' ); ?>




				<div class="navigation">
					<div class="previous"><?php previous_post_link( '&#8249; %link' ); ?></div>
					<div class="next"><?php next_post_link( '%link &#8250;' ); ?></div>
				</div>
				<!-- end of .navigation -->
<div style="width:468px;" class="linkstrips">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 468x15centerofpage -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:15px"
     data-ad-client="ca-pub-6970273280466483"
     data-ad-slot="6581025868"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

<?php echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/suplemento"><div class="title-left">COMENTARIOS</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); ?>

			<?php responsive_comments_before(); ?>
			<?php comments_template( '', true ); ?>
			<?php responsive_comments_after(); ?>

		<?php
	}
//echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
	get_template_part( 'loop-nav' );
}	
else 
{
	get_template_part( 'loop-no-posts' );
}
?>
</div><!-- end of #content -->
<?php get_sidebar(single); ?>
<?php get_footer(); ?>
