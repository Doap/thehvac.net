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
<?php if (current_user_can( 'manage_options' ))  { } else { include('/var/www/html/lpmu/wp-content/themes/noticias' . '/page-wing-ads.php'); } ?>
<?php
include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-ad-widget.php');  
include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-ad-widget-270x90.php');  

echo '<div id="content-archive" style="margin-top:4px;margin-right:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';


$max_posts = 9;
$right_col_start = 5;
$right_col_pix = 1;
$category = get_the_category(); 
$themaincat = $category[0]->cat_ID;
$single_cat_title = $category[0]->cat_name;
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
if( $the_query->have_posts() ) 
{
while ( $the_query->have_posts() )
{
	$the_query->the_post();
	$posted_time = date('h:i A',get_the_time());
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
			if ($img_height > $img_width)
			{
				$right_col_start = 4;
				$right_col_pix = 1;
				$max_posts = 9;
				$pix_class = 'catpic-vert';
				$pix_size = 'responsive-450';
				$pix_width = '420px;position:relative;float:left;';
				$pix_img_width = '450px;';
				$story_pre = '<div class="su-column su-column-size-2-3" style="width:420px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
				$story_post = '';
			}
			else
			{
				$right_col_start = 3;
				$right_col_pix = 0;
				$max_posts = 7;
				$pix_orient = 'horizontal';
				$pix_class = 'catpic-hori';
				$pix_size = 'Video-Poster-640x360';
				$pix_width = '100%;';
				$pix_img_width = '657px;';
				$story_pre = '<div style="clear:both;">';
				$story_post = '</div><div class="su-column su-column-size-1-3" style="width:250px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
			}
		}
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $pix_size );
		$post_url = get_permalink($post->ID);
		$feat_image = $feat_image_array[0];
	
	$theexcerpt = get_doap_excerpt(30,1);
	$theexcerpt = '<div class="category-excerpt" style="padding:4px;">' . $theexcerpt . '</div>' . PHP_EOL;
		echo $story_pre;
		echo do_shortcode('<a href="' . $post_url . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="25" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>');
		echo '<div class="' . $pix_class . '" style="position:relative;float:left;border: 1px solid #ccc;max-width:' . $pix_width . '">' . PHP_EOL;
		echo '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . '">' . PHP_EOL;
		echo '<div style="position:absolute;display:block;bottom:0px;left:0px;height:30px;width:100%;max-width:100%;color:#fff;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;font-size:11pt;"><div><div style="position:absolute;width:60px;margin:0px 5px 5px 0px;padding:5px;color:#fff;"> ' . $posted_time . '</div>';
		echo '<div style="float:right;margin:0px 5px 5px 65px;text-align:right;padding:5px;color:#fff;">';
//		echo $write_comments;
		echo '</div></div></a></div></div>';
		echo $theexcerpt;
		echo $story_post;
}
}
else
{
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
		get_template_part( 'deportes-loop-header' ); 
//echo 'max posts = ' . $max_posts;
		while( $the_query->have_posts() && $even < $max_posts )
		{ 
			$the_query->the_post();

//var_dump($query);
$even++;
$float='float:left;';
//echo '<div style="clear:both;"></div>';
//if ($paged > 1 && $even == 1)
//echo 'even = ' . $even;
if ($even == 1)
{
	echo '<div class="su-column su-column-size-1-3 shawn" style="width:250px;height:auto;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
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
	echo '<div style="margin:0px auto 0px auto;width:300px;position:relative;float:left;">';
	include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-300x250-category-page-center.php');
	echo '</div>';
	$max_width = 'width:350px;';
}
}
if ($even == 2 && paged < 2)
{

	echo do_shortcode('[table id=23 /]');
	echo '</div>';
	echo '</div>';
	echo do_shortcode('<div style="width:390px;position:relative;float:right;">[xyz-ips snippet="economy-graphs"]</div>');
	echo '<div style="clear:both;"></div>';
	echo '<div style="width:100%;height:auto;">';
}
if ($even == 6 && paged < 2)
{
	//echo '</div>';
$float = 'float:right;margin-right:4px;';
	$max_width = 'width:320px;';
}
if ($even == 7 && paged < 2)
{
//	echo '</div>';
	echo '<div style="width:100%;height:auto;">';
$float = 'float:left;';
}
if ($even == $right_col_start)
{
//echo '</div>';
//echo '<div class="su-column su-column-size-1-3 category economia" style="width:229px;position:relative;float:right;margin:0 0 0 0;">';
//$max_width = 'width:100%;';
}
 
//echo '<div style="clear:both;"></div>';
/*
if ($even == 1 && $pix_orient == 'horizontal' && $paged < 2 && 7 == 6)
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
$sec_story_excerpt = '<div class="category-excerpt" style="padding:4px;">' . $theexcerpt . '</div>' . PHP_EOL;

echo $sec_story_excerpt . '</div>';
echo '<div style="clear:both;"></div>';
	echo '<div style="margin:50px auto 50px auto;width:300px;position:relative;">';
	include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-300x250-category-page-center.php');
	echo '</div>';
}
*/
if ($even > 1 && $even < 6)
{
$max_width = ($even == 5) ? 'width:340px;' : 'width:213px;';
//		echo '<div style="position:absolute;display:block;bottom:0px;left:0px;height:30px;width:100%;max-width:100%;color:#fff;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;font-size:11pt;"><div><div style="position:absolute;width:60px;margin:0px 5px 5px 0px;padding:5px;color:#fff;"> ' . $posted_time . '</div>';
	$theexcerpt = ($even == 5) ? get_doap_excerpt(6, 1) : get_doap_excerpt(50,1);
	$font_size = ($even == 5) ? 'font-size:13pt;' : 'font-size:14px;';
	$title_height = ($even == 5) ? 'height:30px;line-height:1.5;' : 'height:20px;line-height:1;';
	$bottom_height = ($even == 5) ? 'height:40px;line-height:1.5;' : 'height:20px;line-height:1;';
	$font_color= ($even == 5) ? 'color:#fff;' : 'color:#fff;';
	$margin_right = ($even == 4) ? 'margin-right:0px;' : 'margin-right:7px;';
	$padding_left = ($even == 5) ? 'padding-left:8px;' : 'padding-left:0px;';
	$background = ($even == 5) ? 'background:rgba(0, 0, 0, 0.5);' : 'background:rgba(3, 3, 3, 0.75);';
	$excerpt_align= ($even == 5) ? 'text-align:left;' : 'text-align:justify;';
	$title = the_title_attribute('echo=0');
	$post_url = get_permalink($post->ID);
	$top_text = ($even == 5) ? '<div style="z-index:10;position:absolute;' . $font_color . $background . 'border-radius:0;opacity:1;font-family:Arial;' . $font_size . 'text-align:center;padding:2px 5px 2px 5px;' . $title_height . '">' . $title . '</div>' : '' ;
	$bottom_text = ($even == 5) ? $theexcerpt : $title;
	echo '<div style="' . $max_width . 'position:relative;float:left;' . $margin_right . $padding_left . '">';
	echo '<div class="tcp-product-list tcpf" style="' .$max_width . 'margin-bottom:10px;min-height:300px;">';
	echo $top_text . PHP_EOL;
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' ); 
	$feat_image = $feat_image_array[0];
	echo '<div style="' . $max_width . 'position:relative;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL;
	echo '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="' . $max_width . '">';
	echo '<div style="margin: 0px;position:absolute;display:block;bottom:0px;left:0px;height:35px;' . $max_width . $background . 'color:#fff;border-radius:0;opacity:1;' . $font_size . 'font-family:Arial;text-align:left;">';
	echo '<div style="' . $font_size . $bottom_height . 'padding: 2px 4px 2px 4px;">' . $bottom_text . '</div></div></a>' . PHP_EOL;
	echo '</div>';
//	echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
	if ($even <> 5)
	{
	echo '<div style="' . $excerpt_align . '">' . $theexcerpt . '</div>';
	}
	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}
else
{
responsive_entry_before(); 
echo '<div id="su-post-' . get_the_ID() . '" style="position:relative;'. $float . $max_width . '">';
responsive_entry_top(); 
	$theexcerpt = get_doap_excerpt(30,1);
	$theexcerpt = '<div class="category-excerpt" style="padding:4px;">' . $theexcerpt . '</div>' . PHP_EOL;
$thepermalink = get_the_permalink();
echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>');
?>
	<div class="post-entry">
<?php $gmt_timestamp = get_post_time('U', true); 
if (!$right_col_pix && $even >= $right_col_start)
{
	$show_img = 1;	
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
?>
<div class="destacados-section">
<?php echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.str_replace(" ","-",strtolower($single_cat_title)).'/page/2"><div class="title-left">MÁS EN ' . mb_strtoupper($single_cat_title) . '</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); ?>

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
}
	wp_reset_postdata();
//echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
?>
</div><!-- end of #content-archive -->
<?php get_sidebar('economia'); ?> 
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
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>
<?php get_footer(); ?>
