<div class="su-posts su-posts-teaser-loop">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>
					<p style="line-height:.6em;"><span style="position:relative;left:25px;" class="su-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span><span  style="position:relative;top:-3px;left:20px;float:left;"><img class="thumbnail" height="12" width="16" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/arrow-right.png" style="max-width:100%" alt=""></span></p>
				<?php
			endwhile;
		}
		// Posts not found
		else {
			//echo '<h4>' . __( 'Posts not found', 'su' ) . '</h4>';
		}
	?>
</div>
