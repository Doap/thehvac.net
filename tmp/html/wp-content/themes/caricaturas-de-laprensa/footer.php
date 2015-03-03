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
<?php //include('/var/www/html/forms/footer.php'); ?>

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
		  <div style="width:80%;">	
			<a href="http://hoy.doap.com/contactanos/">EDITORIAL LA PRENSA, S.A.. | Km. 4½ Carretera Norte, Managua, Nicaragua</a>
		  </div>
		  <div style="width:80%;">
			<a href="http://hoy.doap.com/contactanos/">Apartado Postal #192 | PBX (505) 2255-6767 | FAX (505) 2255-6780 ext. 5369</a>
		  </div>
			
		  
			
			<div class="credit">
				<?php //please do not remove this ?>
			  <p><?php _e('Designed and hosted by ', 'max-magazine'); ?><a href="http://doap.com/"><img style="height:25px; width:150px;" alt="doap.com" src="<?php //echo get_template_directory_uri(); ?>http://doap.com/wp-content/uploads/2013/07/cropped-doap-final-logo-white-on-transparent11-1.png"></a></p>
            </div>
        </div>        
	</div>

</div> <!-- /container -->
<?php wp_footer(); ?>
</body>
</html>
