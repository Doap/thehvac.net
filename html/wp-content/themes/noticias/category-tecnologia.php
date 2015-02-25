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
    
/* tecnologia slots */
googletag.defineSlot('/11648707/Tecnologia-bottom-728x90px', [728, 90], 'div-gpt-ad-1403214977765-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Tecnologia-Top-728x90px', [728, 90], 'div-gpt-ad-1403214977765-6').addService(googletag.pubads());
googletag.defineSlot('/11648707/Tecnologia-Top-270x90', [270, 90], 'div-gpt-ad-1403214977765-4').addService(googletag.pubads());
googletag.defineSlot('/11648707/Tecnologia-Left-160x600px', [160, 600], 'div-gpt-ad-1403214977765-1').addService(googletag.pubads()); 
googletag.defineSlot('/11648707/Tecnologia-Right-160x600px', [160, 600], 'div-gpt-ad-1403214977765-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Tecnologia-Top-300x250px', [300, 250], 'div-gpt-ad-1403214977765-5').addService(googletag.pubads());
googletag.defineSlot('/11648707/Tecnologia-Sidebar-300x250px', [300, 250], 'div-gpt-ad-1403214977765-3').addService(googletag.pubads());

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
        include(STYLESHEETPATH . '/page-wing-ads-tecnologia.php');
        include(STYLESHEETPATH . '/banner-ad-widget-tecnologia-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-tecnologia-270x90.php');
}            

?>


<?php
responsive_wrapper(); // before wrapper container hook 
echo '<div id="wrapper" class="clearfix">';
responsive_wrapper_top(); // before wrapper content hook 
responsive_in_wrapper(); // wrapper hook 

echo '<div id="content-archive" style="margin-top:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';


$category = get_the_category(); 
//$themaincat = $category[0]->cat_ID;
$themaincat = 991;
//$single_cat_title = $category[0]->cat_name;
$single_cat_title = "Tecnologia";
$slider_posts = 4;
$cat_carousel_posts = 6;
$left_300_story = 1;
$offset = $slider_posts + $cat_carousel_posts;
$max_posts = 4;
//$max_posts = 0;
$mini_post = 4;
//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.$single_cat_title.'</div><div class="twodots"></div></a>[/doap_heading]'); 


/*
else
{
echo '<div style="width:100%;height:200px;bakground-color:#ccc;">What happened?<br>';
var_dump($the_query);
echo '</div>';
}
*/

/*
echo do_shortcode('<div style="top:17px;position:relative;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/futbol-transparent.png" alt="futbol" width="22" height="22" class="alignleft size-thumbnail wp-image-1146384" /></div>

<div style="top:21px;left:-9px;position:relative;font-size:1.2em;font-weight:900;color:#fff;">7ma entrada</div>

<div id="scoreboard-strip" style="border:0px;max-width:679px;"></div>

<table width="100%" style="max-width:689px;border:0px;position:relative;top:-21px;">
<tr>
<td class="ui-helper-center" style="background-color:#fff;size:3em;">

<img width="50" height="50" class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/Screen-Shot-2014-05-17-at-6.11.38-PM.png" style="width:100px;height:100px;position:relative;float:right;padding:0px;margin:0px;" alt="">

</td><td class="ui-helper-center scorebox" style="vertical-align:center;">5</td><td class="ui-helper-center scorebox" style="background-color:#eee;vertical-align:center;">6</td><td class="ui-helper-center"  style="background-color:#fff;size:3em;">

<img width="50" height="50" class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/Screen-Shot-2014-05-17-at-6.11.38-PM.png" style="width:100px;height:100px;position:relative;float:left;padding:0px;margin:0px;" alt="">

</td>
</tr>
</table>

*/







//echo '<iframe src="http://prensa-fwc-scoreboard.sportsflash.com.au/Scoreboard/index.htm#/landing/149/es-ES/305" height="700" width="100%" frameborder=0 scrolling="no"></iframe>';







/*
echo do_shortcode('[doap_row][doap_column size="2/3"]
<div style="position:relative;top:-10px;">
[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/category/noticias/deportes">Deportes</a>[/doap_heading][/doap_animate] 
</div>

[doap_slider source="category: 17" limit="4" link="post" width="440" height="320" arrows="no" pages="no" mousewheel="no" autoplay="8000" speed="400" class="slider-home " ignore_sticky_posts="yes"]

  [/doap_column]
  [doap_column size="1/3"] 
<div style="position:relative;top:-10px;">
[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/category/noticias/deportes">Ultimo Hora en Deportes</a>[/doap_heading][/doap_animate]  
</div>

<div id="" style="overflow:scroll; height:300px;">
[doap_posts template="templates/100px-list.php" posts_per_page="20" tax_term="17,3132" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent="  " ignore_sticky_posts="yes"]
</div>

  [/doap_column] 
[/doap_row]


<div  id="sportsad1"  style="left:38px;position:relative;">
</div>

[doap_row]
  [doap_column size="2/3"] 

[doap_spacer size="15"]

 [/doap_column]
  [doap_column size="1/3"]
 
[doap_spacer size="15"]

     [/doap_column]
[/doap_row]');
*/



echo do_shortcode('[doap_slider source="category: '.$themaincat.'" limit="' . $slider_posts . '" width="640" height="360" link="post" mousewheel="no" pages="no" class="deportes-slider" meta="notbreves"]');

echo do_shortcode('[doap_cat_carousel source="category: '.$themaincat.'" limit="' . $cat_carousel_posts . '" link="post" width="900" height="300" autoplay="0" class="carousel-shawn" meta="notbreves" offset="4"]'); 
//echo do_shortcode('[doap_posts template="templates/box-loop-single-wide.php" posts_per_page="1" offset="4" tax_term="'.$themaincat.'" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]');
    
//echo do_shortcode('[doap_spacer size="2"]');
//echo '<div style="width:100%;border:1px solid #eee;">';
//echo '</div>';






/*  Commented out by shawn 2014-07-09
echo do_shortcode('[doap_posts template="templates/box-loop.php" offset="7" posts_per_page="1" tax_term="'.$themaincat.'" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent="  " ignore_sticky_posts="yes"]');
echo '<div style="width:300px;height:250px;border:1px solid #eee;position:absolute;left:330px;top:850px;">';
if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-category-page-center-tecnologia.php'); echo ""; }
echo '</div>';
echo do_shortcode('[doap_row]<div style=width:100%;border:1px solid #eee;>[doap_posts template="templates/box-loop.php" offset="8" posts_per_page="2" tax_term="'.$themaincat.'" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent="  " ignore_sticky_posts="yes"]</div>[/doap_row]');
*/





//echo do_shortcode '[doap_row]<div style=width:100%;border:1px solid #eee;>';
//echo '</div>[/doap_row]';
//echo do_shortcode('   [doap_column size="1/2"][doap_posts template="templates/box-loop.php" offset="0" posts_per_page="1" tax_term="'.$themaincat.'" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent="  " ignore_sticky_posts="yes"] [/doap_column] [doap_column size="1/2"][doap_posts template="templates/box-loop.php" offset="0" posts_per_page="1" tax_term="'.$themaincat.'" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent="  " ignore_sticky_posts="yes"] [/doap_column] ');

//echo do_shortcode('[doap_spacer size="73"]'); 
$even = 0; 
global $wp_query;
//$args = array_merge( $wp_query->query_vars, array( 'meta_query' => array( array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ) ), 'post__not_in' => $feat_post ) );
$args = array_merge( $wp_query->query_vars, array( 'cat' => $themaincat, 'offset' => $offset, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post ) );
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
/*
	<?php if( have_posts() ) : ?>

		<?php get_template_part( 'deportes-loop-header' ); ?>

		<?php $i = 1; while (have_posts() && $i < 3) : the_post(); ?>
<?php
*/
$even++;
$float='left';
if ($even == 1)
{
	echo '<div style="clear:both;"></div>';
	echo '<div style="margin:0px auto 0px auto;width:300px;position:relative;float:left;">';
	if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-category-page-center-tecnologia.php'); echo ""; }
	//include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-300x250-category-page-center.php');
	echo '</div>';
	$max_width = 'width:350px;';
}
if ($even % 2 == 0) {
//  $float='right';
}
else
{
$float='left';
//:	echo '<div style="clear:both;"></div>';
	if ($even == 5)
	{
		echo '<div style="width:50%;position:relative;float:left;">';

	include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-300x250-category-page-center.php');


echo '</div>';
		$even++;
//		$float='right';
	}
	if ($even == 300)
	{
                echo '<div style="width:100%;position:relative;float:left;">';
        include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-468x60-category-page.php');
                echo '</div>';
	}
} 
if ($even == $left_300_story || $even == $mini_post)
{
if ($even == $left_300_story)
	{
include(STYLESHEETPATH . '/templates/left_300.php');
/*
	$max_width = ($even == $left_300_story) ? 'width:340px;' : 'width:213px;';
//		echo '<div style="position:absolute;display:block;bottom:0px;left:0px;height:30px;width:100%;max-width:100%;color:#fff;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;font-size:11pt;"><div><div style="position:absolute;width:60px;margin:0px 5px 5px 0px;padding:5px;color:#fff;"> ' . $posted_time . '</div>';
	$theexcerpt = ($even == $left_300_story ) ? get_doap_excerpt(7, 1) : get_doap_excerpt(50,1);
	$font_size = ($even == $left_300_story ) ? 'font-size:13pt;' : 'font-size:14px;';
	$title_height = ($even == $left_300_story ) ? 'height:30px;line-height:1.5;' : 'height:20px;line-height:1;';
	$bottom_height = ($even == $left_300_story ) ? 'height:40px;line-height:1.5;' : 'height:20px;line-height:1;';
	$font_color= ($even == $left_300_story ) ? 'color:#fff;' : 'color:#fff;';
	$margin_right = ($even == 4) ? 'margin-right:0px;' : 'margin-right:7px;';
	$padding_left = ($even == $left_300_story ) ? 'padding-left:8px;' : 'padding-left:0px;';
	$background = ($even == $left_300_story ) ? 'background:rgba(0, 0, 0, 0.5);' : 'background:rgba(3, 3, 3, 0.75);';
	$excerpt_align= ($even == $left_300_story ) ? 'text-align:left;' : 'text-align:justify;';
	$title = the_title_attribute('echo=0');
	$post_url = get_permalink($post->ID);
	$top_text = ($even == $left_300_story ) ? '<div style="z-index:10;position:absolute;' . $font_color . $background . 'border-radius:0;opacity:1;font-family:Arial;' . $font_size . 'text-align:center;padding:2px 5px 2px 5px;' . $title_height . '">' . $title . '</div>' : '' ;
	$bottom_text = ($even == $left_300_story ) ? $theexcerpt : $title;
	echo '<div style="' . $max_width . 'position:relative;float:left;height:250px;' . $margin_right . $padding_left . '">';
	echo '<div class="tcp-product-list tcpf" style="' .$max_width . 'margin-bottom:10px;min-height:250px;">';
	echo $top_text . PHP_EOL;
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' ); 
	$feat_image = $feat_image_array[0];
	echo '<div style="' . $max_width . 'position:relative;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL;
	echo '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="' . $max_width . 'height:250px;">';
	echo '<div style="margin: 0px;position:absolute;display:block;bottom:0px;left:0px;height:35px;' . $max_width . $background . 'color:#fff;border-radius:0;opacity:1;' . $font_size . 'font-family:Arial;text-align:left;">';
	echo '<div style="' . $font_size . $bottom_height . 'padding: 2px 4px 2px 4px;">' . $bottom_text . '</div></div></a>' . PHP_EOL;
	echo '</div>';
//	echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
	if ($even <> $left_300_story )  //Check why this is here...
	{
	echo '<div style="' . $excerpt_align . '">' . $theexcerpt . '</div>';
	}
	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
*/
	echo '<div style="height:20px;clear:both;"></div>';
	}
else
	{
	echo '<div style="height:10px;clear:both;"></div>';
	$exp_words = 200;
	$extract_chars = 200;
	include(STYLESHEETPATH . '/templates/cat-mini.php');
	}	
}
else
{
$show_img = 1;	
$max_width = ($even > 1 && $even < 4) ? 'width:330px;' : 'width:100%;';
$float = ($even == 3) ? 'float:right;' : 'float:left;';
$float_class = ($even == 3) ? 'class="su-post float_right"' : 'class="su-post float_left"';
include(STYLESHEETPATH . '/templates/normal.php');
/*
responsive_entry_before(); 
echo '<div id="su-post-' . get_the_ID() . '" class="su-post float_' . $float . '" style="position:relative;">';
responsive_entry_top(); 
//get_template_part( 'category-meta' ); 
$theexcerpt = get_doap_excerpt(50,1);
$thepermalink = get_the_permalink();
echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>'); ?>

 <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a>


				<div class="post-entry">
<?php $gmt_timestamp = get_post_time('U', true); ?>
<?php //tcp_posted_on(); ?>



<?php //$cat = str_replace(single_tag_title('Categoría: '), "Categoría", ""); ?>
<?php if ( has_post_thumbnail() ) {

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-300' );
$post_url = get_permalink($post->ID);
$feat_image = $feat_image_array[0];
echo '<div style="max-width:300px;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
echo '</div>';

} else { ?>
<?php $current_category = single_cat_title("", false); ?>
<div style="float:right;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/laprensanota-<?php echo strtolower($current_category); ?>.jpg" draggable="false" title="No imagen existe para este nota."> </div><?php } ?> 
					<?php
					if( responsive_pro_get_option( 'archive_post_excerpts' ) ) {
				//		add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
				//		add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
						echo "<div style=float:left;position:relative;width:90%;text-align:justify;>";
                                  //              $the_excerpt = get_the_excerpt(); //
						echo $theexcerpt;
                                    //            $the_content = strip_tags(get_the_content()); //echo $the_content;
                                     //           the_excerpt();
                                        echo "</div>";
				//		remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
				//		remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					}
					else {
				//		add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
				//		add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					 echo "<div style=float:left;position:relative;width:90%;text-align:justify;>";
                                  //              $the_excerpt = get_the_excerpt(); //
						echo $theexcerpt;
                                    //            $the_content = get_the_content(); //echo $the_content;
                                      //          the_excerpt();
                                        echo "</div>";
					//	remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
					//	remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					}



					wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
					?>
				</div>
				<!-- end of .post-entry -->




				<?php //get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php

*/
responsive_entry_after(); ?>
		<?php
		$i++;
}	
	}
                //echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
		//get_template_part( 'loop-nav' );
}
else 
{
	get_template_part( 'loop-no-posts' );
}
	?>

</div><!-- end of #content-archive -->
<?php 
get_sidebar('tecnologia'); 
echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-ad-widget-tecnologia-bottom-728x90.php'); echo ""; } ?>

<?php
//echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); 
get_footer();
?>
