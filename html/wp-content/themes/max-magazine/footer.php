<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content-container and the #container div.
 * Also contains the footer widget area.
 *
 * @file      footer.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
 ?>
 
</div> <!-- /content-container -->

    <div id="footer">
        <div class="footer-widgets">
            
			<?php if ( ! dynamic_sidebar( 'sidebar-2' ) ) : ?>				
				
				<div class="widget widget_text" id="text-4">
					<h4>Max Responsive Wordpress Themse</h4>
					<div class="textwidget">Thank you for using this free theme. If you have questions, please feel free contact.</div>
				</div>
				
				<div class="widget">
					<h4><?php _e( 'Popular Categories', 'max-magazine' ); ?></h4>
					<ul><?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'title_li' => '', 'number' => 5 ) ); ?></ul>
				</div>
				
				<?php the_widget('WP_Widget_Recent_Posts', 'number=5', 'before_title=<h4>&after_title=</h4>'); ?>
				<?php the_widget('WP_Widget_Recent_Comments', 'number=5', 'before_title=<h4>&after_title=</h4>'); ?> 
			
			<?php endif; // end footer widget area ?>		
			
		</div>
        
		<div class="footer-info">
            <p>	<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo ('name');?>"><?php bloginfo ('name');?></a> 
			<?php _e('Powered by','max-magazine'); ?> <a href="http://www.wordpress.org"><?php _e('WordPress','max-magazine'); ?></a>			
			</p>
			
			<div class="credit">
				<?php //please do not remove this ?>
				<p><?php _e('Max Magazine Theme was created by ', 'max-magazine'); ?><a href="http://gazpo.com/"><img alt="gazpo.com" src="<?php echo get_template_directory_uri(); ?>/images/logo_12.png"></a></p>
            </div>
        </div>        
	</div>

</div> <!-- /container -->
<?php wp_footer(); ?>
</body>
</html>