<?php
/**
 * The Template for displaying all single posts.
 *
 * @file      single.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
?>
<?php get_header(); ?>

<div id="content">		

		<?php if (have_posts()) { ?>		
			<?php while (have_posts()) : the_post(); ?>
		
				<div id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
		
					<h2><?php the_title(); ?></h2>
					<div class="post-meta">							

						<div class="post-meta">
							<span class="date"><?php the_time('F j, Y'); ?></span> 
							<span class="sep"> - </span>						
							<span class="category"><?php the_category(', '); ?></span>
							<?php the_tags( '<span class="sep"> - </span><span class="tags">' . __('Tagged: ', 'max-magazine' ) . ' ', ", ", "</span>" ) ?>
							<?php if ( comments_open() ) : ?>
								<span class="sep"> - </span>
								<span class="comments"><?php comments_popup_link( __('no comments', 'max-magazine'), __( '1 comment', 'max-magazine'), __('% comments', 'max-magazine')); ?></span>			
							<?php endif; ?>		
						</div>
							
					</div><!-- /post-meta -->
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6970273280466483";
/* 468x60 */
google_ad_slot = "8470961064";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>			
					<div class="post-entry">
					<?php the_content(); ?>				
	<script type="text/javascript"><!--
google_ad_client = "ca-pub-6970273280466483";
/* 468x15centerofpage */
google_ad_slot = "6581025868";
google_ad_width = 468;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
					</div><!-- /post-entry -->
					<?php if ( ( max_magazine_get_option( 'show_author' ) == 1 ) and ( get_the_author_meta('description') != '' ) ) { ?>
					            
						<div class="author">	
								
							<h3><?php _e('About the author', 'max-magazine') ?></h3>
								<?php if (function_exists('get_avatar')) { 
									echo get_avatar( get_the_author_meta('email'), '50' ); 
								} ?>
							<div class="author-meta">
								<div class="name"><?php the_author_posts_link(); ?></div>
								<p><?php the_author_meta('description') ?></p>
							</div>					
						</div><!-- /author-meta -->
                  
					<?php } ?>
					
					</div><!-- post -->
					<?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'max-magazine'), 'after' => '</div>')); ?>
				
		
				<?php comments_template( '', true ); ?>
            
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
<?php get_sidebar(); ?>
<?php get_footer(); ?>
