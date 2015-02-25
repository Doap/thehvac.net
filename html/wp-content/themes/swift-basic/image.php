<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Swift
 * @subpackage Template
 * @since 6.0
 */

get_header(); ?>

<div id="content" class="full-width" role="main">
	<div class="div-content">
		<?php swift_before_content() ?>

		<?php while ( have_posts() ) : the_post(); ?>


		<?php get_template_part( 'display/post', 'gallery' ); ?>

		<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>
		<?php swift_after_content() ?>

	</div>
	<!-- #content -->
</div>
<!-- #primary -->

</div>
<!-- /#left -->

<?php swift_after_main() ?>

</div>
<!-- /#main -->

<?php get_footer(); ?>