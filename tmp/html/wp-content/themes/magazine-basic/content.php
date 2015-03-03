<?php
global $mb_content_area;
$class = mb_article_class();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>

	    <?php get_template_part( 'content', 'header' ); ?>

	    <div class="entry-content">
		    <?php
		    if ( ( is_singular() || 'content' == mb_theme_options( 'excerpt_content' ) ) && 'main' == $mb_content_area && ! is_archive() && ! is_search() ) {
			    the_content( 'Read more &rarr;' );
		    } else {
		    	$image_name = 'thumbnail';
		    	if ( is_home() ) {
		    		$image_name = '1_column';
		    		$image_name = ( 'three-col c4' == $class ) ? '3_column' : $image_name;
		    		$image_name = ( 'two-col c6' == $class ) ? '2_column' : $image_name;
				}

				if( has_post_thumbnail() ) {
					echo '<a href="' . get_permalink() . '">';
					the_post_thumbnail( $image_name, array( 'class' => 'alignleft' ) );
					echo '</a>';
				}
				the_excerpt();
		    }
			?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>

	</article><!-- #post-<?php the_ID(); ?> -->