<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Search Form Template
 *
 *
 * @file           searchformlptv.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/searchformlptv.php
 * @link           http://codex.wordpress.org/Function_Reference/get_search_form
 * @since          available since Release 1.0
 */
?>

<style>
@import url("http://noticias.laprensa.com.ni/wp-content/themes/noticias/lptv-search.css");
</style>


<form method="get" class="searchformlptv" id="searchformlptv" action="<?php echo home_url( '/' ); ?>">
	<label class="screen-reader-text" for="s"><?php esc_attr_e( 'Ingrese el tema o titulo del video:', 'responsive' ) ?></label>
	<input size="50" style="-moz-border-top-left-radius:10px; /* Firefox */ -webkit-border-top-left-radius: 10px; /* Safari, Chrome */ -khtml-border-top-left-radius: 10px; /* KHTML */ border-top-left-radius: 10px; /* CSS3 */ -moz-border-bottom-left-radius:10px; /* Firefox */ -webkit-border-bottom-left-radius: 10px; /* Safari, Chrome */ -khtml-border-bottom-left-radius: 10px; /* KHTML */ border-bottom-left-radius: 10px; /* CSS3 */ height:21px;width:250px;" type="text" class="field rounded search" name="s" id="s" placeholder="<?php esc_attr_e( 'Ingrese el tema o titulo del video&hellip;', 'responsive' ); ?>" />
	<input type="hidden" name="cat" id="cat" value="19" />
<button style="border: none; background: transparent; cursor: pointer;" id="lptvsearchbutton" class="submit rounded" type="submit"><img style="height:28px;position:relative;left:-10px;" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/lptv-button-search6.png" value="<?php esc_attr_e( 'Go', 'responsive' ); ?>"/></button>
</form>
