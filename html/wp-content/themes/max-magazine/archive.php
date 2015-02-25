<?php
/**
 * The template for displaying date-based Archive pages.
 *
 * @file      archive.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 * 
 **/
?> 
<?php get_header(); ?>
	<div id="content" >	
		<h2 class="page-title">
			<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: %s', 'max-magazine' ), '<span>' . get_the_date() . '</span>' ); ?>
			<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: %s', 'max-magazine' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'max-magazine' ) ) . '</span>' ); ?>
			<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: %s', 'max-magazine' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'max-magazine' ) ) . '</span>' ); ?>
			<?php else : ?>
				<?php _e( 'Blog Archives', 'max-magazine' ); ?>
			<?php endif; ?>
		</h2>	
		
		<?php get_template_part('includes/content'); ?>
				
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>