<div class="su-posts su-posts-single-post">
	<?php
		// Prepare marker to show only one post
		$first = true;
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;

				// Show oly first post
				if ( $first ) {
					$first = false;
					?>
					<div id="su-post-<?php the_ID(); ?>" class="su-post">
						<h1 class="su-post-title"><?php the_title(); ?></h1>
						<div class="su-post-meta"><?php _e( 'Publicado', 'su' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?> | <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( '0 comments', 'su' ), __( '1 comment', 'su' ), __( '%n comments', 'su' ) ); ?></a></div>
						<div class="su-post-content">
<?php
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-900' );
        $feat_image = $feat_image_array[0];
        echo '<div style="position:relative;width:100%;margin-top:0px;margin-bottom:0px;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
        echo '</div>';
?>
						</div>
					</div>
					<?php
				}
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'su' ) . '</h4>';
		}
	?>
</div>
