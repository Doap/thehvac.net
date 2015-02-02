<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pages Template
 *
 *
 * @file           page.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<div style="clear:both;"></div>
<div id="topad" style="width:728px;height:90px;background-color:#eee;border:0px solid #000;position:relative;float:left;margin-top:4px;overflow:visible;"></div>
<div id="topsidead" style="position:relative;float:right;width:260px;height:90px;margin-left:4px;margin-top:4px;z-index:10000;overflow:visible;background-color:#eee;"></div>
<div style="clear:both;"></div>

<?php include('/var/www/html/lpmu/wp-content/themes/noticias' . '/page-wing-ads.php'); ?>

<div id="content" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">

<?php include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-ad-widget.php');  ?>
<?php //echo do_shortcode('[doap_spacer size="0"]'); ?>

<?php //echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($pagename).'/"><div class="title-left">'.str_replace("-"," ",strtoupper($pagename)).'</div><div class="twodots"></div></a>[/doap_heading]'); ?>

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'loop-header' ); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php //get_template_part( 'post-meta-page' ); ?>

				<div class="post-entry">
					<?php the_content( __( 'Leer mas &#8250;', 'responsive' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Paginas:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div>
				<!-- end of .post-entry -->

				<?php get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

			<?php responsive_comments_before(); ?>
			<?php comments_template( '', true ); ?>
			<?php responsive_comments_after(); ?>

		<?php
		endwhile;

                echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content -->

<?php get_sidebar('deportes'); ?>
<?php get_footer(); ?>
