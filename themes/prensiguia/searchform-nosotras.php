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
$category = get_the_category(); 
$themaincat = $category[0]->term_id;
//echo $themaincat;
//var_dump($category);
if ($themaincat <> 35362 && $themaincat <> 25763)
{
	$search_button = 'http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/searchboxbluebutton.png';
}
else
{
	if ($themaincat == 35362)
	{
		$search_button = 'http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/searchboxbluebutton.png';
	}
	else
	{
		if (is_active_sidebar('nosotras'))
		{
		//$search_button = 'http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/searchboxbluebutton.png';
		$search_button = 'http://doap.com/wp-content/uploads/2014/07/Screen-Shot-2014-07-21-at-5.21.06-PM.png';
		}
	}
}
?>


<form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<label class="screen-reader-text" for="s"><?php esc_attr_e( 'Buscar noticias:', 'responsive' ) ?></label>
	<input type="text" class="field rounded search" name="s" id="s" placeholder="<?php esc_attr_e( 'Buscar noticias&hellip;', 'responsive' ); ?>" />
        <button style="border: none; background: transparent; cursor: pointer;" id="lptvsearchbutton" class="submit rounded test" type="submit"><img style="height:28px;position:relative;left:-10px;" src="<?php echo $search_button; ?>" value="<?php esc_attr_e( 'Go', 'responsive' ); ?>"/></button>
</form>
