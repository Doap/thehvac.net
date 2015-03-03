<?php
/**
 * The template for displaying posts in the Status Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package Swift
 * @subpackage Template
 */
?>

<article
	id="post-<?php the_ID(); ?>"
	<?php post_class('clearfix blog-style'); ?>>


	<div class="entry-content">
		<div class="avatar">
			<?php echo swift_get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'swift_status_avatar', '72' ) ); ?>
		</div>
		<?php the_content( sprintf( __( 'Continue reading %s&rarr;%s', 'swift' ), '<span class="meta-nav">', '</span>' ) ); ?>
	</div>
	<!-- .entry-content -->

	<footer class="entry-meta">
		<?php swift_posted_on(); ?>
		<?php if ( comments_open() ) : ?>
		<span class="sep"> | </span> <span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">'._x( 'Leave a reply', '0 comments', 'swift' ).'</span>', sprintf( _x( '%s Reply', '1 comment', 'swift' ), '<b>1</b>' ), sprintf( _x( '%s Replies', 'n comments', 'swift' ), '<b>%</b>' ) ); ?>
		</span>
		<?php endif; ?>
		<?php edit_post_link( __( 'Edit', 'swift' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<!-- #entry-meta -->
</article>
<!-- #post-<?php the_ID(); ?> -->
