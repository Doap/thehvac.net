<?php
/**
 * The second/right sidebar widgetized area.
 *
 * If no active widgets in sidebar, alert with default archive
 * widget will appear.
 *
 * @since 3.0.0
 */

/* Conditional check to see if post/page template is full width
   or if no sidebars was selected in layout options */
$layout = mb_theme_options( 'layout' );
if ( 6 != $layout ) {
	if ( 3 == $layout || 4 == $layout || 5 == $layout ) {
		?>
		<div id="tertiary" <?php mb_second_sidebar_class(); ?> role="complementary">
			<?php if ( ! dynamic_sidebar( 'second-sidebar' ) ) : ?>

			<?php if ( current_user_can( 'edit_theme_options' ) ) { ?>
				<span class="instructions"><?php printf( __( 'Add your own widgets by going to the %sWidgets admin page%s.', 'magazine-basic' ), '<a href="' . admin_url( 'widgets.php' ) . '">', '</a>' ); ?></span>
			<?php } ?>

			<aside id="archives" class="widget">
				<h3 class="widget-title"><?php _e( 'Archives', 'magazine-basic' ); ?></h3>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>
			<?php endif; ?>
		</div><!-- #tertiary.widget-area -->
		<?php
	}
}