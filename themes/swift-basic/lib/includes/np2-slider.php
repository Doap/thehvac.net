<?php
GLOBAL $swift_options;
if( $swift_options['np2_slider_cats'] && $swift_options['np_slider_cats'] != 0 )
	$query='cat="'.$swift_options['np_slider_cats'].'"&showposts='.$swift_options['featured_posts_number_home'];
else
	$query='&post_type=any&showposts='.$swift_options['featured_posts_number_home'];

$recentPosts = new WP_Query();
$recentPosts->query($query);

GLOBAL $swift_thumbnail_sizes;
GLOBAL $swift_exclude_post_ids;
$exclude_posts_ids[] = get_the_ID()
?>
<?php if ( have_posts() ) : ?>
<div id="np-slider" class="flex-container">
	<div class="flexslider">
		<ul class="slides">
			<?php while ($recentPosts->have_posts()) : $recentPosts->the_post();
			$swift_exclude_post_ids[] = get_the_ID()

			?>
			<li><?php 		the_post_thumbnail($swift_thumbnail_sizes['np2_slider'], array( 'class'	=> "slide-thubnail"											 )
			);
			$swift_slider_posts_ids[] = get_the_ID();
			?>
				<div class="flex-caption">
					<h2>
						<?php the_title(); ?>
					</h2>
				</div>
			</li>
			<?php endwhile; ?>

		</ul>
	</div>
</div>
<?php endif;?>
<div class="clear"></div>
<?php wp_reset_query(); ?>