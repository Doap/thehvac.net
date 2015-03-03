<?php
/**
 * The default template for displaying content
 *
 * @package Swift
 * @subpackage template
 * @since 6.0
 */
?>
<?php GLOBAL $swift_post_count,$swift_options,$swift_design_options; ?>
<?php
if( isset($swift_design_options['blog_thumb_width']) && $swift_design_options['blog_thumb_width'] != 0)
	$thumb_size = array($swift_design_options['blog_thumb_width'],$swift_design_options['blog_thumb_height']);
else
	$thumb_size = array(160,90);
global $swift_post_count;
if(isset($swift_options['full_length_posts']) && $swift_post_count < $swift_options['full_length_posts'] &&  $paged < 2 )
	$full_length = true;
else
	$full_length = false;
$swift_post_count++;
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
	</header>
	<!-- .entry-header -->
	<?php
		if ( (!$full_length) && (is_search() || isset( $swift_options['excerpts_enable'] ) && $swift_options['excerpts_enable']) ) : // Only display Excerpts for Search ?>
	<div class="entry-summary clearfix">
		<?php
		if(  isset( $swift_options['excerpts_thumbs_enable'] ) && $swift_options['excerpts_thumbs_enable'] )
			the_post_thumbnail( $thumb_size, array('class' => 'alignleft blog-thumb blog' ) );
		?>
		<?php the_excerpt();
		echo ' <a href="'. get_permalink() . '" class="btn small continue-reading alignright"><span>' .$swift_options['continue_reading_button_text']. '</span></a>'
		?>
	</div>
	<!-- .entry-summary -->
	<?php else : ?>

	<div class="entry-content">
		<?php the_content( $swift_options['continue_reading_button_text'] ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'swift' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div>
	<!-- .entry-content -->
	<?php endif; ?>

	<footer class="home entry-meta">
		<?php 	if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search
		swift_meta_generator($swift_options['home_blog_meta'], 'alignleft' );


				endif; // End if 'post' == get_post_type() ?>

		<?php if ( comments_open() ) : ?>
		<div class="comments-link">
			<?php comments_popup_link( '<span class="leave-reply">'._x( '0', '0 comments', 'swift' ).'</span>', _x( '1', '1 comment', 'swift' ), sprintf( _x( '%s', 'n comments', 'swift' ), '%' ) ); ?>
		</div>
		<?php endif; // End if comments_open() ?>


	</footer>
	<!-- #entry-meta -->
	<div class="clear"></div>

</article>
<!-- #post-<?php the_ID(); ?> -->
