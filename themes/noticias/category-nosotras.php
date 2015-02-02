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
.su-post-meta { font-size:.8em;position:relative;float:left;height:295px;width:178px; }
</style>
<script type='text/javascript'>
googletag.cmd.push(function() {
    
/* nosotras slots */
googletag.defineSlot('/11648707/Nosotras-Left-160x600px', [160, 600], 'div-gpt-ad-1403217113344-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nosotras-Right-160x600px', [160, 600], 'div-gpt-ad-1403217113344-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nosotras-Top-728x90px', [728, 90], 'div-gpt-ad-1403217113344-6').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nosotras-bottom-728x90px', [728, 90], 'div-gpt-ad-1403217113344-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nosotras-Top-270x90', [270, 90], 'div-gpt-ad-1403217113344-4').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nosotras-Sidebar-300x250px', [300, 250], 'div-gpt-ad-1403217113344-3').addService(googletag.pubads());
googletag.defineSlot('/11648707/Nosotras-Top-300x250px', [300, 250], 'div-gpt-ad-1403217113344-5').addService(googletag.pubads())

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
        include(STYLESHEETPATH . '/page-wing-ads-nosotras.php');
        include(STYLESHEETPATH . '/banner-ad-widget-nosotras-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-nosotras-270x90.php');
}            

?>


<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>

<?php

echo '<div id="content-archive" style="margin-top:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';


$category = get_the_category(); 
//$themaincat = $category[0]->cat_ID;
//$single_cat_title = $category[0]->cat_name;
$themaincat = 25763;
$single_cat_title = "Nosotros";


//echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/suplemento"><div class="title-left">NOSOTRAS</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');


//echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="right" margin="0" class="fp-title-bar"]<div style="width:100%;background-color:#dd579a;height:150px;top:-40px;position:relative;"><h1 style="position:relative;float:right;padding:20px;;color:#fff;">nosotras</h1><p></p></div>[/doap_heading][/doap_animate]');
//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="twodots"></div></a>[/doap_heading]'); 

//echo do_shortcode('[doap_slider source="category: '.$themaincat.'" limit="4" width="640" height="360" link="post" mousewheel="no" pages="no" class="deportes-slider"]');




echo '<div style="width:100%;min-width:642px;">';
/*
echo do_shortcode('[doap_spacer size=13]<div style="clear:both;"></div><div style="border:1px solid #606060; position:relative;float:left;width:63%;height:246px;"><img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/thinstrip-grey-w-arrow.png" style="37%;top:-5px;position:relative;margin-top:0px;margin-bottom:0px;max-height:20px;" alt="">

[doap_posts template="templates/nosotras-story1.php" posts_per_page="1" tax_term="25763" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,127,111,118,125,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " offset=1 ignore_sticky_posts="yes"]

</div>');
*/
/* [doap_slider source="category: '.$themaincat.'" limit="1" autoplay="0" arrows="no" width="414" height="220" link="post" mousewheel="no" pages="no" class="deportes-slider"] */

echo do_shortcode('<div style="width:431px;height:250px;position:relative;float:left;">[doap_nos_carousel source="category: 25763" limit="5" items="1" link="post" width="431" height="250" responsive="yes" mousewheel="no" autoplay="0"]</div>');
//echo do_shortcode('[xyz-ips snippet="nosotras-home-menu"]');
echo do_shortcode('

<div style="min-width:229px;position:relative;float:right;height:246px;border:1px solid #606060;background-color:#dd579a;color:#fff;width:229px;font-family:StagSansBook;padding-right:8px;">

<img class="thumbnail" src="http://noticias.laprensa.com.ni/wp-content/uploads/sites/2/2014/07/logonosotras2.svg" style="max-width:229px;" alt="">

<div style="width:100%;padding:8px;font-family:StagBook;">[doap_posts template="templates/nosotras-edicion.php" posts_per_page="1" tax_term="63770" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,127,111,118,125,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]</div>

</div>

');
echo "</div>";

//echo do_shortcode('[doap_carousel source="category: 25763" limit="3" link="post" width="660" height="150" mousewheel="no" autoplay="100000" speed="800" class="carousel-aqn"]');


echo '<div style="clear:both;"></div>';


echo do_shortcode('[doap_posts template="templates/box-loop-aqn-2.php" posts_per_page="1" tax_term="25763" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,111,118,125,112,110,107,115,120,106,104,105,119,109" offset="5" order="desc" orderby="comment_count" post_parent=" " ignore_sticky_posts="yes"]');

?>

<div style="position:relative;float:right;margin-top:20px;">
<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-category-page-center-nosotras.php'); echo ""; } ?>
 </div>
<?php 
//echo do_shortcode('[doap_posts template="templates/box-loop-aqn.php" posts_per_page="1" tax_term="25763" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,111,118,125,112,110,107,115,120,106,104,105,119,109" offset="2" order="desc" orderby="comment_count" post_parent=" " ignore_sticky_posts="yes"]');

echo '<div style="clear:both;"></div>';

//echo do_shortcode('[doap_posts template="templates/box-loop-aqn.php" posts_per_page="2" tax_term="25763" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,111,118,125,112,110,107,115,120,106,104,105,119,109" offset="3" order="desc" orderby="comment_count" post_parent=" " ignore_sticky_posts="yes"]');


echo do_shortcode('[doap_row]
  [doap_column size="1/3"] [doap_posts template="templates/loop-220x245.php" posts_per_page="2" tax_term="25763" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,111,118,125,112,110,107,115,120,106,104,105,119,109" offset="6" order="desc" orderby="comment_count" post_parent=" " ignore_sticky_posts="yes"] [/doap_column]
  <div class="su-column su-column-size-2-3" style="margin-right:5px;">[doap_spacer size="10"] [doap_posts template="templates/nosotras-editorial-loop.php" posts_per_page="1" tax_term="64131" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,111,118,125,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"] [doap_posts template="templates/nosotras-editorial-loop2.php" posts_per_page="1" tax_term="64132" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,111,118,125,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]  [doap_posts template="templates/nosotras-editorial-loop3.php" posts_per_page="1" tax_term="64133" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,111,118,125,112,110,107,115,120,106,104,105,119,109" order="desc" post_parent=" " ignore_sticky_posts="yes"]</div>
[/doap_row]');


$even = 0; ?> 
	<?php if( have_posts() ) : ?>

		<?php //get_template_part( 'deportes-loop-header' ); ?>

                <?php $i = 1; while (have_posts() && $i < 1) : the_post(); ?>
<?php
$even++;
if ($even % 2 == 0) {
  $float='right';
}
else
{
$float='left';
	echo '<div style="clear:both;"></div>';
	if ($even == 5)
	{
		echo '<div style="width:50%;position:relative;float:left;">
';

if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-category-page-center-nosotras.php'); echo ""; } 


echo '</div>';
		$even++;
		$float='right';
	}
	if ($even == 3)
	{
		echo '<div style="width:100%;position:relative;float:left;">';
if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-category-page-center-nosotras.php'); echo ""; } 
		echo '</div>';
	}
} 
responsive_entry_before(); 
echo '<div id="su-post-' . get_the_ID() . '" class="su-post float_' . $float . '" style="position:relative;">';
responsive_entry_top(); 
//get_template_part( 'category-meta' ); 
$theexcerpt = get_the_excerpt(); $thepermalink = get_the_permalink(); echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>'); ?>

 <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a>

<?php /* <div style="position:relative;float:left;padding-left:0px;padding-top:5px;padding-bottom:3px;"><?php _e( 'Publicado ', 'su' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?></div> */ ?>
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
<div style="width:100%;height:200px;margin-left:auto;margin-right:auto;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/laprensanota-<?php echo strtolower($current_category); ?>.jpg" draggable="false"> </div><div style="clear:both;"></div><?php } ?> 
					<?php
					if( responsive_pro_get_option( 'archive_post_excerpts' ) ) {
						add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
						echo "<div style=float:left;position:relative;width:90%;text-align:justify;>";
                                                $the_excerpt = get_the_excerpt(); //echo $the_excerpt;
                                                $the_content = strip_tags(get_the_content()); //echo $the_content;
                                                the_excerpt();
                                        echo "</div>";
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					}
					else {
						add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					 echo "<div style=max-float:left;position:relative;width:90%;text-align:justify;>";
                                                $the_excerpt = get_the_excerpt(); //echo $the_excerpt;
                                                $the_content = get_the_content(); //echo $the_content;
                                                the_excerpt();
                                        echo "</div>";
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					}
/*
 ?><div id="cat-tax">
<?php
 $taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
                                                foreach( $taxonomies as $id => $taxonomy ) :
                                                        $terms_list = get_the_term_list( 0, $id, '', ', ' );
                                                        echo "<br>";
                                                        if ( strlen( $terms_list ) > 0 ) : ?>
                                                        <span class="tcp-product-taxonomy tcp-product-taxonomy-<?php echo $taxonomy->name;?>"><?php echo $taxonomy->labels->singular_name; ?>:
                                                        <?php echo $terms_list;?>
                                                        </span>
                                                        <?php endif;
                                                endforeach;?></div>

<?php
*/


					wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
					?>
				</div>
				<!-- end of .post-entry -->




				<?php //get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>
		<?php
		$i++; endwhile;

                //echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
		//get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-archive -->
<?php //my_pagination(); ?>
<?php get_sidebar(nosotras); ?>

<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>


<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-ad-widget-departamentales-bottom-728x90.php'); echo ""; } ?>


<?php //echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); ?>
<?php get_footer(); ?>
