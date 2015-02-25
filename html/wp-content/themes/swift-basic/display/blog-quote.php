<?php
/**
 * The default template for displaying content
 *
 * @package Swift
 * @subpackage Template
 * @since Swift 6.0
 */
?>

<article
	id="post-<?php the_ID(); ?>"
	<?php post_class('clearfix blog-style'); ?>>
	<div class="entry-content">
		<?php the_content( sprintf( __( 'Continue reading %s&rarr;%s', 'swift' ), '<span class="meta-nav">', '</span>' ) ); ?>
		<div class="alignright">
			~<a href="<?php the_permalink(); ?>"
				title="<?php printf( esc_attr__( 'Permalink to %s', 'swift' ), the_title_attribute( 'echo=0' ) ); ?>"
				rel="bookmark"><?php the_title(); ?> </a>
		</div>
		<div class="clear"></div>
	</div>
	<!-- .entry-content -->

	<footer class="entry-meta">
		<?php $show_sep = false; ?>
		<?php
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'swift' ) );
		if ( $categories_list ):
		?>
		<span class="cat-links"> <span
			class="entry-utility-prep entry-utility-prep-cat-links"><?php _e( 'Posted in', 'swift' ); ?>
		</span> <?php echo ' '.$categories_list;
					$show_sep = true; ?>
		</span>
		<?php endif; // End if categories ?>
		<?php
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'swift' ) );
		if ( $tags_list ):
				if ( $show_sep ) : ?>
		<span class="sep"> | </span>
		<?php endif; // End if $show_sep ?>
		<span class="tag-links"> <span
			class="entry-utility-prep entry-utility-prep-tag-links"><?php _e( 'Tagged', 'swift' ); ?>
		</span> <?php echo ' '.$tags_list );
					$show_sep = true; ?>
		</span>
		<?php endif; // End if $tags_list ?>

		<?php if ( comments_open() ) : ?>
		<?php if ( $show_sep ) : ?>
		<span class="sep"> | </span>
		<?php endif; // End if $show_sep ?>
		<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">'._x( 'Leave a reply', '0 comments', 'swift' ).'</span>', sprintf( _x( '%s Reply', '1 comment', 'swift' ), '<b>1</b>' ), sprintf( _x( '%s Replies', 'n comments', 'swift' ), '<b>%</b>' ) ); ?>
		</span>
		<?php endif; // End if comments_open() ?>

		<?php edit_post_link( __( 'Edit', 'swift' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<!-- #entry-meta -->
</article>
<!-- #post-<?php the_ID(); ?> -->
