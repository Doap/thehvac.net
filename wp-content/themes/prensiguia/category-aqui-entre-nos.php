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
    
/* aqui-entre-nos slots */
googletag.defineSlot('/11648707/Aqui-entre-nos-Right-160x600px', [160, 600], 'div-gpt-ad-1403217573777-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Aqui-entre-nos-Left-160x600px', [160, 600], 'div-gpt-ad-1403217573777-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Aqui-entre-nos-Top-728x90px', [728, 90], 'div-gpt-ad-1403217573777-6').addService(googletag.pubads());
googletag.defineSlot('/11648707/Aqui-entre-nos-Top-270x90', [270, 90], 'div-gpt-ad-1403217573777-4').addService(googletag.pubads());
googletag.defineSlot('/11648707/Aqui-entre-nos-bottom-728x90px', [728, 90], 'div-gpt-ad-1403217573777-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Aqui-entre-nos-Sidebar-300x250px', [300, 250], 'div-gpt-ad-1403217573777-3').addService(googletag.pubads());


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
        include(STYLESHEETPATH . '/page-wing-ads-aqui-entre-nos.php');
        include(STYLESHEETPATH . '/banner-ad-widget-aqui-entre-nos-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-aqui-entre-nos-270x90.php');
}            

?>

<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>

<?php

echo '<div id="content-archive" style="margin-top:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';


//$category = get_the_category(); 
$themaincat = 924; 
$single_cat_title = 'Aquí Entre Nos'; 

//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="twodots"></div></a>[/doap_heading]'); 

//echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="right" margin="0" class="fp-title-bar"]<div style="width:100%;background-color:#f57114;height:150px;top:-35px;position:relative;"><h1 style="position:relative;float:right;padding:20px;;color:#fff;">Aqui Entre Nos</h1><p></p></div>[/doap_heading][/doap_animate]');
echo do_shortcode('[doap_spacer size=13]<div style="clear:both;"></div><div style="border:1px solid #606060; position:relative;float:left;width:450px;height:350px;">[doap_slider source="category: '.$themaincat.'" limit="1" autoplay="0" arrows="no" width="450" height="350" link="post" mousewheel="no" pages="no" meta="edicion" class="deportes-slider"]</div>');

echo do_shortcode('[xyz-ips snippet="aqn-10notes"]');

//echo do_shortcode('<div style="width:660px;height:150px;">[doap_carousel source="category: 924" offset="1" limit="3" link="post" width="660" height="150" arrows="no" mousewheel="no" autoplay="100000" speed="800" class="carousel-aqn"]</div>');
echo do_shortcode('[doap_custom_gallery source="category: 924" offset="1" limit="3" link="post" width="210" height="150" title="always" meta="edicion" class="gallery-aqn"]');

echo '<div style="clear:both;"></div>';

echo do_shortcode('[doap_posts template="templates/box-loop-aqn.php" posts_per_page="2" tax_term="924" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,111,118,125,112,110,107,115,120,106,104,105,119,109" offset="4" order="desc" orderby="comment_count" post_parent=" " ignore_sticky_posts="yes"]');

echo '<div style="clear:both;"></div>';

echo do_shortcode('[doap_posts template="templates/box-loop-aqn.php" posts_per_page="2" tax_term="924" tax_operator="0" author="122,123,1,124,102,108,113,114,116,117,121,126,103,111,118,125,112,110,107,115,120,106,104,105,119,109" offset="6" order="desc" orderby="comment_count" post_parent=" " ignore_sticky_posts="yes"]');


echo '<div style="clear:both;"></div>';
?>
<style>
.su-carousel-slide-title { max-height:40px;position:relative;top:40px;max-width:205px;left:0px;color:#fff;font-size:.8em;font-weight:900; }
.carousel-aqn {color:#fff;}
</style>
<?php
//echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');


//echo do_shortcode('[doap_slider source="category: '.$themaincat.'" limit="1" autoplay="0" arrows="no" width="640" height="360" link="post" mousewheel="no" pages="no" class="deportes-slider"]');

$even = 0; ?> 
	<?php if( have_posts() ) : ?>

		<?php get_template_part( 'deportes-loop-header' ); ?>

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

include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-300x250-category-page-center.php');


echo '</div>';
		$even++;
		$float='right';
	}
	if ($even == 3)
	{
		echo '<div style="width:100%;position:relative;float:left;">';
	include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-468x60-category-page.php');	
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
<?php get_sidebar('aqui-entre-nos'); ?>

<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-ad-widget-aqui-entre-nos-bottom-728x90.php'); echo ""; } ?>

<?php //echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); ?>
<?php get_footer(); ?>
