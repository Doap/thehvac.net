<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package Swift
 * @subpackage Template
 * @since Swift 6.0
 */
?>
<?php
GLOBAL $swift_options;
$swift_post_meta= get_post_meta( $post->ID, '_swift_post_meta', TRUE )
?>
<div class="clear"></div>
<article
	id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( !(is_array($swift_post_meta) && $swift_post_meta['hide_title']) ):?>
	<header class="entry-header">
		<?php swift_meta_generator($swift_options['single_above_title'], 'single-meta-above-title' ); ?>
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1>
		<div class="border clearfix">
			<?php if ( 'post' == get_post_type() ) : ?>
			<?php swift_meta_generator($swift_options['single_below_title'], 'single-meta-below-title alignleft' ); ?>
			<?php endif; ?>
			<?php if ( comments_open() ) : ?>
			<div class="comments-link alignright entry-meta">
				<?php comments_popup_link( '<span class="leave-reply">'._x( '0', '0 comments', 'swift' ).'</span>', _x( '1', '1 comment', 'swift' ), sprintf( _x( '%s', 'n comments', 'swift' ), '%' ) ); ?>
			</div>
			<?php endif; // End if comments_open() ?>

		</div>
		<div class="share"></div>
	</header>
	<!-- .entry-header -->
	<?php endif;?>
	<div class="entry-content">
		<?php the_content(); ?>
		<div class="clear"></div>
		<?php wp_link_pages( array(
		'before'           => '<div class="page-link"><span>' . __( 'Pages', 'swift' ) . '</span>',
		'after'            => '</div>',
		'link_before'      => '<span>',
		'link_after'       => '</span>',
		'next_or_number'   => 'number',
		'nextpagelink'     => __('Next page'),
		'previouspagelink' => __('Previous page'),
		'pagelink'         => '%',
		'echo'             => 1
) ); ?>

		<?php if( has_tag() ):?>
		<div class="tags">
			<?php echo __( 'Tagged with', 'swift' ).'&nbsp;'; ?>
			<h6>
				<?php the_tags('', ' ', ' '); ?>
			</h6>
		</div>
		<?php endif;?>
	</div>
	<!-- .entry-content -->

	<footer class="single">
		<div id="rp-sm">
			<nav id="nav-single" class="clearfix">
				<?php previous_post_link( '<span class="nav-previous btn">%link</span>', __( '&larr; Previous', 'swift' ) ); ?>
				<?php next_post_link( '<span class="nav-next btn">%link</span>', __( 'Next &rarr;', 'swift' ) ); ?>
				</span>
			</nav>
			<!-- #nav-single -->

			<?php if(function_exists('related_entries')):?>
			<?php related_entries();?>
			<?php endif;?>
		</div>

		<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
		<div id="author-info" class="clearfix">
			<strong><?php printf( esc_attr__( 'About %s', 'swift' ), get_the_author() ); ?>
			</strong>

			<div id="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'swift_author_bio_avatar_size', 68 ) ); ?>
			</div>
			<!-- #author-avatar -->
			<div id="author-description">
				<?php the_author_meta( 'description' ); ?>
				<div id="author-link">
					<a
						href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
						rel="author"> <?php printf( __( 'View all posts by %1$s %2$s&rarr;%3$s', 'swift' ), get_the_author(), '<span class="meta-nav">', '</span>' ); ?>
					</a>
				</div>
				<!-- #author-link	-->
			</div>
			<!-- #author-description -->
		</div>
		<!-- #entry-author-info -->
		<?php endif;?>
	</footer>
	<!-- .entry-meta -->
</article>
<!-- #post-<?php the_ID(); ?> -->
<div class="clear"></div>
