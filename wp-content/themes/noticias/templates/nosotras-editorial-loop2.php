<div class="su-posts su-posts-default-loop">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>

		<div id="su-post-<?php the_ID(); ?>" class="su-post" style="border-top:1px solid #eee;">
		<div style="padding-bottom:20px;position:relative;float:left;top:20px;"><a class="su-post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>
		<div style="border-top:4px solid #DD579A;border-bottom:3px solid #DD579A;"><h2 class="su-post-title"><a style="color:#dd579a;font-family:StagSansBook;position:relative;top:3px;left:-100px;" href="<?php the_permalink(); ?>">Consulte a la ginecologa</a></h2></div>
		<div style="border-top:0px solid #fff;border-bottom:0px solid #fff;"><h2 class="su-post-title"><a style="color:#dd579a;font-family:StagSansBook;position:relative;top:10px;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>
					<div class="su-post-excerpt"> 
						<?php 
$theexcerpt = get_doap_excerpt(300,1,1);
$theexcerpt = '<div class="category-excerpt" style="padding:4px;text-align:justify;position:relative;top:5px;">' . $theexcerpt . '</div>' . PHP_EOL;
echo $theexcerpt;
//the_excerpt(); 
?>
					</div>
				</div>

				<?php
			endwhile;
			echo $i;
			$i++;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'su' ) . '</h4>';
		}
	?>
</div>
