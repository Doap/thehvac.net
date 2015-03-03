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

<div class="limpiar" style="clear:both;">&nbsp;</div>
<script type='text/javascript'>
(function() {
var useSSL = 'https:' == document.location.protocol;
var src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
})();
</script>

<script type='text/javascript'>
googletag.defineSlot('/11648707/LP_Portada_banner2(160x600)', [160, 600], 'div-gpt-ad-1398207914431-0').addService(googletag.pubads());
googletag.pubads().enableSyncRendering();
googletag.pubads().enableSingleRequest();
googletag.enableServices();
</script>

<div id="leftad" class="banner_flotanteizq" style="float:left;margin-left:-169px;background-color:#369;height:600px;width:160px;top:0px;position:absolute;">
<div id='div-gpt-ad-1398207914431-0' style='width:160px; height:600px;'>
<script type='text/javascript'>
googletag.display('div-gpt-ad-1398207914431-0');
</script>
</div></div>

<div id="rightad" class="banner_flotanteizq" style="float:left;margin-left:1006px;background-color:#369;height:600px;width:160px;top:0px;position:absolute;"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Responsive caricaturas header -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6970273280466483"
     data-ad-slot="3397531465"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>


</div>

<?php
$archive_year  = get_the_time('Y');
$archive_month = get_the_time('m');
$archive_day   = get_the_time('d');
?>

<?php $thetag = "test"; ?> 
<div id="content-archive" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">

<?php echo do_shortcode('[xyz-ips snippet="tag-widget"]'); 
$count_posts = wp_count_posts();
echo "<div style=position:relative;float:right;color:#fff;padding:10px;>Notas:".$count_posts->publish."</div>";
?>
<?php //echo do_shortcode('[doap_animate type="lightSpeedIn"]<h2>Etiquetas: ' . $thetag . '</h2>[/doap_animate]'); ?>
<div style="padding:15px;max-width:850px;background-color:#369;">
	<h3 style="width:300px;position:relative;align:left;"><font color="#ffffff">Archivo de La Prensa</font></h3>
<div style="width:100px;position:relative;float:right;max-height:90px;top:-10px;">
<?php
$archive_year  = get_the_time('Y');
$_year = get_the_time('Y');
$archive_month = get_the_time('m');
$month_of_year = get_the_time('m');
$archive_day   = get_the_time('d');
$day_of_month = get_the_time('d');


?>
<a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>">Todays News</a>
<img class="thumbnail align-right" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/calendario.jpg" style="max-width:100%" alt=""></div>
<div style="position:relative;margin-left:15px;font-size:2em;color:#ffffff"><?php $pfx_date = get_the_date( $d ); echo $pfx_date; ?></div>


<form method="get" action="<?php echo home_url( '/' ); ?>">
    <select name="day">
    <?php foreach( range(1,31) as $day_of_month ) : ?>
        <option><?php echo $day_of_month; ?></option>
    <?php endforeach; ?>
    </select>
    <select name="monthnum">
    <?php foreach( range(1,12) as $month_of_year ) : ?>
        <option><?php echo $month_of_year; ?></option>
    <?php endforeach; ?>
    </select>
    <select name="year">
    <?php foreach( range(2014,2000) as $_year ) : ?>
        <option><?php echo $_year; ?></option>
    <?php endforeach; ?>
    </select>
    <input type="submit" id="searchsubmit" value="Obtener mi edición" style="position:relative;left:10px;" />
</form>
</div>
<?php //archive_calendar(); ?>
<?php // display range of dates for copyright @ digwp.com
function copyrightDate() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("
		SELECT 
			YEAR(min(post_date_gmt)) AS firstdate, 
			YEAR(max(post_date_gmt)) AS lastdate 
		FROM 
			$wpdb->posts
	");
	if($copyright_dates) {
		$copyright = "Copyright &copy; " . $copyright_dates[0]->firstdate;
		if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
			$copyright .= '-' . $copyright_dates[0]->lastdate;
		}
		echo $copyright . "&nbsp;" . get_bloginfo('name');
	}
}
//add_filter('wp_footer', 'copyrightDate');
?>

<h2><?php single_tag_title('Tag: '); ?></h2>

	<?php if( have_posts() ) : ?>

		<?php get_template_part( 'loop-header' ); ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div  style="border:1px solid #ccc; margin-right:5px;margin-top:15px;padding:5px;width:97%;position:relative;float:left;padding-right:15px;" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta' ); ?>
				<?php //get_template_part( 'author-meta' ); ?>

				<div class="post-entry">
<?php $gmt_timestamp = get_post_time('U', true); ?>
<?php //tcp_posted_on(); ?>


<?php if ( has_post_thumbnail() ) {

//the_post_thumbnail();

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
//echo do_shortcode('[doap_lightbox type="image" src="' . $feat_image . '" class="story-image"]<div style="position:relative;float:right;top:20px;left:5px;">[doap_button style="soft" background="#369" color="#ffffff" size="0" wide="no" radius="5" icon_color="#ffffff"  icon="icon:search-plus"][/doap_button]</div>[/doap_lightbox]');

echo "<div style=max-width:40%;height:200px;float:right;overflow:hidden;>";
					responsive_pro_featured_image();
echo "</div>";
} else { $thecategory = get_the_category(); $thecat = strtolower($thecategory[0]->cat_name); ?>
<div style="float:right;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/laprensanota-<?php echo $thecat; ?>.jpg" draggable="false"> </div><?php } ?>
					<?php
					//responsive_pro_featured_image();

					if( responsive_pro_get_option( 'archive_post_excerpts' ) ) {
						add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					echo "<div style=max-width:50%>";	
						the_excerpt();
					echo "</div>";	
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					}
					else {
						//the_content( __( 'Read more &#8250;', 'responsive' ) );
						add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					echo "<div style=max-width:50%>";	
						the_excerpt();
					echo "</div>";	
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					} ?><div id="cat-tax">
<?php $taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
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
	//	get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-archive -->
<?php //my_pagination(); ?>
<?php get_sidebar(); ?>
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>
<?php get_footer(); ?>
