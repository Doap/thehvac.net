<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=wrapper div, opened in header.php
 *
 * @package Swift
 * @since Swift 6.0
 */
?>
<?php
GLOBAL $swift_options;
?>
<div class="clear"></div>
<footer>
	<?php swift_before_footer()?>

	<div id="footer-container">
		<div id="footer" class="hybrid clearfix footer">

			<div class="fourcol-one footer-widgets">
				<div class="div-content">
					<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('footer-1') ) ?>
				</div>
			</div>
			<!--End of footer-1 -->

			<div class="fourcol-one footer-widgets">
				<div class="div-content">
					<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('footer-2') ) ?>
				</div>
			</div>
			<!--End of footer-1 -->

			<div class="fourcol-one footer-widgets">
				<div class="div-content">
					<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('footer-3') ) ?>
				</div>
			</div>
			<!--End of footer-1 -->

			<div class="fourcol-one footer-widgets">
				<div class="div-content">
					<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('footer-4') ) ?>
				</div>
			</div>
			<!--End of footer-1 -->
		</div>
		<!-- /#footer -->
	</div>
	<!-- /#footer-contianer -->

	<div id="copyright-container">
		<div id="copyright" class="hybrid clearfix">
			<div class="div-content">
				<div class="alignleft">
					<?php
					wp_nav_menu( array( 'container'		=> '',
					'menu_class'  	=> '',
					'menu_id' 		=> 'footer-links',
					'fallback_cb'	=> '',
					'theme_location'=> 'footer-links' )
					);
					?>
				</div>
				<span class="alignright"><?php _e( 'Theme Swift by', 'swift' )?> <a
					href="http://swiftthemes.com/swiftlers-area/go.php?r=<?php echo $swift_options['affiliate_id'];?>"
					rel="nofollow"><strong>SwiftThemes.Com</strong> </a> </span>

				<div class="clear"></div>
				<span class="alignleft"><?php echo __( 'Copyright &copy;', 'swift' ) . '&nbsp;' . date('Y'); ?>
					<a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?> </a>
					| <?php printf( __( '%1$s and %2$s', 'swift' ), '<a href="' . get_bloginfo('rss2_url') . '">' . __( 'Entries (RSS)', 'swift' ) . '</a>', '<a href="' . get_bloginfo('comments_rss2_url') . '">' . __( 'Comments (RSS)', 'swift' ) . '</a>' ); ?>
				</span> <span class="alignright"><?php _e( 'powered by', 'swift' )?>
					<a href="http://wordpress.org/" rel="nofollow">WordPress</a> <a
					href="#top" id="backtotop">[<?php _e( 'Back to top', 'swift' )?>
						&uarr; ]
				</a> </span>
				<div class="clear"></div>
			</div>
		</div>
		<!-- /copyright -->
	</div>
	<!-- /copyright-container -->

	<?php swift_after_footer()?>
</footer>
</div>
<!-- /#wrapper -->
<?php wp_footer() ?>
<?php swift_after_html(); ?>
</body>
</html>
