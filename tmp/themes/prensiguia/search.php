<?php
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
	$query_split = explode("=", $string);
	$search_query[$query_split[0]] = urldecode($query_split[1]);
} // foreach

$search = new WP_Query($search_query);
?>
<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Search Template
 *
 *
 * @file           search.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/search.php
 * @link           http://codex.wordpress.org/Theme_Development#Search_Results_.28search.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<?php include(STYLESHEETPATH . '/home-adblock.php'); ?>

<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix" style="background-color:#fff;border:1px solid #000;">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>

<div id="content-search" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">
<?php if (isset($_GET['s'])) { ?>
<div style="width:40%;background-color:#fff;position:relative;float:right;padding-left:20px;padding-right:20px;;margin:0px;height:50px;"> <?php get_search_form(); ?> </div>
<?php } ?>

	<?php if( have_posts() ) : ?>

		<?php get_template_part( 'loop-header' ); ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta' ); ?>

				<div class="post-entry">
				<style>.post-entry p {margin:.7em 0;}</style>
					<?php
//					if(
if ( has_post_thumbnail() ) {

//the_post_thumbnail();
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-150' ); 
$post_url = get_permalink($post->ID);
$title = the_title_attribute('echo=0');
$feat_image = $feat_image_array[0];
echo '<div style="max-width:150px;float:left;padding-left:10px;padding-right:10px;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
echo '</div><a href="' . $post_url . '"><h5 style="margin-bottom:0;">'. $title . '</h5></a>';
}
 responsive_pro_get_option( 'search_post_excerpts' );
						add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
						the_excerpt();
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div>
				<!-- end of .post-entry -->

				<?php get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<div><?php echo get_the_term_list( $post->ID, 'category', 'Categoría: ', ', ', '' ); ?></div>
			<div><?php echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' ); ?></div>
			<?php responsive_entry_after(); ?>

		<?php
		endwhile;

echo '<div style="position:relative;float:left;">'; numeric_posts_nav(); echo '</div>';
//		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-search -->

<?php get_sidebar('index'); ?>
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>
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

<?php get_footer(); ?>
