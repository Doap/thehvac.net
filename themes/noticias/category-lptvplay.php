<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Deportes Template
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

get_header('lptv'); ?>

<?php include('/var/www/html/lpmu/wp-content/themes/noticias' . '/lptv-page-wing-ads.php'); ?>


<?php $thetag = "test"; //$cat_string = single_tag_title('Categoría: '); ?> 
<div style="width:100%;" id="content-archive" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">
<?php include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-ad-widget.php'); ?>

<?php echo do_shortcode('[doap_spacer size="73"]'); ?>

 <?php /* <iframe src=https://s3-us-west-2.amazonaws.com/s3.laprensa.com.ni/home/nadia/animavideo/index.html height=120 width=450></iframe> */  ?>

<div style="width:100%;">

<div style="position:relative;float:right;padding-right:30px;">
<?php //echo do_shortcode('[xyz-ips snippet="date-widget"]'); ?>
</div>

<?php echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/lptv"><div class="title-left">VIDEOS DEL DIA</div><div class="twodots"></div></a>[/doap_heading]'); ?>

<?php echo do_shortcode('
[xyz-ips snippet="lptv-homepage-autoplay"]


[doap_tabs style="modern-light" class="product-library"]

[doap_tabs class="my-lptv-tabs"]
  [doap_tab title="^"] [/doap_tab]
  [doap_tab title="Mas Vistos "][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/lptv"><div class="title-left">MAS VISTOS</div><div class="twodots"></div></a>[/doap_heading][doap_posts template="templates/box-loop-videos.php" tax_term="19" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" orderby="comment_count" post_parent=" " ignore_sticky_posts="no"] [/doap_tab]
  [doap_tab title="Moda"] [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tag/moda"><div class="title-left">MODA</div><div class="twodots"></div></a>[/doap_heading] [/doap_tab]
  [doap_tab title="Belleza"] [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tag/belleza"><div class="title-left">BELLEZA</div><div class="twodots"></div></a>[/doap_heading] [/doap_tab]
  [doap_tab title="Miercoles Frescos"] [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tag/miercoles-frescos"><div class="title-left">MIERCOLES FRESCOS</div><div class="twodots"></div></a>[/doap_heading] [/doap_tab]
  [doap_tab title="Salud"] [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/salud"><div class="title-left">SALUD</div><div class="twodots"></div></a>[/doap_heading] [/doap_tab]
  [doap_tab title="Familia"] [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/familia"><div class="title-left">FAMILIA</div><div class="twodots"></div></a>[/doap_heading] [/doap_tab]
  [doap_tab title="Farandula"] [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tag/farandula"><div class="title-left">FARANDULA</div><div class="twodots"></div></a>[/doap_heading] [/doap_tab]
  [doap_tab title="Noticiero LPTV"] [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tag/noticiero-lptv"><div class="title-left">NOTICIERO LPTV</div><div class="twodots"></div></a>[/doap_heading] [/doap_tab]
  [doap_tab title="Opinion"] [doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/opinion"><div class="title-left">OPINION</div><div class="twodots"></div></a>[/doap_heading] [/doap_tab]
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

<?php
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/lptv"><div class="title-left">VIDEOS DESTACADOS</div><div class="twodots"></div></a>[/doap_heading]');
?>

	<?php 
  if( have_posts() ) : ?>

		<?php get_template_part( 'loop-header' ); ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div  style="-webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px;border:1px solid #ccc; margin-right:5px;position:relative;float:left;min-height:230px;width:300px;margin-bottom:10px;margin-right:20px;" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php responsive_entry_top(); ?>

        <?php 	
		$theexcerpt = get_the_excerpt(); 
		$thepermalink = get_the_permalink(); 
	?>


				<div class="post-entry">
<?php $gmt_timestamp = get_post_time('U', true); ?>

<?php if ( has_post_thumbnail() ) {

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-300' );
$post_url = get_permalink($post->ID);
$feat_image = $feat_image_array[0];
echo '<div style="max-width:280px;align-left:auto;align-right:auto;padding-bottom:5px;margin-bottom:10px;padding-left:10px;padding-right:10px;padding-top:5px;position:relative;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
echo '</div>';

} else { ?>
<div style="width:280px;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/laprensanota.jpg" draggable="false"> </div><?php } ?> 
					<?php
					//responsive_pro_featured_image();

					if( responsive_pro_get_option( 'archive_post_excerpts' ) ) {
						add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
						echo "<div style=max-width:98%;float:left;position:relative;>";
                                                $the_excerpt = get_the_excerpt(); //echo $the_excerpt;
	echo do_shortcode('<a href="' . $thepermalink . '" title="Leer mas"><div id="lptv-note-titles">doap_animate type="fadeIn"]<h4>'.ucfirst(get_the_title()).'</h4>[/doap_animate]</div></a>'); 
                                        echo "</div>";
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					}
					else {
						add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					 echo "<div style=max-width:98%;float:left;position:relative;>";
                                                $the_excerpt = get_the_excerpt(); //echo $the_excerpt;
                                                $the_content = get_the_content(); //echo $the_content;
remove_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        $theexcerpt = get_the_excerpt();
        add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        $words = str_word_count($theexcerpt, 2);
        $pos = array_keys($words);
        if (!array_key_exists('50', $pos))
        {
                $exp_pos = count($pos) - 1;
        }
        else
        {
                $exp_pos = 50;
        }
        $theexcerpt = '<div style="padding-left:10px;" id="lptv-excerpt">' . substr($theexcerpt, 0, $pos[$exp_pos]) . '</div>' . PHP_EOL;
        echo $theexcerpt;
                                        echo "</div>";
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					} ?>

<?php
					wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
					?>
				</div>
				<!-- end of .post-entry -->





				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>
		<?php
		endwhile;

                echo '<div style="position:relative;float:right;top:-5px;">'; wpbeginner_numeric_posts_nav(); echo '</div>';

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-archive -->
<style>
#top-bar { display:none; }
</style>

<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>
<?php get_footer(lptv); ?>

