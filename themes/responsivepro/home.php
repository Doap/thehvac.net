<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blog Template
 *
 * @file           home.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/home.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */

get_header();

global $more;
$more = 0;
?>

	<div id="content-blog" class="<?php echo esc_attr( implode( ' ', responsive_get_content_classes() ) ); ?>">

		<!-- Blog page title -->
		<?php if( responsive_pro_get_option( 'blog_post_title_toggle' ) ) { ?>
			<h1> <?php echo responsive_pro_get_option( 'blog_post_title_text' ); ?> </h1>
		<?php } ?>
		<?php get_template_part( 'loop-header' ); ?>

		<?php if( have_posts() ) : ?>

			<?php while( have_posts() ) : the_post(); ?>

				<?php responsive_entry_before(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php responsive_entry_top(); ?>

					<?php get_template_part( 'post-meta' ); ?>

					<div class="post-entry">
						<?php
						responsive_pro_featured_image();

						if( responsive_pro_get_option( 'blog_post_excerpts' ) ) {
							add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
							add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
							the_excerpt();
							remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
							remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
						}
						else {
							the_content( __( 'Read more &#8250;', 'responsive' ) );
						}

						wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
						?>
					</div>
					<!-- end of .post-entry -->

					<?php get_template_part( 'post-data' ); ?>

					<?php responsive_entry_bottom(); ?>
				</div><!-- end of #post-<?php the_ID(); ?> -->
				<?php responsive_entry_after(); ?>

			<?php
			endwhile;

			get_template_part( 'loop-nav' );

		else :

			get_template_part( 'loop-no-posts' );

		endif;
		?>

	</div><!-- end of #content-blog -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
