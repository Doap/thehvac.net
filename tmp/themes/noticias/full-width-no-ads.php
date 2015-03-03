<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  Template Name: full-width-no-ads
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
}
?>
<?php
echo do_shortcode('[contact-form-7 id="1159194" title="Sin título"]');
?>


<style>
.wpcf7-form { padding:5px;border:1px solid #ccc;}
#twocolumn-wrap { width:600px; }
</style>

<?php //get_sidebar(); ?>
<?php get_footer(''); ?>
