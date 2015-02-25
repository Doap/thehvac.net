<?php
/**
 * The default template for displaying content.
 *
 * @file      footer.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
?>
 
<div id="posts-list">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>		
			
			<div class="post">					
				<div class="post-image">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail', array('title' => "") ); ?></a>
				</div>
					
				<div class="right">
			
					<?php if ( is_sticky() ) : ?>
						<div class="sticky"><?php _e( 'Important', 'max-magazine' ); ?></div>
					<?php endif; ?>
					
					<h2> <a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'max-magazine'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					
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
						
					<div class="exceprt">
						<?php 
							/**
							 * the_excerpt() returns first 30 words in the post.
							 * length is defined in functions.php.
							 */
							the_excerpt();
						?>
					</div> 
					
					<div class="more">
						<a href="<?php the_permalink(); ?>"><?php _e('Read Post &rarr;', 'max-magazine'); ?></a>
					</div> 
				</div>	
			</div><!-- post -->		

		<?php endwhile; ?>
		
		<?php if ( function_exists('max_magazine_pagination') ) { max_magazine_pagination(); } ?>		
		
	<?php endif; ?>	

</div>
