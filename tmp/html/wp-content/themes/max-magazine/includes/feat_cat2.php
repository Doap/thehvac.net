<?php
/**
 * The template for displaying the second featured category on homepage.
 * Gets the category id from the theme options. 
 *
 * @file      feat_cat2.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
?> 
<?php
	$cat2_id = max_magazine_get_option( 'feat_cat2'); 
	$cat2_name = get_cat_name($cat2_id);
	$cat2_url = get_category_link( $cat2_id );
?>

<div class="category">
	<h3 class="cat-title"><a href="<?php echo esc_url( $cat2_url ); ?>" ><?php echo $cat2_name; ?></a></h3>
	
		<div class="feat-post"> 
			<?php $post_query = 'cat='.$cat2_id.'&posts_per_page=1'; ?>
				<?php query_posts( $post_query ); ?>
					<?php if (have_posts()) : ?>
						<?php while (have_posts()) : the_post(); ?>			
							<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'feat-thumb' ); ?></a>
								<h3>								
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'max-magazine'), the_title_attribute('echo=0')); ?>">
									<?php 
										// display only first 26 characters in the title.	
										$short_title = substr(the_title('','',FALSE),0,26);
										echo $short_title; 
										if (strlen($short_title) >25){ 
											echo '...'; 
										} 
									?>	
									</a>
								</h3> 
							
							<p>							
								<?php 
									// display only first 150 characters in the slide description.								
									$excerpt = get_the_excerpt();																
									echo substr($excerpt,0, 150);									
									if (strlen($excerpt) > 150){ 
										echo '...'; 
									} 
								?>								
							</p>
						<?php endwhile; ?>
					<?php endif; ?>					
				<?php wp_reset_query();?>
		</div>
				
		<div class="more-posts">
			
			<?php $post_query = 'cat='.$cat2_id.'&posts_per_page=3&offset=1'; ?>
				<?php query_posts( $post_query ); ?>
					<?php if (have_posts()) : ?>
						<?php while (have_posts()) : the_post(); ?>	
						
							<div class="post">
								<a href="<?php the_permalink() ?>">
									<?php the_post_thumbnail('small-thumb', array('title' => ''.get_the_title().'' )); ?>									
								</a>
				
								<div class="right">
									<h5>
										<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'max-magazine'), the_title_attribute('echo=0')); ?>">
											<?php 
												// display only first 22 characters in the title.	
												$short_title = substr(the_title('','',FALSE),0,56);
												echo $short_title; 
												if (strlen($short_title) > 55){ 
													echo '...'; 
												} 
											?>	
										</a>
									</h5>
									<span class="post-meta">
										<span class="date"><?php the_time('F j'); ?></span> 
										<span class="sep">-</span> 
										<span class="comments"><?php comments_popup_link( __('no comments', 'max-magazine'), __( '1 comment', 'max-magazine'), __('% comments', 'max-magazine')); ?></span>
									</span>	
								</div>						
							</div>
			
						<?php endwhile; ?>
					<?php endif; ?>					
					<?php wp_reset_query();?>			
			
			

		</div> <!-- /more posts -->
</div><!-- /category -->