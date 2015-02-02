<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @file      index.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
?> 
<?php get_header(); ?>

<div id="content">		
		
		<?php
			//show on homepage only
			if (is_home() && $paged < 2 ){

				//include slider
				if ( max_magazine_get_option( 'show_slider' ) == 1 ) {
					get_template_part('includes/slider'); 
				}
				
				//include carousel posts
				if ( max_magazine_get_option( 'show_carousel' ) == 1 ){
					get_template_part('includes/carousel'); 
				}
			
				if ( max_magazine_get_option( 'show_feat_cats' ) == 1) { ?>
					
					<div id="featured-categories">
			
					<?php
						
						//include featured category 1
						if ( max_magazine_get_option( 'feat_cat1' ) != 0) {
							get_template_part('includes/feat_cat1');			
						}
						
						//include featured category 2
						if ( max_magazine_get_option( 'feat_cat1' ) != 0) {
							get_template_part('includes/feat_cat2');			
						}
				
						//include featured category 3
						if ( max_magazine_get_option( 'feat_cat3' ) != 0) {
							get_template_part('includes/feat_cat3');			
						}
				
						//include featured category 4
						if ( max_magazine_get_option( 'feat_cat4' ) != 0) {
							get_template_part('includes/feat_cat4');			
						}
					?>
			
					</div> <!-- /featured-categories -->
				
			<?php 
				}
			} //is_home 
		
			//include latest posts
			if ( max_magazine_get_option( 'show_posts_list' ) != 0) {
				get_template_part('includes/content'); 				
			}
		
			//no option is set in the homepage, display posts list.
			if (( max_magazine_get_option( 'show_slider' ) == 0) and 
				( max_magazine_get_option( 'show_feat_cats' ) == 0) and 
				( max_magazine_get_option( 'show_carousel' ) == 0) and 
				( max_magazine_get_option( 'show_posts_list' ) == 0)){
			?>
				<div class="no-posts-notice">
					<?php _e('Please enable theme settings from the theme options', 'max-magazine'); ?>
				</div>
				<?php get_template_part('includes/content'); ?>
			
			<?php }	?>
		
</div><!-- /content -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>