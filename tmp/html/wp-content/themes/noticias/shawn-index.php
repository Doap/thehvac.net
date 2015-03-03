<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Index Template
 *
 *
 * @file           index.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/index.php
 * @link           http://codex.wordpress.org/Theme_Development#Index_.28index.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>
<?php 
$archive_year  = get_the_time('Y'); 
$archive_month = get_the_time('m'); 
$archive_day   = get_the_time('d'); 
?>
<a href="<?php //echo get_day_link( $archive_year, $archive_month, $archive_day); ?>"></a>

<div id="content" class="grid col-620">
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

<div style="position:absolute;float:left;top:130px;;left:20px;max-width:450px;max-height:333px;z-index:10000;">
<div style="max-width:450px;">
<?php //echo do_shortcode('[doap_spoiler title="Noticias de última hora" open="yes" style="simple" icon="chevron" anchor="expose-video-frame"][doap_slider source="category: 3" limit="5" width="100%" height="370" title="yes" paging="no" responsive="yes" arrows="yes"][/doap_spoiler]'); ?></div>
</div>
<div class="limpiar" style="clear:both;">&nbsp;</div>

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta-page' ); ?>

				<div class="post-entry">
					<?php if( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail(); ?>
						</a>
					<?php endif; ?>
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

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content -->
<?php get_sidebar(); ?>




<?php echo do_shortcode('[doap_spacer height=60]'); ?>
<?php //echo do_shortcode('[doap_spacer height=260]'); ?>
<?php echo "<div style=z-index:0;position:relative;top:0;border:1px solid #cccccc;>"; ?>
<div style="padding-left:0px;padding-top:5px;padding-bottom:15px;position:relative;left:0px;top:0px;" class="desacados_bar">
<div id="destacados">
<?php echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/destacados">Destacados</a>[/doap_heading][/doap_animate]'); ?>
<div style="position:relative;float:left;height:300px;width:240px;margin-right:10px;">
<h5 style="background-color:#4c4c4c;color:#fff;position:relative;top:20px;width:100px;padding-left:15px;padding-top:5px;height:20px;">Activos</h5>
<?php echo do_shortcode(' [tcp_list id="posts_destacados_activos"] '); ?>
</div>
<div style="position:relative;float:left;height:300px;width:240px;margin-right:10px;">
<h5 style="background-color:#4c4c4c;color:#fff;position:relative;top:20px;width:100px;padding-left:15px;padding-top:5px;height:20px;">Ambitos</h5>
<?php echo do_shortcode(' [tcp_list id="posts_destacados_ambitos"] '); ?>
</div>
<div style="position:relative;float:left;height:300px;width:240px;margin-right:10px;">
<h5 style="background-color:#4c4c4c;color:#fff;position:relative;top:20px;width:100px;padding-left:15px;padding-top:5px;height:20px;">Poderes</h5>
<?php echo do_shortcode(' [tcp_list id="posts_destacados_poderes"] '); ?>
</div>
<div style="position:relative;float:left;height:300px;width:240px;top;">
<h5 style="background-color:#4c4c4c;color:#fff;position:relative;top:20px;width:100px;padding-left:15px;padding-top:5px;height:20px;">Deportes</h5>
<?php echo do_shortcode(' [tcp_list id="posts_destacados_play"] '); ?>
</div>
<?php echo do_shortcode('[doap_spacer height=230]'); ?>
</div>
<?php echo do_shortcode('[doap_spacer height=230]'); ?>
</div>
<?php echo do_shortcode('[doap_spacer height=230]'); ?>
<?php echo do_shortcode('[doap_spacer height=230]'); ?>
<?php echo do_shortcode('[doap_spacer height=230]'); ?>
<?php echo do_shortcode('[doap_spacer height=230]'); ?>
<?php echo do_shortcode('[doap_spacer height=230]'); ?>
<?php echo do_shortcode('[doap_spacer height=230]'); ?>
<style>
#davestable table, #davestable tr td {
    border: none;padding:0px;margin:0px;
}
</style>
<?php echo do_shortcode('[doap_row][doap_column size="3/4" class="suplementos-home-bottom"]<a href="http://noticias.laprensa.com.ni/category/suplementos/"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/suplementos-text-separator.png" alt="suplementos-text-separator" width="700" height="28" class="alignnone size-full wp-image-372230" /></a><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/Screen-Shot-2014-04-19-at-11.50.05-AM.png" alt="Screen Shot 2014-04-19 at 11.50.05 AM" width="707" height="270" class="alignnone size-full wp-image-372331" /><br><div id=magazine-ad><a href=http://magazine.laprensa.com.ni><iframe src=http://noticias.laprensa.com.ni/los-cuatro/magazine.html frameborder=0 scrolling=none height=137 width=728></iframe></a></div>[/doap_column][doap_column size="1/4" class="suplementos-home-bottom"]<table id="davestable" border="0" style="border:0px solid #fff;"><tr><td colspan="3" style="width:100%;min-width:200px;"><a href="http://noticias.laprensa.com.ni/category/portada-impresa"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/portada-impresa3-text-separator.png" alt="portada-impresa3-text-separator" width="300" height="28" class="alignnone size-full wp-image-372293" /></a></td></tr><tr><td width="20%"></td><td style="min-width:200px;">[doap_custom_gallery source="category: 3680" limit="1" link="post" width="290" height="460" title="always" class="gallery-of-portadas"]</td><td width="20%"></td></tr></table><br><a style="position:relative;top:-35px;" href="http://noticias.laprensa.com.ni/2014">[xyz-ips snippet="ediciones-anteriores"][/doap_column][/doap_row]'); ?>

<?php echo do_shortcode('[doap_row][doap_column size="3/4" class="cartelera-row-of-images"]<img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/cartelera-de-cine-text-separator.png" style="max-width:100%" alt=""><br><div style="max-width:600px;height:300px;background-color:#369:">[doap_custom_gallery source="category: 23782" limit="1" link="post" width="600" height="280" title="never" class="cartelera-images-3up"]</div>[/doap_column][doap_column size="1/4" class="bottom-corner-ad"][/doap_column][/doap_row]'); ?>

<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php echo "</div>"; ?>
<div style="position:absolute;width:100%;background-color:#369;"> </div>
<div style="position:absolute;width:100%;background-color:#2B4C92;top:-100px;"> </div>
<?php get_footer(); ?>

