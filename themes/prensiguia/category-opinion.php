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
googletag.defineSlot('/11648707/Opinion-Top-270x90', [270, 90], 'div-gpt-ad-1403216210679-4').addService(googletag.pubads());
googletag.defineSlot('/11648707/Opinion-Top-728x90px', [728, 90], 'div-gpt-ad-1403216210679-6').addService(googletag.pubads());
googletag.defineSlot('/11648707/Opinion-Left-160x600px', [160, 600], 'div-gpt-ad-1403216210679-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Opinion-Right-160x600px', [160, 600], 'div-gpt-ad-1403216210679-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Opinion-Sidebar-300x250px', [300, 250], 'div-gpt-ad-1403216210679-3').addService(googletag.pubads());
googletag.defineSlot('/11648707/Opinion-bottom-728x90px', [728, 90], 'div-gpt-ad-1403216210679-0').addService(googletag.pubads());

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
        include(STYLESHEETPATH . '/page-wing-ads-opinion.php');
        include(STYLESHEETPATH . '/banner-ad-widget-opinion-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-opinion-270x90.php');
}            

?>


<?php
responsive_wrapper(); // before wrapper container hook 
echo '<div id="wrapper" class="clearfix">';
responsive_wrapper_top(); // before wrapper content hook 
responsive_in_wrapper(); // wrapper hook 

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
echo do_shortcode('[doap_spacer size=2][doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/opinion"><div style="font-family:Stag;" class="title-left">OPINION</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');


echo '<div id=top-three-ops style="position:relative;top:0px;">';
//echo do_shortcode('<div id=top-three-ops style="position:relative;top:0px;">[doap_posts template="templates/teaser-loop-opinion.php" posts_per_page="1" tax_term="23" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]</div>');
//echo do_shortcode('[doap_posts template="templates/cat-opinion-loop.php" posts_per_page="1" tax_term="23" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]');
$middle_post = 0;
$args = array( 'cat' => 23, 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
include(STYLESHEETPATH . '/templates/cat-opinion-loop.php');
//echo do_shortcode('<div id=top-three-ops style="left:2px;position:relative;top:0px;">[doap_posts template="templates/teaser-loop-opinion.php" posts_per_page="1" tax_term="3515" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]</div>');
$middle_post = 1;
$args = array( 'cat' => 3515, 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
include(STYLESHEETPATH . '/templates/cat-opinion-loop.php');
//echo do_shortcode('[doap_posts template="templates/cat-opinion-loop.php" posts_per_page="1" tax_term="3515" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]');

//echo do_shortcode('<div id=top-three-ops style="left:2px;position:relative;top:0px;">[doap_posts template="templates/teaser-loop-opinion.php" posts_per_page="1" tax_term="3516" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]</div>');


/*
$args = array( 'cat' => 3516, 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
include(STYLESHEETPATH . '/templates/cat-opinion-loop.php');
//echo do_shortcode('[doap_posts template="templates/cat-opinion-loop.php" posts_per_page="1" tax_term="3516" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]');
echo '</div>';
echo '<div id="content-archive" style="margin-top:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';
*/

$category = get_the_category(); 
//$themaincat = $category[0]->cat_ID;
//$single_cat_title = $category[0]->cat_name;
$themaincat = 10;
$single_cat_title = "Opinion";
//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="twodots"></div></a>[/doap_heading]'); 
//echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');


//echo do_shortcode('[doap_slider source="category: '.$themaincat.'" limit="4" width="640" height="360" link="post" mousewheel="no" pages="no" class="deportes-slider"]');

$even = 0;
$max_posts = 7;
global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'cat' => $themaincat ) );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );

$even = 0; 
	if( $the_query->have_posts() ) 
	{
		//get_template_part( 'deportes-loop-header' ); 
		while( $the_query->have_posts() && $even < $max_posts )
		{ 
			$the_query->the_post();
 ?> 
	<?php
/*
 if( have_posts() ) : ?>

		<?php //get_template_part( 'opinion-loop-header' ); ?>

		<?php $i = 1; while (have_posts() && $i < 6) : the_post();
*/
 ?>
<?php
$even++;
if ($even == 1)
{
     $title = get_doap_limit_chars(the_title_attribute('echo=0'),43,1);
                //$thetitle = get_the_title();
                $post_url = get_permalink($post->ID);
$lf_rt_borders = ($middle_post == 1) ? 'border-left: 2px solid #fff;' : '';
?>
<div id="su-post-<?php the_ID(); ?>" class="su-post cat-op">
<div class="cat-op-title" style="width:100%;background-color:#006699;min-height:50px;text-align:center;<?php echo $lf_rt_borders; ?>margin-right:10px;">
<a href="<?php echo $post_url; ?>" style="font-family:StagBook;color:#fff;"><?php echo $title; ?></a></div>
<div style="width:100%;border-right:1px solid #ccc;border-left: 1px solid #ccc;">
<div class="cat-op-story-inner" style="margin:0 auto;">
<?php //$thelink = get_the_permalink(); 
//      $thetime = "<div style=color:#333;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:1px;background-color:#fff;position:relative;float:right;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
//      $thecleantitle = get_the_title();
//      $theexcerpt = $thetime." <h3>".$thetitle."</h3>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
<?php echo "<div style=position:relative;padding:10px 0;width:270px;float:left;margin-left:5px;margin-right:10px;line-height:.8em;border:1px solid #333;>";
//responsive_pro_featured_image();
//the_post_thumbnail( array(300,300) );
if ( has_post_thumbnail() ) {
        $feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' );
        $feat_image = $feat_image_array[0];
        echo '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
}
else
{
        echo '<a href="' . $post_url . '"><div style="width:240px;height:160px;"></div></a>';
}
//the_post_thumbnail( array(300,300) );
echo "</div>"; ?>

<?php
        echo '<div class="opinion-excerpt" style="font-family:Arial;font-size:.9em;color:#333;margin-right:10px;text-align: justify;">' . PHP_EOL;
        $theexcerpt = get_doap_excerpt(240,1,1);
        echo $theexcerpt;
        echo '</div>' . PHP_EOL;
?>

</div>
<div id="cat-op-bottom"></div>
</div>
</div>
<div class="mobile-clear"></div>
<div class="clear-540"></div>
<div class="clear-767"></div>
<?php
echo '</div>';
echo '<div id="content-archive" style="margin-top:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';
}
else
{
if ($even % 2 == 0) {
  $float='right';
}
else
{
$float='left';
	echo '<div style="clear:both;"></div>';
	if ($even == 5)
	{
		echo '<div class="half-box">
';

//include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-300x250-category-page-center.php');


echo '</div>';
		$even++;
		$float='right';
	}
	if ($even == 3)
	{
		echo '<div class="full-box">';
	//include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-468x60-category-page.php');	
		echo '</div>';
	}
} 
responsive_entry_before();  ?>
			
                        <div  class="op-box-2" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <?php //responsive_entry_top(); ?>

                                <?php //get_template_part( 'tag-meta' ); ?>

                                <div class="post-entry">
<?php $gmt_timestamp = get_post_time('U', true); ?>
<?php //tcp_posted_on(); ?>


<?php if ( has_post_thumbnail() ) {
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-150' );
	$post_url = get_permalink($post->ID);
	$feat_image = $feat_image_array[0];
} else { 
	$thecategory = get_the_category(); 
	$thecat = strtolower($thecategory[0]->cat_name); 
	$feat_image = 'http://noticias.laprensa.com.ni/wp-content/uploads/sites/2/2014/07/empt-box.png';
	?> 
<?php } ?>

        <?php 
//	$theexcerpt = get_the_excerpt(); 
        $theexcerpt = get_doap_excerpt(30,1);

	$thepermalink = get_the_permalink(); ?>


<?php
	//echo '<h4 style=color:#369;><a href="' . $thepermalink . '"> <span style=color:#369;>'.get_the_title().'</span></a> </h4>'; ?>
                                        <?php

                                        if( responsive_pro_get_option( 'archive_post_excerpts' ) ) {
                                        echo "<div>";
                                                $the_excerpt = get_the_excerpt(); //echo $the_excerpt;
					        $the_excerpt = get_doap_excerpt(30,1);

                                                $the_content = strip_tags(get_the_content()); //echo $the_content;
                                        echo "</div>";
                                        }
                                        else { ?>



					<?php echo '<div id=op-border><div id=op-inner><div id=op-pos">' . PHP_EOL . '<div id="oppicwrap-2"><a id="oppic" href="' . $post_url . '"><img src="' . $feat_image . '"></a><div style="clear:both;"></div>' . PHP_EOL; ?>

<?php 
        $the_excerpt = get_doap_excerpt(90,1);
	include(STYLESHEETPATH . '/comments-widget.php'); 
?>
</div>
</div>
<div id="op-titlebox-2" class="op-titlebox-2">
<?php	echo '<h4 id=op-title-2><a href="' . $thepermalink . '"> <span style=color:#369;>'.get_the_title().'</span></a> </h4>'; ?> 
<div id="op-excerpt-2"><?php echo $the_excerpt; //the_excerpt(); ?></div>
</div>

<?php
                                                //remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
                                                //remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
                                        }
/*
 ?><div id="cat-tax">
							<?php $taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
                                                foreach( $taxonomies as $id => $taxonomy ) :
                                                        //echo "<br>";
                                                        $terms_list = get_the_term_list( 0, $id, '', ', ' );
                                                        if ( strlen( $terms_list ) > 0 ) : ?>
                                                        <?php endif;
                                                endforeach;?></div>

<?php
                                        //wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
*/                                        ?>
                                </div>
</div>
                                <!-- end of .post-entry -->




                                <?php //get_template_part( 'post-data' ); ?>

                                <?php responsive_entry_bottom(); ?>
                        </div><!-- end of #post-<?php the_ID(); ?> -->

<?php responsive_entry_after(); ?>
		<?php
}
}
}
/*		$i++; endwhile;
*/
                //echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
		//get_template_part( 'loop-nav' );

else
{

		get_template_part( 'loop-no-posts' );
}
//	endif;
	?>

</div><!-- end of #content-archive -->


<?php //my_pagination(); ?>
<?php get_sidebar('opinion'); ?>


<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-ad-widget-opinion-bottom-728x90.php'); echo ""; } ?>

<?php //echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); ?>
<?php get_footer(); ?>
