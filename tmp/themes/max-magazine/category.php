<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @file      category.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 * 
 **/
?>
<?php get_header(); ?>

	<div id="content" >	
		<h2 class="page-title">
			<?php	printf( __( 'Category Archives: %s', 'max-magazine' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
		</h2>
		
		<?php
			$category_description = category_description();
				if ( ! empty( $category_description ) )
					echo apply_filters( 'category-archive-meta', '<div class="archive-meta">' . $category_description . '</div>' );
		?>
			
		
		<?php get_template_part('includes/content'); ?>
		
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>