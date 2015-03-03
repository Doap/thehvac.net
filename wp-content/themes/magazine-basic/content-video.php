<?php
/**
 * The template for displaying posts in the Video post format.
 *
 * @since 3.0.3
 */
$class = mb_article_class();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	    <?php get_template_part( 'content', 'header' ); ?>

		<div class="entry-content">
		    <?php the_content( 'Read more &rarr;' ); ?>
		</div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article><!-- #post -->