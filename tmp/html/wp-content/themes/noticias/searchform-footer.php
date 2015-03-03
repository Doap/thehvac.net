<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Search Form Template
 *
 *
 * @file           searchform.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/searchform.php
 * @link           http://codex.wordpress.org/Function_Reference/get_search_form
 * @since          available since Release 1.0
 */
?>


<form method="get" id="ft-searchform" action="<?php echo home_url( '/' ); ?>">
	<label class="screen-reader-text" for="s"><?php esc_attr_e( 'Buscar noticias:', 'responsive' ) ?></label>
	<input type="text" class="field rounded search" name="s" id="s" placeholder="<?php esc_attr_e( 'Buscar noticias&hellip;', 'responsive' ); ?>" />
        <button style="border: none; background: transparent; cursor: pointer;" id="lptvsearchbutton" class="submit rounded" type="submit"><img style="height:28px;position:relative;left:-10px;" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/botonbuscadorfooter.svg" value="<?php esc_attr_e( 'Go', 'responsive' ); ?>"/></button>
</form>
