<?php
/**
 * The template for the slider on homepage.
 * 
 * @file      feat_cat1.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 **/
?>
<?php	
	$slider_cat_id = max_magazine_get_option( 'slider_category');
	//if no category is selected for slider, show latest posts
	if ( $slider_cat_id == 0 ) {
		$post_query = 'posts_per_page=5';
	} else {
		$post_query = 'cat='.$slider_cat_id.'&posts_per_page=5';
	}
?>

<div id="slider">
	<div class="lof-slidecontent">	
	<div class="preload"><div></div></div>    		 
            <div class="main-slider-content">
                <ul class="sliders-wrap-inner">
					<?php query_posts( $post_query ); ?>					
					<?php if (have_posts()) : ?>
						<?php while (have_posts()) : the_post(); ?>
					        <li>
								<?php if ( has_post_thumbnail()) : ?>								
									<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'slider-image' ); ?></a>
								<?php endif; ?>
								
								<div class="lof-main-item-desc">
									<div class="date"><?php the_time( get_option( 'date_format' ) ) ?></div>	
							
									<h3>
										<a href="<?php the_permalink(); ?>">
																				
										<?php 
											// display only first 40 characters in the slide title.	
											$short_title = substr(the_title('','',FALSE),0,40);
											echo $short_title; 
											if (strlen($short_title) >39){ 
												echo '...'; 
											} 
										?>	
										</a>
									</h3>
				
									<div class="description">
										<?php 
											// display only first 150 characters in the slide description.								
											$excerpt = get_the_excerpt();																
											echo substr($excerpt,0, 150);									
											if (strlen($excerpt) > 149){ 
												echo '...'; 
											} 
										?>	
									</div>				
								</div>
							</li>
						<?php endwhile; ?>
					<?php endif; ?>					
					<?php wp_reset_query();?>
                </ul>  	
            </div><!-- /main-slider-content --> 
 		   
		   	<div class="navigator-content">
                  <div class="button-next">Next</div>
                  <div class="navigator-wrapper">
                        <ul class="navigator-wrap-inner">						
							<?php query_posts( $post_query ); ?>							
							<?php if (have_posts()) : ?>
								<?php while (have_posts()) : the_post(); ?>
									<?php if ( has_post_thumbnail()) : ?>
										<li><?php the_post_thumbnail( 'small-thumb' ); ?></li>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php endif;?>
							<?php wp_reset_query();?>							
                        </ul>
                  </div>
                  <div  class="button-previous">Previous</div>
             </div> <!-- /navigator-content --> 
          
            <div class="button-control"><span></span></div>
    </div>   
 </div><!-- /slider -->