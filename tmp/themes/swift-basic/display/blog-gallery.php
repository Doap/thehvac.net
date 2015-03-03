<?php

/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<article
	id="post-<?php the_ID(); ?>"
	<?php post_class('clearfix blog-style'); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>"
				title="<?php printf( esc_attr__( 'Permalink to %s', 'swift' ), the_title_attribute( 'echo=0' ) ); ?>"
				rel="bookmark"><?php the_title(); ?> </a>
		</h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php swift_posted_on(); ?>
		</div>
		<!-- .entry-meta -->
		<?php endif; ?>

		<?php if ( comments_open() ) : ?>
		<div class="comments-link alignright">
			<?php comments_popup_link( '<span class="leave-reply">'._x( 'Reply', '0 comments', 'swift' ).'</span>', _x( '1', '1 comment', 'swift' ), sprintf( _x( '%s', 'n comments', 'swift' ), '%' ) ); ?>
		</div>
		<?php endif; ?>
		<div class="clear"></div>
	</header>
	<!-- .entry-header -->

	<?php

	if (is_search())
		:
		?>


	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( sprintf( __( 'Continue reading %s&rarr;%s', 'swift' ), '<span class="meta-nav">', '</span>' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'swift' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div>
	<!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php $show_sep = false; ?>
		<?php
		if ('post' == get_post_type())
			:
			?>


		<?php

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list(__(', ', 'swift'));
		if ($categories_list)
			:
			?>
		<span class="cat-links"> <span
			class="entry-utility-prep entry-utility-prep-cat-links"><?php _e( 'Posted in', 'swift' ); ?>
		</span> <?php
		echo ' ' . $categories_list;
		$show_sep = true;
		?>
		</span>
		<?php

		endif;
		?>


		<?php

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list('', __(', ', 'swift'));
		if ($tags_list)
			: if ($show_sep)
			:
			?>
		<span class="sep"> | </span>
		<?php
		endif;
		?>


		<span class="tag-links"> <span
			class="entry-utility-prep entry-utility-prep-tag-links"><?php _e( 'Tagged', 'swift' ); ?>
		</span> <?php

		echo ' ' . $tags_list;
		$show_sep = true;
		?>
		</span>
		<?php

		endif;
		?>


		<?php

		endif;
		?>



		<?php if ( comments_open() ) : ?>
		<?php if ( $show_sep ) : ?>
		<span class="sep"> | </span>
		<?php

		endif;
		?>


		<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">'._x( 'Leave a reply', '0 comments', 'swift' ).'</span>', sprintf( _x( '%s Reply', '1 comment', 'swift' ), '<b>1</b>' ), sprintf( _x( '%s Replies', 'n comments', 'swift' ), '<b>%</b>' ) ); ?>
		</span>
		<?php

		endif;
		?>



		<?php edit_post_link( __( 'Edit', 'swift' ), '<span class="edit-link">', '</span>' ); ?>

	</footer>
	<!-- #entry-meta -->
	<div class="clear"></div>

</article>
<!-- #post-<?php the_ID(); ?> -->
