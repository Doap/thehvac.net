<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @file      404.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 * 
 **/
?>
<?php get_header(); ?>

	<div id="content">
		<div id="post-0" class="post">
			<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'max-magazine' ); ?></h2>
				
				
				<div class="post-entry">
					<p><?php _e('You are trying to reach a page that does not exist here. Either it has been moved or you typed a wrong address.', 'max-magazine'); ?></p>

					<?php get_search_form(); ?>		
					
					<?php the_widget('WP_Widget_Recent_Posts', 'number=5', 'before_title=<h3>&after_title=</h3>'); ?>					
					
					<div class="widget">
						<h3><?php _e( 'Most Used Categories', 'max-magazine' ); ?></h3>
						<ul><?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 5 ) ); ?>
						</ul>
					</div>

					<?php the_widget( 'WP_Widget_Tag_Cloud', array('title' => 'Popular tags', ), array('before_title' => '<h3>', 'after_title' => '</h3>')); ?>

				</div><!-- .post-entry -->
		</div>
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>