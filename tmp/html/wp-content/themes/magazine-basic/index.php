<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @since 3.0.0
 */
get_header(); ?>

	<div id="primary" <?php mb_primary_attr(); ?> role="main">
		<?php
		$sticky = get_option( 'sticky_posts' );
		$featured = new WP_Query( array(
			'posts_per_page' => 1,
			'post__in'  => $sticky,
			'ignore_sticky_posts' => 1
		) );
		global $paged;
		if ( ! empty( $sticky[0] ) && is_home() && 2 > $paged ) {
			?>
		<div id="featured" class="row">
			<?php
			while ( $featured->have_posts() ) : $featured->the_post();
		    	global $mb_content_area;
		    	$mb_content_area = 'main';
				get_template_part( 'content', get_post_format() );
			endwhile;

			wp_reset_postdata();
			?>
		</div>
			<?php
		}

		if ( have_posts() ) : ?>
			<div class="row">
			<?php
			while ( have_posts() ) : the_post();
				global $wp_query;
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var('paged') : 1;
				$grid = mb_theme_options( 'grid' );
				$posts_per_page = mb_theme_options( 'number' );
				$count = $wp_query->current_post;
				$total = $wp_query->post_count - 1;
				$border = ( 3 == $grid && 1 == $paged ) ? '<div class="c12 border"><span></span></div>' : '';

				if ( 1 < $posts_per_page ) {
					echo ( ( ( 2 == $grid || 3 == $grid ) && 1 == $count && 1 == $paged ) || ( 2 == $grid && 1 < $paged && 0 == $count ) ) ? '<!-- 2 cols --><div class="two-col-wrapper">' : '';

					echo ( ( ( 3 == $grid || 4 == $grid ) && 0 == $count && 1 < $paged ) || ( 1 == $paged && ( ( 3 == $grid && 3 == $count ) || ( 4 == $grid && 1 == $count ) ) ) ) ? $border . '<!-- 3 cols --><div class="three-col-wrapper">' : '';;
				}

		    	global $mb_content_area;
		    	$mb_content_area = 'main';
		    	get_template_part( 'content', get_post_format() );

				if ( 1 < $posts_per_page ) {
					echo ( ( 2 == $grid && $total == $count ) || ( 3 == $grid && 2 == $count && 1 == $paged ) ) ? '</div><!-- eof 2 cols -->' : '';
					echo ( ( 3 == $grid || 4 == $grid ) && $total == $count ) ? '</div><!-- eof 3 cols -->' : '';
				}

			endwhile;
			?>
			</div>
			<?php
			mb_pagination();

		else :
			?>
			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
				?>
				<h1 class="entry-title"><?php _e( 'No posts to display', 'magazine-basic' ); ?></h1>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'magazine-basic' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

				<?php
			else :
				get_template_part( 'content', 'none' );
			endif; // end current_user_can() check
			?>

			</article><!-- #post-0 -->
		    <?php

		endif;
		?>
	</div><!-- #primary -->

<?php get_footer(); ?>