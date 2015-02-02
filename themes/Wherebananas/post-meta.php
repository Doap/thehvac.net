<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Meta-Data Template-Part File
 *
 * @file           post-meta.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/post-meta.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>
<hr>
<style>

/* Smartphones (portrait and landscape) ----------- */
@media only screen and (max-width : 540px) {
/* Styles */
.posttitle { position:relative;float:left;max-width:50%; }
}
@media only screen and (min-width : 541px) and (max-width : 741px) {
/* Styles */
.posttitle { position:relative;float:left;max-width:70%; }
}
@media only screen and (min-width : 981px) and (max-width : 1223px) {
/* Styles */
.posttitle { position:relative;float:left;max-width:70%; }
}




/* Desktops and laptops ----------- */
@media only screen 
and (min-width : 1224px) {
/* Styles */
.posttitle { position:relative;float:left;max-width:75%; }
}

/* Large screens ----------- */
@media only screen 
and (min-width : 1824px) {
/* Styles */
.posttitle { position:relative;float:left;max-width:85%; }
}


</style>
<?php if( is_single() ): ?>
	<div class="alignright"><?php responsive_pro_featured_image(); ?></div> 
	<div class="posttitle alignleft entry-title post-title">
<?php echo do_shortcode('[doap_heading style="line-orange" align="right" class="alignright"]Somos multilingual! <div style="margin-left:10px;width:150px;position:relative;float:right;">[doap-translator]</div>[/doap_heading]'); ?>
	<?php echo '<a href=""><img style="position:relative;top:10px;" class=alignleft src='.get_video_thumbnail().' height="50" width="70"></a>'; ?>
		<h4 class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<?php _e( ' Publicado', 'su' ); ?>: <?php _e( ' ', 'su' ); ?> <?php the_time( get_option( 'date_format' ) ); ?> <?php the_time( get_option( 'time_format' ) ); ?>
<style>#google_language_translator { display:none; } </style>
<?php //echo do_shortcode('[glt language="Spanish" label="Español"]'); ?> <?php //echo do_shortcode('[glt language="English" label="Ingles"]'); ?>
	</div>
<?php else: ?>
	<div class="alignright"><?php responsive_pro_featured_image(); ?></div> 
	<div class="posttitle alignleft entry-title post-title">
	        <a href="<?php the_permalink(); ?>"><img class=alignleft src='<?php echo get_video_thumbnail(); ?>' height="100" width="150"></a>
		<h4 title="<?php _e( ' Publicado', 'su' ); ?> <?php the_time( get_option( 'date_format' ) ); ?> <?php the_time( get_option( 'time_format' ) ); ?>" class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
		<?php //the_time( get_option( 'date_format' ) ); ?> <?php the_time( get_option( 'time_format' ) ); ?>
	</div>

<?php endif; ?>

