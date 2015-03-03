<?php
/**
 * The Tag page
 *
 * This page is used to display Tag Archive pages
 * 
 * @file      tag.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
 ?> 
<?php get_header(); ?>

	<div id="content" >	
		<h2 class="page-title"><?php printf( __( 'Tag Archives: %s', 'max-magazine' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h2>

		<?php
			$tag_description = tag_description();
				if ( ! empty( $tag_description ) )
						echo apply_filters( 'tag_archive_meta', '<div class="archive-meta">' . $tag_description . '</div>' );
		?>
		
		<?php get_template_part('includes/content'); ?>
		
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>