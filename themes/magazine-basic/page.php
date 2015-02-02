<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @since 3.0.0
 */
get_header(); ?>

	<div id="primary" <?php mb_primary_attr(); ?> role="main">
		<?php
		while ( have_posts() ) : the_post();
	    	get_template_part( 'content', 'page' );
			comments_template( '', true );
		endwhile; // end of the loop.
		?>
	</div><!-- #primary.c8 -->

<?php get_footer(); ?>