<?php
/**
 * The template used for displaying page content in page.php
 *
 * @since 3.0.0
 */
$class = mb_article_class();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
		<h1 class="entry-title"><?php the_title(); ?></h1>

	    <div class="entry-content">
		    <?php the_content( 'Read more &rarr;' ); ?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>

	</article><!-- #post-<?php the_ID(); ?> -->