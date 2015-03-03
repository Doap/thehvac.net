<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @since 3.0.0
 */
global $mb_content_area;
$class = mb_article_class();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>

	    <?php get_template_part( 'content', 'header' ); ?>

	    <div class="entry-content">
	        <?php
			if( has_post_thumbnail() && ( ! is_single() || 'sidebar' == $mb_content_area ) ) {
				echo '<a href="' . get_permalink() . '">';
				the_post_thumbnail( 'large', array( 'class' => 'alignnone' ) );
				echo '</a>';
			} else {
				the_content( 'Read more &rarr;' );
			}
			?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>

	</article>