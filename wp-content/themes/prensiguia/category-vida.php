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
responsive_wrapper(); // before wrapper container hook 
echo '<div id="wrapper" class="clearfix">';
responsive_wrapper_top(); // before wrapper content hook 
responsive_in_wrapper(); // wrapper hook 

echo '<div id="content-archive" style="margin-top:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';

$category = get_the_category(); 
$themaincat = 1675;
//var_dump($category);
//$single_cat_title = $category[0]->cat_name;
$single_cat_title = 'Vida';
//$themaincat = $category[0]->cat_ID;
//$single_cat_title = $category[0]->cat_name;

echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/espectaculo/"><div class="title-left">VIDA</div><div class="twodots"></div></a>[/doap_heading]'); 

echo do_shortcode('[doap_slider source="category: '.$themaincat.'" limit="4" width="640" height="360" link="post" mousewheel="no" pages="no" class="deportes-slider"]');

$even = 0; ?> 
	<?php if( have_posts() ) : ?>

		<?php get_template_part( 'deportes-loop-header' ); ?>

		<?php while( have_posts() ) : the_post(); ?>
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
						echo "<div style=float:left;position:relative;width:100%;>";
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
					 echo "<div style=max-float:left;position:relative;>";
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
		endwhile;

                echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
		//get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-archive -->


<?php //my_pagination(); ?>
<?php get_sidebar('vida'); ?>

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
<?php //echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); ?>
<?php get_footer(); ?>
