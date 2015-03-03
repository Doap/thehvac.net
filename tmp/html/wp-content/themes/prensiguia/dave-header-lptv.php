<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header Template
 *
 *
 * @file           header.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.3
 * @filesource     wp-content/themes/responsive/header.php
 * @link           http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
 * @since          available since Release 1.0
 */
?>
	<!doctype html>
	<!--[if !IE]>
	<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 7 ]>
	<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 8 ]>
	<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 9 ]>
	<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
	<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php wp_title( '&#124;', true, 'right' ); ?></title>

		<link rel="profile" href="http://gmpg.org/xfn/11"/>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

		<?php wp_head(); ?>
	</head>

<body <?php body_class(); ?>>

<?php responsive_container(); // before container hook ?>
<div id="container" class="hfeed">

<?php responsive_header(); // before header hook ?>
<img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/footerlptv1-900x114.jpg" style="position:absolute;left:0px;top:0px;width:100%;height:100px;" alt="">
	<div id="header">
		<?php responsive_header_top(); // before header content hook ?>

		<?php responsive_in_header(); // header hook ?>
<div style="max-width:200px;z-index:1000">
			<img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/lptv-header-logo.png" style="max-width:200px;" alt="">
</div>
<!-- end of #logo -->

<div class="grid col-370" style="">

	<form method="get" id="searchformlptv" action="<?php echo home_url( '/' ); ?>">
		<label class="screen-reader-text" for="s"><?php esc_attr_e( 'Search for:', 'responsive' ) ?></label>
		<input size="35" type="text" class="field rounded search" name="s" id="s" placeholder="<?php esc_attr_e( 'search here &hellip;', 'responsive' ); ?>" />
		<input type="submit" class="submit rounded" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Go', 'responsive' ); ?>" />
	</form>
	<?php //get_template_part( 'searchformlptv' ); ?>
</div>
		<div id="socialstuff" style="position:relative;left:40px;top:10px;" class="grid col-360" style=""><?php get_sidebar( 'toplptv' ); ?></div>

		<?php responsive_header_bottom(); // after header content hook ?>

	</div><!-- end of #header -->
<?php responsive_header_end(); // after header container hook ?>

<?php responsive_wrapper(); // before wrapper container hook ?>
	<div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>
<style>
#logo img { align:left;max-height: 60px; } */
</style>
