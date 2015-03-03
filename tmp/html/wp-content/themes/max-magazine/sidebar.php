<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @file      sidebar.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
 ?> 
<div id="sidebar">
		
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>			
				
			<div class="widget widget_text">
				<h3><?php _e( 'Max Responsive Wordpress Theme', 'max-magazine' ); ?></h3>			
				<div class="textwidget"><?php _e( 'Thank you for using this free theme. If you have questions, please feel free contact.', 'max-magazine' ); ?></div>
			</div>
			
			<div class="widget widget_search">
				<form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
					<div>
						<input class="searchfield" type="text" value="<?php _e('Search', 'max-magazine');?>" name="s" id="s" onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}" />
					</div>
				</form>
			</div>
			
			<?php the_widget('WP_Widget_Recent_Posts', 'number=5', 'before_title=<h3>&after_title=</h3>'); ?>					
					
			<div class="widget">
				<h3><?php _e( 'Popular Categories', 'max-magazine' ); ?></h3>
				<ul><?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'title_li' => '', 'number' => 10 ) ); ?></ul>
			</div>
					
			<div class="widget widget_archive">
				<h3 class="widget-title"><?php _e( 'Archives', 'max-magazine' ); ?></h3>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</div>
			
			<?php the_widget( 'WP_Widget_Tag_Cloud', array('title' => 'Popular tags', ), array('before_title' => '<h3>', 'after_title' => '</h3>')); ?>
			
				
		<?php endif; // end sidebar widget area ?>
		
</div><!-- /sidebar -->
		