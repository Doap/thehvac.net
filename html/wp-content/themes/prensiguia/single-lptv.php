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

get_header('lptv'); ?>

<?php //include(STYLESHEETPATH . '/single-adblock.php'); ?>
<?php include(STYLESHEETPATH . '/single-adblock-lptv.php'); ?>

<?php
global  $wpdb; $user_id = get_current_user_id(); $qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'"; $avalidgoogleid = $wpdb->get_results( $qry ); foreach ( $avalidgoogleid as $avalidgoogleid ) { $gid = $avalidgoogleid ->identifier; $uemail  = $avalidgoogleid ->email; $websiteurl = $avalidgoogleid ->websiteurl; }
?>

<?php

$category = get_the_category();   //echo $category[0]->cat_name;

?>

<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>

<div id="content">

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
//responsive_pro_featured_image();
//echo '<div style="clear:both;"></div>';
//echo '<hr>';
}
 ?>

<?php //the_content("Testing " . the_title('', '', false)); ?>

<?php echo do_shortcode('


[doap_tabs style="modern-light" class="product-library"]

[doap_tabs class="my-lptv-tabs"]
  [doap_tab title="CLIP"][xyz-ips snippet="lptv-single-vid"][/doap_tab]
        
        [doap_tab title="Activos"] 
        [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]
                        <a href="https://www.youtube.com/playlist?list=PLLSDIHSJqOp3-RnU0WJrV_TM3e_ftKzqg"><div class="title-left">ACTIVOS</div><div class="twodots"></div></a>
        [/doap_heading] 
        <iframe width="853" height="480" src="//www.youtube.com/embed/videoseries?list=PLLSDIHSJqOp3-RnU0WJrV_TM3e_ftKzqg" frameborder="0" allowfullscreen></iframe>
        [/doap_tab]


        [doap_tab title="Ambitos"] 
        [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]
                        <a href="https://www.youtube.com/playlist?list=PLLSDIHSJqOp3LKyU4LTqa5M29E6qIASl1"><div class="title-left">AMBITOS</div><div class="twodots"></div></a>
        [/doap_heading] 
        <iframe width="853" height="480" src="//www.youtube.com/embed/videoseries?list=PLLSDIHSJqOp3LKyU4LTqa5M29E6qIASl1" frameborder="0" allowfullscreen></iframe>
        [/doap_tab]
        
        [doap_tab title="Departamentales"] 
        [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]
                        <a href="https://www.youtube.com/playlist?list=PLLSDIHSJqOp2lxsZEt3ygHPZhFlSrstcA"><div class="title-left">DEPARTAMENTALES</div><div class="twodots"></div></a>
        [/doap_heading] 
        <iframe width="853" height="480" src="//www.youtube.com/embed/videoseries?list=PLLSDIHSJqOp2lxsZEt3ygHPZhFlSrstcA" frameborder="0" allowfullscreen></iframe>
        [/doap_tab]

        [doap_tab title="Editorial"] 
        [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]
                        <a href="https://www.youtube.com/playlist?list=PLLSDIHSJqOp06_HluZqmJNopcxe9IRwkP"><div class="title-left">EDITORIAL</div><div class="twodots"></div></a>
        [/doap_heading] 
        <iframe width="853" height="480" src="//www.youtube.com/embed/videoseries?list=PLLSDIHSJqOp06_HluZqmJNopcxe9IRwkP" frameborder="0" allowfullscreen></iframe>
        [/doap_tab]

        [doap_tab title="Internacionales"] 
        [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]
                        <a href="https://www.youtube.com/playlist?list=PLLSDIHSJqOp38y3BtXOFfCPXNgDldZWxr"><div class="title-left">INTERNACIONALES</div><div class="twodots"></div></a>
        [/doap_heading] 
        <iframe width="853" height="480" src="//www.youtube.com/embed/videoseries?list=PLLSDIHSJqOp38y3BtXOFfCPXNgDldZWxr" frameborder="0" allowfullscreen></iframe>
        [/doap_tab]

        [doap_tab title="Deportes"] 
        [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]
                        <a href="https://www.youtube.com/playlist?list=PLLSDIHSJqOp3ZHxN1xafQ6iOXgxP5qgGS"><div class="title-left">DEPORTES</div><div class="twodots"></div></a>
        [/doap_heading] 
        <iframe width="853" height="480" src="//www.youtube.com/embed/videoseries?list=PLLSDIHSJqOp3ZHxN1xafQ6iOXgxP5qgGS" frameborder="0" allowfullscreen></iframe>
        [/doap_tab]

        [doap_tab title="Politica"] 
        [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]
                        <a href="https://www.youtube.com/playlist?list=PLLSDIHSJqOp0BCVjr5OwTcS_YUDbSQXgU"><div class="title-left">POLITICA</div><div class="twodots"></div></a>
        [/doap_heading] 
        <iframe width="853" height="480" src="//www.youtube.com/embed/videoseries?list=PLLSDIHSJqOp0BCVjr5OwTcS_YUDbSQXgU" frameborder="0" allowfullscreen></iframe>
        [/doap_tab]

        [doap_tab title="Vida"] 
        [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]
                        <a href="https://www.youtube.com/playlist?list=PLLSDIHSJqOp206h7C2U1k_bClIZeuaEev"><div class="title-left">Vida</div><div class="twodots"></div></a>
        [/doap_heading] 
        <iframe width="853" height="480" src="//www.youtube.com/embed/videoseries?list=PLLSDIHSJqOp206h7C2U1k_bClIZeuaEev" frameborder="0" allowfullscreen></iframe>
        [/doap_tab]


[/doap_tabs]

<!--
  IMPORTANT
  You need to add this CSS code to the custom CSS editor at plugin settings page
-->
<style>
  .su-tabs.my-lptv-tabs { background-color: #f5f5f5; }
  .su-tabs.my-lptv-tabs .su-tabs-nav span { font-size: 1.3em }
  .su-tabs.my-lptv-tabs .su-tabs-nav span.su-tabs-current { background-color: #369 }
  .su-tabs.my-lptv-tabs .su-tabs-pane {
    padding: 1em;
    font-size: 1.3em;
    background-color: #f5f5f5;
  }
</style>
'); ?>

<?php
//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/lptv"><div class="title-left">VIDEOS DEL DIA</div><div class="twodots"></div></a>[/doap_heading]');
?>



<?php //echo do_shortcode('<div style="position:relative;left:0px;">[doap_posts template="templates/box-loop-videos2.php" tax_term="19" posts_per_page="6" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" orderby="date" post_parent=" " ignore_sticky_posts="no"]</div>'); ?>



<?php
//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/lptv"><div class="title-left">VIDEOS DESTACADOS</div><div class="twodots"></div></a>[/doap_heading]');
?>

<?php echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/lptv"><div class="title-left">ARCHIVO</div><div class="twodots"></div></a>[/doap_heading][doap_posts template="templates/box-loop-videos3.php" tax_term="19" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" orderby="comment_count" post_parent=" " ignore_sticky_posts="no"]'); ?>


					<?php //the_content( __( 'Leer mas &#8250;', 'responsive' ) ); ?>


				<!-- end of .post-entry -->
				<?php //get_template_part( 'post-data-single' ); ?>



<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else {

$category = get_the_category(); 
//echo $category[0]->cat_name;


//include(STYLESHEETPATH . '/ad-300x250-category-page-center.php'); echo ""; 
}
?>
<div style="width:468px;display:none;" class="linkstrips">
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


<?php //echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/suplemento"><div class="title-left">COMENTARIOS</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); ?>

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
echo '<div id=ad-bottom-lptv class=phonehide style="width:728px;border:1px solid #000;height:90px;margin:0 auto;">';
if ($gid > 10000000)  { 
	include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); 
} else { 
	include(STYLESHEETPATH . '/banner-ad-widget-single-bottom-728x90.php'); echo ""; 
} 

echo "</div>";
?>


<?php get_footer('lptv'); ?>
