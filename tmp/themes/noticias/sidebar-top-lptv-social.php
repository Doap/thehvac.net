<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
       exit;
}

/**
 * Top Bar Widget Template
 *
 *
 * @file           sidebar-top-bar.php
 * @package        Responsive
 * @author         Juan Alvarez
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/noticias/sidebar-top-bar.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */

if( !is_active_sidebar( 'top-bar-widget' ) ) {
       return;
}
?>
<?php responsive_widgets_before(); // above widgets container hook ?>
       <div id="top-bar_widget" class="">
               <?php responsive_widgets(); // above widgets hook ?>

               <?php if( is_active_sidebar( 'top-bar-widget' ) ) : ?>

                       <?php dynamic_sidebar( 'top-bar-widget' ); ?>

               <?php endif; //end of colophon-widget ?>

               <?php responsive_widgets_end(); // after widgets hook ?>
       </div><!-- end of #top-bar-widget -->
<?php responsive_widgets_after(); // after widgets container hook ?>
