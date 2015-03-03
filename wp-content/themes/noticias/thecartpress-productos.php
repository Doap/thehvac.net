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

<div id="content" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">
<?php echo do_shortcode('[doap_spacer size="20"][xyz-ips snippet="promociones-video-widget"]'); ?>
<h2>La tienda de La Prenasa</h2>
	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'loop-header' ); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta-page' ); ?>

				<div class="post-entry">
					<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
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
	//	get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
