<div class="su-posts su-posts-teaser-loop">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;


        $feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' );
        $feat_image = $feat_image_array[0];

				?>
<div  style="-webkit-border-radius: 0px; -moz-border-radius: 2px; border-radius: 2px;border:0px solid #ccc; margin-right:0px;position:relative;float:left;height:150px;width:250px;margin-bottom:5px;margin-right:0px;" id="su-post-<?php the_ID(); ?>" <?php post_class(); ?> class="su-post">

<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php if ( has_post_thumbnail() ) : ?>
        <?php echo '<div style="position:relative;width:100%;height:150px;margin-top:5px;margin-bottom:5px;padding-right:2px;"><a href="' . $post_url . '"><img style="width:100%;height:200px;" src="' . $feat_image . '"></a>' . PHP_EOL;
        echo '</div>'; ?>
					<?php endif; ?>
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
