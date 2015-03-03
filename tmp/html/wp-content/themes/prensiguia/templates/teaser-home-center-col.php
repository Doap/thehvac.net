<div class="su-posts su-posts-teaser-loop">
	<?php
		// Posts are found
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				global $post;

$post_url = get_permalink($post->ID);
        $feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' );
        $feat_image = $feat_image_array[0];

				?>
				<div id="su-post-<?php the_ID(); ?>" class="su-post">
					<?php if ( has_post_thumbnail() ) : ?>
        <?php echo '<div style="position:relative;max-width:300px;margin-top:0px;margin-bottom:0px;"><a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
        echo '</div>'; ?>
					<?php endif; ?>
					<div style="margin-top:10px;"><h2 class="su-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>
				</div>
				<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'su' ) . '</h4>';
		}
	?>
</div>
