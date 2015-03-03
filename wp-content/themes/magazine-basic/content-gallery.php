<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @since 3.0.0
 */
global $mb_content_area;
$class = mb_article_class();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>

	    <?php get_template_part( 'content', 'header' ); ?>

	    <div class="entry-content">
	        <?php
			if ( is_single() && 'sidebar' != $mb_content_area ) {
				the_content( 'Read more &rarr;' );
			} else {
				global $post;
				$images = get_children( array(
					'post_parent' => $post->ID,
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'numberposts' => 100
				) );

				if ( ! empty( $images ) ) :
					$total_images = count( $images );
					$image = array_shift( $images );
					$image_img_tag = wp_get_attachment_image( $image->ID, 'full' );
					?>
				<a class="gallery-thumb" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
				<p class="gallery-text"><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo &rarr;</a>', 'This gallery contains <a %1$s>%2$s photos &rarr;</a>', $total_images, 'magazine-basic' ), 'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'magazine-basic' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
						number_format_i18n( $total_images ) ); ?></em></p>
					<?php
				endif;
			}
			?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>

	</article>