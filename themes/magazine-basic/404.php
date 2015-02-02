<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @since 3.0.0
 */
get_header(); ?>

	<div id="primary" <?php mb_primary_attr(); ?> role="main">

		<article id="post-0" class="post error404 not-found">
	    	<header>
				<img src="<?php echo MB_THEME_URL; ?>/library/images/404.png" alt="" />
	    	   	<h1 class="entry-title"><?php _e( '404 Error', 'magazine-basic' ); ?></h1>
	        </header>

	        <div class="entry-content">
	            <p><?php _e( 'Sorry. We can\'t seem to find the page you\'re looking for.', 'magazine-basic' ); ?></p>
	        </div>
	    </article>

	</div><!-- #primary.c8 -->

<?php get_footer(); ?>