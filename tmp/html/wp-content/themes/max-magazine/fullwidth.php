<?php
/**
 * Template Name: Full Width
 *
 * The template for displaying the full width page.
 * 
 * @file      fullwidth.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
?>
<?php get_header(); ?>

	<div id="content" class="wide-content">
	
		<?php if (have_posts()) { ?>		
			<?php while (have_posts()) : the_post(); ?>
		
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
					<h2><?php the_title(); ?></h2>
					
					<div class="post-meta">	
							<?php if ( max_magazine_get_option( 'show_page_comments' ) == 1 ) { ?>
								<span class="comments"><?php comments_popup_link( __('no comments', 'max-magazine'), __( '1 comment', 'max-magazine'), __('% comments', 'max-magazine')); ?></span>
							<?php } ?>						
					</div><!-- /post-meta -->
			
					<div class="post-entry">
						<?php the_content(); ?>				
					</div><!-- /post-entry -->
							
				</div><!-- post -->
				<?php if ( max_magazine_get_option( 'show_page_comments' ) == 1 ) { ?>
					<?php comments_template( '', true ); ?>
				<?php } ?>
			<?php endwhile; ?> 
		
			<?php if (  $wp_query->max_num_pages > 1 ) { ?>
       
				<div class="navigation">
					<div class="previous"><?php next_posts_link( __( '&#8249; Older posts', 'max-magazine' ) ); ?></div>
					<div class="next"><?php previous_posts_link( __( 'Newer posts &#8250;', 'max-magazine' ) ); ?></div>
				</div>
			<?php } ?>
		
		<?php } else { ?>
			
			<div id="post-0" class="post">
				<h2><?php _e( 'Nothing Found', 'max-magazine' ); ?></h2>
				<p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help.', 'max-magazine'); ?></p>			
				<?php get_search_form(); ?>	
			</div>
		
		<?php } ?> <!-- /have_posts -->		
		
</div><!-- /content -->
	
<?php get_footer(); ?>
