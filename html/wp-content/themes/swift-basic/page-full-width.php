<?php
/*
 Template Name: Full width template
*/

get_header(); ?>

<div id="content" class="full-width" role="main">
	<div class="div-content">

		<?php while ( have_posts() ) : the_post(); ?>


		<?php get_template_part( 'display/post', 'page' ); ?>

		<?php //swift_content_nav( 'nav-below' ); ?>

		<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

	</div>
	<!-- #content -->
</div>
<!-- #primary -->


</div>
<!-- left -->
</div>
<!-- main -->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>