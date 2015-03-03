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
    
/* home slots */
googletag.defineSlot('/11648707/Portada-Bottom-300x250px', [300, 250], 'div-gpt-ad-1403198971774-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Top-728x90', [728, 90], 'div-gpt-ad-1403199951031-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Top-270x90', [270, 90], 'div-gpt-ad-1403223429448-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Top-300x250px', [300, 250], 'div-gpt-ad-1403198971774-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Bottom-728x90', [728, 90], 'div-gpt-ad-1403199951031-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Left-160x600', [160, 600], 'div-gpt-ad-1403200779714-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Right-160x600', [160, 600], 'div-gpt-ad-1403200779714-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Middle-728x90', [728, 90], 'div-gpt-ad-1403199951031-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/120x600-Top', [120, 600], 'div-gpt-ad-1403371468819-0').addService(googletag.pubads());

/* botones 1-5 sidebar slots */
googletag.defineSlot('/11648707/Portada-boton-1-300x120', [300, 120], 'div-gpt-ad-1403222233029-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-2-300x120', [300, 120], 'div-gpt-ad-1403222233029-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-3-300x120', [300, 120], 'div-gpt-ad-1403222233029-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-4-300x120', [300, 120], 'div-gpt-ad-1403222233029-3').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-5-300x120', [300, 120], 'div-gpt-ad-1403222233029-4').addService(googletag.pubads());

googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>


<?php global  $wpdb; $user_id = get_current_user_id(); $qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'"; $avalidgoogleid = $wpdb->get_results( $qry ); foreach ( $avalidgoogleid as $avalidgoogleid ) { $gid = $avalidgoogleid ->identifier; $uemail  = $avalidgoogleid ->email; $websiteurl = $avalidgoogleid ->websiteurl; }
 ?>

<?php
if ($gid > 10000000 )  {
        include(STYLESHEETPATH . '/page-wing-ads-loggedin.php');
        include(STYLESHEETPATH . '/backpages-top-loggedin.php');
} else {
        include(STYLESHEETPATH . '/page-wing-ads.php');
        include(STYLESHEETPATH . '/banner-ad-widget-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-270x90.php');
}

?>

<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>

<?php
if ( is_tag() ) {
$term_id = get_query_var('tag_id');
$taxonomy = 'post_tag';
$args ='include=' . $term_id;
$terms = get_terms( $taxonomy, $args );
//echo '<p> slug is ' . $terms[0]->slug . '</p>';
}
?>
 <?php $thetag = $terms[0]->slug; $the_clean_tag = ucwords(str_replace("-", " ", $thetag)); ?> 
<div id="content-archive" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">



<?php /* 

echo do_shortcode('   


[doap_row class="footer-information"]
[doap_column size="3/4"]



[doap_tabs  style="flat-blue"] 


   [doap_tab title="<div id=thetabs>Destacados</div>"]
	[doap_slider source="category: 32" limit="4" link="post" mousewheel="no" width="640" height="360" pages="no" autoplay="20000" class="home-main-slider"]   
   [/doap_tab]

 
 [doap_tab title="<div id=thetabs>Último hora</div>"] 
<div style="height:220px;max-width:670px;background-color:#fff;padding:20px;overflow:scroll;overflow-x:hidden;">
[doap_list icon="icon: check" icon_color="#369"]
[doap_posts template="templates/list-ultimo-hora.php" posts_per_page="40" tax_term="2293,3518,1625,3514,1673,3515,25,26,17,31,22,3516,1626,21,10,3,3132,3519,27,32,1676,3517,24,30,991,1277,1675" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,107,115,120,106,104,105,119,109" order="desc" post_parent="  " ignore_sticky_posts="yes"]
[/doap_list]
</div>


 [/doap_tab]

 [doap_tab title="<div id=thetabs>Mas leidas</div>"]
<div style="height:220px;max-width:670px;background-color:#fff;padding:20px;overflow:scroll;overflow-x:hidden;">
[doap_list icon="icon: check" icon_color="#369"]
[doap_posts template="templates/list-mas-leidas.php" posts_per_page="40"  tax_term="2293,3518,1625,25,26,17,35752,31,22,1626,21,3,3132,3519,27,1676,3517,24,30,991" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" order="desc" orderby="comment_count" post_parent="  " ignore_sticky_posts="yes"]
[/doap_list]
</div>
  [/doap_tab]

   [/doap_tabs] 
[/doap_column]
[doap_column size="1/4"]
<div id="cat-page-ad" style="position:relative;left:-15px;">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- short-vert -->
<ins class="adsbygoogle"
     style="display:inline-block;width:120px;height:240px"
     data-ad-client="ca-pub-6970273280466483"
     data-ad-slot="6979461869"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
[doap_button url="http://noticias.laprensa.com.ni/lptv/" style="soft" background="#369" color="#fff" size="4" wide="yes" center="yes" icon="icon: youtube-play" icon_color="#52c537" text_shadow="0px 0px 0px #369" desc="Programa de hoy" class="daves-sample-menu-item"]Reproduce[/doap_button]

</div>
[/doap_column]
[/doap_row]
'); */
?>




<?php //echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]Etiquetas: ' . $the_clean_tag . '[/doap_heading][/doap_animate]'); ?>
<?php //echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]Etiquetas: ' . $the_clean_tag . '[/doap_heading]'); ?>
	<?php if( have_posts() ) : ?>

		<?php get_template_part( 'loop-header' ); ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div  style="border:0px solid #fff; margin-right:5px;margin-top:15px;padding:5px;width:97%;position:relative;float:left;padding-right:15px;" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php //responsive_entry_top(); ?>

				<?php //get_template_part( 'tag-meta' ); ?>
        <?php $theexcerpt = get_the_excerpt(); $thepermalink = get_the_permalink(); echo do_shortcode('<a href="' . $thepermalink . '" title="Leer mas"><div style="position:relative;top:0px;"><h4>'.ucfirst(get_the_title()).'</h4></div></a>'); ?>

<div style="position:relative;float:left;padding-left:0px;padding-top:5px;padding-bottom:3px;"><?php _e( 'Publicado ', 'su' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?></div>
				<div class="post-entry">
<?php $gmt_timestamp = get_post_time('U', true); ?>
<?php //tcp_posted_on(); ?>


<?php if ( has_post_thumbnail() ) {

//the_post_thumbnail();

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
//echo do_shortcode('[doap_lightbox type="image" src="' . $feat_image . '" class="story-image"]<div style="position:absolute;top:20px;left:600px;">[doap_button style="soft" background="#369" color="#ffffff" size="0" wide="no" radius="5" icon_color="#ffffff"  icon="icon:search-plus"][/doap_button]</div>[/doap_lightbox]');

$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-150' );
$post_url = get_permalink($post->ID);
$feat_image = $feat_image_array[0];
echo '<div style="max-width:150px;float:left;padding-left:10px;padding-right:10px;position:relative;float:right;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
echo '</div>';
} else { $thecategory = get_the_category(); $thecat = strtolower($thecategory[0]->cat_name); ?>
<div style="float:right;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/laprensanota-<?php echo $thecat; ?>.jpg" draggable="false"> </div><?php } ?>
					<?php
					//responsive_pro_featured_image();

					if( responsive_pro_get_option( 'archive_post_excerpts' ) ) {
						add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					echo "<div style=max-width:90%;float:left;position:relative;>";	
						$the_excerpt = get_the_excerpt(); //echo $the_excerpt;
						$the_content = strip_tags(get_the_content()); //echo $the_content;
						//echo do_shortcode('[doap_tooltip style="light" position="north" shadow="yes" rounded="yes" size="2" content="'.$the_content.'" class="todays-news"]'. $the_excerpt .'[/doap_tooltip]'); 
						the_excerpt();
					echo "</div>";	
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					}
					else {
						//the_content( __( 'Read more &#8250;', 'responsive' ) );
						add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					echo "<div style=max-width:90%;float:left;position:relative;>";	
						$the_excerpt = get_the_excerpt(); //echo $the_excerpt;
						$the_content = get_the_content(); //echo $the_content;
						//echo do_shortcode('[doap_tooltip style="light" position="north" shadow="yes" rounded="yes" size="2" content="'. $the_content .'" class="todays-news"]'. $the_excerpt .'[/doap_tooltip]'); 
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
//get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-archive -->
<?php //my_pagination(); ?>
<?php get_sidebar(); ?>
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>
<?php //echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); ?>
<?php get_footer(); ?>
