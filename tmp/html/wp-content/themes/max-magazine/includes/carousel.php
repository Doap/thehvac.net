<?php
/**
 * The template for displaying the carousel posts.
 * Gets the category for the posts from the theme options. 
 * If no category is selected, displays the latest posts.
 *
 *
 * @file      footer.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 *
 */
?>
<?php
	$carousel_cat_id = max_magazine_get_option('carousel_category');
	//if no category is selected for carousel, show latest posts
	if ( $carousel_cat_id == 0 ) {
		$post_query = 'posts_per_page=10';
	} else {
		$post_query = 'cat='.$carousel_cat_id.'&posts_per_page=10';
	}
?>

<div id="carousel">
	<div class="title">
		
		<div class="cat">
			<h3>
				<?php
					if ($carousel_cat_id == 0 ) {
						 _e('Latest Posts', 'max-magazine');						
					} else {
						$carousel_cat_name = get_cat_name($carousel_cat_id);
						$carousel_cat_url = get_category_link( $carousel_cat_id );
						?>
						<a href="<?php echo esc_url( $carousel_cat_url ); ?>" ><?php echo $carousel_cat_name; ?></a>
					<?php
					}
				?>		
			</h3>
		</div>
		
		<div class="buttons">
			<div class="prev"><img src="<?php echo get_template_directory_uri(); ?>/images/prev.png" alt="prev" /></div>
			<div class="next"><img src="<?php echo get_template_directory_uri(); ?>/images/next.png" alt="next" /></div>
		</div>
	</div>
			
	<div class="carousel-posts">				
		<ul>
			<?php query_posts( $post_query ); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'carousel-thumb' ); ?></a>
				<h4> 
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'max-magazine'), the_title_attribute('echo=0')); ?>">
						<?php 
							// display only first 22 characters in the title.	
							$short_title = substr(the_title('','',FALSE),0,22);
							echo $short_title; 
							if (strlen($short_title) >21){ 
								echo '...'; 
							} 
						?>	
					</a>
				</h4>
				
				<div class="post-meta">
					<span class="date"><?php the_time('F j'); ?></span> 
					<span class="sep">-</span> 
					<span class="comments"><?php comments_popup_link( __('no comments', 'max-magazine'), __( '1 comment', 'max-magazine'), __('% comments', 'max-magazine')); ?></span>
				</div>
				
				<div class="post-excerpt">
						<?php 
							// display only first 150 characters in the description.								
							$excerpt = get_the_excerpt();																
							echo substr($excerpt,0, 100);									
							if (strlen($excerpt) > 99){ 
								echo '...'; 
							} 
						?>			
				</div>			
			</li>
					
			<?php endwhile; endif;?>
			<?php wp_reset_query();?>
		</ul>				
	</div>			
</div><!-- /carousel -->