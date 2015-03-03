<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @since 3.0.0
 */
			/* Do not display sidebars if full width option selected on single
			   post/page templates */
			if ( 5 != mb_theme_options( 'layout' ) )
				get_sidebar();

			get_sidebar( 'second' );
			?>
	</div> <!-- #main.row -->
</div> <!-- #page.grid -->

<footer id="footer" role="contentinfo">

	<div id="footer-content" class="grid <?php echo mb_theme_options( 'width' ); ?>">
		<div class="row">

			<p class="copyright c12">
				<span class="fl">Copyright &copy; <?php echo date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php echo bloginfo( 'name' ); ?></a>. All Rights Reserved.</span>
				<span class="fr"><i class="icon-leaf"></i>Magazine Basic created by <a href="https://themes.bavotasan.com/2008/magazine-basic/">c.bavota</a>.</span>
			</p><!-- .c12 -->

		</div><!-- .row -->
	</div><!-- #footer-content.grid -->

</footer><!-- #footer -->

<?php wp_footer(); ?>
</body>
</html>