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
<div  style="-webkit-border-radius: 0px; -moz-border-radius: 2px; border-radius: 2px;border:0px solid #ccc; margin-right:0px;position:relative;float:left;height:60px;width:183px;margin-bottom:0px;margin-right:0px;" id="su-post-<?php the_ID(); ?>" <?php post_class(); ?> class="su-post">

					<div style="position:relative;float:right;width:50%;height:60px;padding-left:2px;padding-right:2px;padding-top:2px;font-size:.7em;margin-right:0px;line-height:.9em;" class="su-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
					<?php if ( has_post_thumbnail() ) : ?>
        <?php echo '<div style="position:relative;max-width:45%;margin-top:0px;margin-bottom:0px;margin-right:6px;"><a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
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
