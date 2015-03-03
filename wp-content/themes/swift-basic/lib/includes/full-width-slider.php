<?php
GLOBAL $swift_options,$swift_thumbnail_sizes;
if( $swift_options['featured_cat_home'] && $swift_options['featured_cat_home'] != 0 )
	$query='cat="'.$swift_options['featured_cat_home'].'"&posts_per_page='.$swift_options['featured_posts_number_home'];
else
	$query='posts_per_page='.$swift_options['featured_posts_number_home'];
$recentPosts = new WP_Query();
$recentPosts->query($query);

GLOBAL $swift_slider_posts_ids;
?>

<?php if ( have_posts() ) : ?>
<div id="full-width-slider" class="flex-container div-content">
	<div class="flexslider">
		<ul class="slides">
			<?php while ($recentPosts->have_posts()) : $recentPosts->the_post();?>
			<li><?php 		the_post_thumbnail( $swift_thumbnail_sizes['full_width_slider'], array( 'class'	=> "slide-thumbnail"
		)
);
$swift_slider_posts_ids[] = get_the_ID();
?>
				<div class="flex-caption">
					<h2 class="post-title">
						<a href="<?php the_permalink(); ?>"
							title="<?php printf( esc_attr__( 'Permalink to %s', 'swift' ), the_title_attribute( 'echo=0' ) ); ?>"
							rel="bookmark"><?php the_title(); ?> </a>
					</h2>
					<p>
						<?php the_excerpt()?>
					</p>
				</div>
			</li>
			<?php endwhile; ?>

		</ul>
	</div>
</div>
<?php endif;?>


<div id="left">