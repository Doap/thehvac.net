<?php
/**
 * The template for displaying posts in the Link Post Format on index and archive pages
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
	<?php
	$pattern="((((ht|f)tp(s?))\://)?((www.|[a-zA-Z])([a-zA-Z0-9\-]+\.)([a-zA-Z]{2,8}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\;\?\'\\\+&amp;%\$#\=~_\-]+))*)";
	preg_match($pattern, get_the_content(), $matches);
	?>
	<header class="entry-header">
		<h4 class="entry-title">
			<a href="<?php echo $matches[0]; ?>"
				title="<?php printf( esc_attr__( 'Permalink to %s', 'swift' ), the_title_attribute( 'echo=0' ) ); ?>"
				rel="bookmark"><?php the_title(); ?> </a>
		</h4>

		<?php if ( comments_open() ) : ?>
		<div class="comments-link">
			<?php comments_popup_link( '<span class="leave-reply">'._x( 'Reply', '0 comments', 'swift' ).'</span>', _x( '1', '1 comment', 'swift' ), sprintf( _x( '%s', 'n comments', 'swift' ), '%' ) ); ?>
		</div>
		<?php endif; ?>
	</header>
	<!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
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
