<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Advertising Widget Template
 *
 *
 * @file           sidebar-ads-frontpage-section-1.php
 * @package        Responsive
 * @author         Juan Carlos Alvarez
 * @filesource     wp-content/themes/noticias/sidebar-ads-frontpage-section-1.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 */
?>
<?php
if( !is_active_sidebar( 'ads-frontpage-section-1' )
) {
	return;
}
?>
<?php responsive_widgets_before(); // above widgets container hook ?>
	<div id="ads-frontpage-section-1" class="advertising grid col-940">
		<?php responsive_widgets(); // above widgets hook ?>

		<?php if( is_active_sidebar( 'ads-frontpage-section-1' ) ) : ?>

			<?php dynamic_sidebar( 'ads-frontpage-section-1' ); ?>

		<?php endif; //end of .advertisig ?>

		<?php responsive_widgets_end(); // after widgets hook ?>
	</div><!-- end of .advertising -->
<?php responsive_widgets_after(); // after widgets container hook ?>
