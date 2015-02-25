<?php
/**
 * The template for displaying posts in the Aside post format
 *
 * @since 3.0.0
 */
$class = mb_article_class();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
		<h3 class="post-format">Aside</h3>

	    <div class="entry-content">
		    <?php the_content( 'Read more &rarr;' ); ?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article>