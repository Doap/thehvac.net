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

<?php include(STYLESHEETPATH . '/single-adblock.php'); ?>

<?php
global  $wpdb; $user_id = get_current_user_id(); $qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'"; $avalidgoogleid = $wpdb->get_results( $qry ); foreach ( $avalidgoogleid as $avalidgoogleid ) { $gid = $avalidgoogleid ->identifier; $uemail  = $avalidgoogleid ->email; $websiteurl = $avalidgoogleid ->websiteurl; }
?>

<?php

//$category = get_the_category();   //echo $category[0]->cat_name;

if ($gid > 10000000 )  {
        include(STYLESHEETPATH . '/page-wing-ads-loggedin.php');
        include(STYLESHEETPATH . '/backpages-top-loggedin.php');
}
else
{
	include(STYLESHEETPATH . '/page-wing-ads.php');
}
include(STYLESHEETPATH . '/banner-ad-widget-728x90.php');
include(STYLESHEETPATH . '/banner-ad-widget-270x90.php');
?>

<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>

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
//$single_cat_title = str_replace(" ","-",$category[0]->cat_name);

echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'"><div class="title-left">'.str_replace("-"," ",mb_strtoupper($single_cat_title)).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]');

?>

<?php //echo do_shortcode('<div style="width:100%;height:40px;position:relative;align:right;float:right;border:1px solid #fff;padding:0px;margin:0px;"><div style="width:450px;float:right;">[hupso]</div></div>'); ?>
<?php get_template_part( 'loop-header' );  ?>

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta' ); ?>

				<div class="post-entry">
					<?php 
$video_thumb = get_post_meta( $post->ID, '_video_thumbnail', true );
$lptv = get_post_meta( $post->ID, 'lptv_post', true );
// if ( has_post_thumbnail() && !$lptv) {
 if ( has_post_thumbnail() && !$video_thumb ) {
?>
<?php
//$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

//$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-450' );
//$post_url = get_permalink($post->ID);
//$feat_image = $feat_image_array[0];
//echo '' . PHP_EOL . '<img src="' . $feat_image . '">' . PHP_EOL;
//echo '<hr>';
responsive_pro_featured_image();
//echo '<div style="clear:both;"></div>';
//echo '<hr>';
}
 ?>

					<?php the_content( __( 'Leer mas &#8250;', 'responsive' ) ); ?>

					<?php if( get_the_author_meta( 'description' ) != '' ) : ?>

						<div id="author-meta">
							<?php if( function_exists( 'get_avatar' ) ) {
								echo get_avatar( get_the_author_meta( 'email' ), '80' );
							} ?>
							<div class="about-author"><?php _e( 'About', 'responsive' ); ?> <?php the_author_posts_link(); ?></div>
							<p><?php the_author_meta( 'description' ) ?></p>
						</div><!-- end of #author-meta -->

					<?php endif; // no description, no author's meta ?>

					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div>
				<!-- end of .post-entry -->
				<?php get_template_part( 'post-data-single' ); ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else {

$category = get_the_category(); 
echo $category[0]->cat_name;
include(STYLESHEETPATH . '/ad-300x250-top-none.php');
//include(STYLESHEETPATH . '/ad-300x250-category-page-center.php'); echo ""; 
}
?>





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
		endwhile;
//echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
	get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

<?php 
//echo do_shortcode('[doap_spacer size="20"]'); 
//echo do_shortcode('[xyz-ips snippet="single-page-tag-cloud"]'); 
?>

</div><!-- end of #content -->

<?php //get_sidebar('single'); ?>
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php 
//echo '<div style="width:100%;border:1px solid #000;height:90px;margin:0 auto;">';
if ($gid > 10000000)  { 
	include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); 
}
else
{ 
	include(STYLESHEETPATH . '/banner-ad-widget-single-bottom-728x90.php');
	echo ""; 
}
	//include(STYLESHEETPATH . '/banner-ad-widget-single-bottom-728x90.php'); echo ""; 

//echo "</div>";
?>


<?php get_footer(); ?>
