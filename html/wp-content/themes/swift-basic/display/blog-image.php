<?php
/**
 * The template for displaying posts in the Image Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package Swift
 * @subpackage Template
 * @since Swift 6.0
 */
?>
<article
	id="post-<?php the_ID(); ?>"
	<?php post_class('clearfix blog-style'); ?>>
	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>"
				title="<?php printf( esc_attr__( 'Permalink to %s', 'swift' ), the_title_attribute( 'echo=0' ) ); ?>"
				rel="bookmark"><?php the_title(); ?> </a>
		</h2>
		<?php if ( comments_open() ) : ?>
		<div class="comments-link">
			<?php comments_popup_link( '<span class="leave-reply">'._x( 'Reply', '0 comments', 'swift' ).'</span>', _x( '1', '1 comment', 'swift' ), sprintf( _x( '%s', 'n comments', 'swift' ), '%' ) ); ?>
		</div>
		<?php endif; ?>
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( sprintf( __( 'Continue reading %s&rarr;%s', 'swift' ), '<span class="meta-nav">', '</span>' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'swift' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div>
	<!-- .entry-content -->

	<footer class="entry-meta">
		<div class="entry-meta">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><time
					class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>"
					pubdate="pubdate">
					<?php echo get_the_date(); ?>
				</time> </a> <span class="by-author"> <span class="sep"><?php echo ' '._x( 'by', 'date BY name', 'swift' ).' '; ?>
			</span> <span class="author vcard"> <a class="url fn n"
					href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
					title="<?php printf( esc_attr__( 'View all posts by %s', 'swift' ), get_the_author() ); ?>"
					rel="author"><?php echo get_the_author(); ?> </a>
			</span>
			</span>
		</div>
		<!-- .entry-meta -->
		<div class="entry-meta">
			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'swift' ) );
			if ( $categories_list ):
			?>
			<span class="cat-links"> <span
				class="entry-utility-prep entry-utility-prep-cat-links"><?php _e( 'Posted in', 'swift' ); ?>
			</span> <?php echo ' '.$categories_list; ?>
			</span>
			<?php endif; // End if categories ?>
			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'swift' ) );
					if ( $tags_list ): ?>
			<span class="tag-links"> <span
				class="entry-utility-prep entry-utility-prep-tag-links"><?php _e( 'Tagged', 'swift' ); ?>
			</span> <?php echo ' '.$tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>

			<?php if ( comments_open() ) : ?>
			<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">'._x( 'Leave a reply', '0 comments', 'swift' ).'</span>', sprintf( _x( '%s Reply', '1 comment', 'swift' ), '<b>1</b>' ), sprintf( _x( '%s Replies', 'n comments', 'swift' ), '<b>%</b>' ) ); ?>
			</span>
			<?php endif; // End if comments_open() ?>
		</div>
		<!-- .entry-meta -->

		<?php edit_post_link( __( 'Edit', 'swift' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<!-- #entry-meta -->
</article>
<!-- #post-<?php the_ID(); ?> -->
