<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Swift
 * @since Swift 6.0
 */
?>
<?php
$swift_post_meta= get_post_meta( $post->ID, '_swift_post_meta', TRUE )?>
<article
	id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( !(is_array($swift_post_meta) && $swift_post_meta['hide_title']) ):?>
	<header class="entry-header">
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1>
	</header>
	<!-- .entry-header -->
	<?php endif;?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'swift' ) . '</span>', 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit', 'swift' ), '<span class="edit-link">', '</span>' ); ?>
	</div>
	<!-- .entry-content -->
</article>
<!-- #post-<?php the_ID(); ?> -->
