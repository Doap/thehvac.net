<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loop Header Template-Part File
 *
 * @file           loop-header.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/loop-header.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */

/**
 * Display breadcrumb
 */
get_responsive_breadcrumb_lists();

/**
 * Display archive information
 */

if( is_category() || is_tag() || is_author() || is_date() ) {
	?>

	<h6 class="title-archive">
		<?php
		if( is_day() ) :
			printf( __( 'Archivos diarios: %s', 'responsive' ), '<span>' . get_the_date() . '</span>' );
		elseif( is_month() ) :
			printf( __( 'Archivo mensual: %s', 'responsive' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
		elseif( is_year() ) :
			printf( __( 'Archivo anual: %s', 'responsive' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
		else : ?>
<?php if ($_GET['cat'] == 19) { ?>
			<?php _e( 'Archivo de Videos', 'responsive' ); ?>
<?php } else { ?>
			<?php //_e( 'Archivos de La Prensa', 'responsive' ); ?>
<?php } ?>

<?php
		endif;
		?>
	</h6>
<?php
}

/**
 * Display Search information
 */

if( is_search() ) {
	?>
<?php if ($_GET['cat'] == 19) { ?>
	<div style="margin-right:30px;position:relative;float:right;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/hetyoutube.svg" style="width:30px;height:30px;margin-right:4px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;" alt=""></div><h6 class="title-search-results"><?php printf( __( 'Resultados de video búsqueda : %s', 'responsive' ), '<span>' . get_search_query() . '</span>' ); ?></h6>
<?php } else { ?>
	<h6 class="title-search-results"><?php printf( __( 'Resultados de la búsqueda: %s', 'responsive' ), '<span>' . get_search_query() . '</span>' ); ?></h6>
<?php } ?>

<?php
}
