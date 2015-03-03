<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Swift
 * @subpackage Template
 * @since 6.0
 */

get_header(); ?>

<div id="content" role="main">
	<div class="div-content">
		<?php swift_before_content() ?>
		<?php while ( have_posts() ) : the_post(); ?>


		<?php get_template_part( 'display/post', 'page' ); ?>

		<?php //swift_content_nav( 'nav-below' ); ?>

		<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>
		<?php swift_after_content() ?>
	</div>
	<!-- #content -->
</div>
<!-- #primary -->
<?php get_sidebar(); ?>
<?php get_sidebar('bbPress'); ?>
<?php get_footer(); ?>
