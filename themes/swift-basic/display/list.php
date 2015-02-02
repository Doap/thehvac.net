<?php
/**
 * The default template for displaying content
 *
 * @package Swift
 * @subpackage template
 * @since 6.0
 */
?>
<?php GLOBAL $swift_options; ?>
<li class="clearfix"><?php
the_post_thumbnail( array(48,48), array('class' => 'alignleft thumb' ));
?> <a href="<?php the_permalink() ?>"
	title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?>
</a> <br /> <span class="meta"><?php printf( __( 'Written by %s', 'swift' ), '<a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" rel="author">'.get_the_author().'</a>'); ?>
</span> <span class="meta alignright"><a
		href="<?php echo esc_url( get_permalink() )?>"
		title="<?php echo esc_attr( get_the_time() )?>" rel="bookmark"><time
				class="entry-date"
				datetime="<?php echo esc_attr( get_the_date( 'c' ) )?>">
				<?php echo esc_html( get_the_date() )?>
			</time> </a> </span>
	<div class="clear"></div>
</li>
