<?php
/**
 * The first/left sidebar widgetized area.
 *
 * If no active widgets in sidebar, alert with default login
 * widget will appear.
 *
 * @since 3.0.0
 */

/* Conditional check to see if post/page template is full width
   or if no sidebars was selected in layout options */
$layout = mb_theme_options( 'layout' );
if ( 6 != $layout ) {
	?>
	<div id="secondary" <?php mb_sidebar_class(); ?> role="complementary">
		<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>

		<?php if ( current_user_can( 'edit_theme_options' ) ) { ?>
			<span class="instructions"><?php printf( __( 'Add your own widgets by going to the %sWidgets admin page%s.', 'magazine-basic' ), '<a href="' . admin_url( 'widgets.php' ) . '">', '</a>' ); ?></span>
		<?php } ?>

		<aside id="meta" class="widget">
			<h3 class="widget-title"><?php _e( 'Meta', 'magazine-basic' ); ?></h3>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</aside>
		<?php endif; ?>
	</div><!-- #secondary.widget-area -->
	<?php
}