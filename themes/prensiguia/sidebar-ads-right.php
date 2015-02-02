<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Advertising Widget Template
 *
 *
 * @file           sidebar-ads-right.php
 * @package        Responsive
 * @author         Juan Carlos Alvarez
 * @filesource     wp-content/themes/noticias/sidebar-ads-right.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 */
?>
<?php
if( !is_active_sidebar( 'ads-right' )
) {
	return;
}
?>
<?php responsive_widgets_before(); // above widgets container hook ?>
	<div id="ads-right" class="advertising grid col-220">
		<?php responsive_widgets(); // above widgets hook ?>

		<?php if( is_active_sidebar( 'ads-right' ) ) : ?>

			<?php dynamic_sidebar( 'ads-right' ); ?>

		<?php endif; //end of .advertising ?>

		<?php responsive_widgets_end(); // after widgets hook ?>
	</div><!-- end of .advertising -->
<?php responsive_widgets_after(); // after widgets container hook ?>
