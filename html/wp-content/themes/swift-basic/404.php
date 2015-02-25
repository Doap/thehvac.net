<?php
get_header();
?>
<div id="content" class="full-width" role="main">
	<div class="div-content">
		<h2 class="archive-title">
			<big><?php _e('Oops..  404 Error', 'swift' ) ?> </big>
		</h2>
		<p style="font-size: 1.2em; line-height: 1.8em; font-style: italic;">
			<?php _e( 'It seems the page you were trying to find on my site isn\'t around anymore (or at least around here).', 'swift' ); ?>
			<br />
			<?php _e( 'Report it missing using my contact form and I\'ll see what I can do about it.', 'swift' ); ?>
			<br />
			<?php _e( 'Whilst you are here why not use the resources below? You never know, you may just find what you were looking for.', 'swift' ); ?>
			<br />
		</p>
		<br />
		<?php get_template_part( 'lib/includes/listing-4-404');?>

	</div>
</div><!-- #content -->

	</div><!-- left -->
	</div><!-- main -->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>