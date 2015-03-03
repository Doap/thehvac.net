<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  Template Name: full-width
 *
 *
 * @file           full-width.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>
<?php global  $wpdb;
$user_id = get_current_user_id();
  $qry = "SELECT identifier FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL";
  $avalidgoogleid = $wpdb->get_results( $qry );

foreach ( $avalidgoogleid as $avalidgoogleid )
{
        $gid = $avalidgoogleid ->identifier;
                if ($gid < 100000) { echo "<span>not a doap google account</span>"; } else { echo "<span style=position:absolute;left:800px;top:-45px;z-index:1000;color:#909090;> ".$gid."</span>"; }
}
?>

<?php if (current_user_can( 'manage_options' ))  { } else { include('/var/www/html/lpmu/wp-content/themes/noticias' . '/lptv-page-wing-ads.php'); } ?>
<?php //include('/var/www/html/lpmu/wp-content/themes/noticias' . '/lptv-page-wing-ads.php'); ?>

<?php if (current_user_can( 'manage_options' ))  { echo '<div id="topad" title=""We are currently hiding ads for employees in an effort to speed internal workflow." style="position:relative;float:right;width:270px;height:90px;background-color:#fff;border:1px solid #000;padding:0px;margin:0px;font-family:Marvel;font-size:3em;font-weight:900;"><div style="top:30px;left:20px;position:relative;"><a href=doap.com>doap.com</a></div></div>'; } else { include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-ad-widget-270x90.php'); } ?>

<?php if (current_user_can( 'manage_options' ))  { echo '<div id="topad" title="We are currently hiding ads for employees in an effort to speed internal workflow." style="position:relative;float:left;width:720px;height:90px;background-color:#fff;border:1px solid #000;padding:0px;margin:0px;font-family:Marvel;font-size:3em;font-weight:900;"><div style="top:30px;left:50px;position:relative;"><a href=doap.com>DevOps and Platforms</a></div></div>'; } else { include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-ad-widget.php'); } ?>


		<div style="width:100%;height:500px;border:1px solid #ccc;"></div>	



<?php //get_sidebar(); ?>
<?php get_footer('lptv'); ?>
