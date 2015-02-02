<?php
/*
  Plugin Name: Shortcodes Ultimate: Extra Shortcodes
  Plugin URI: http://gndev.info/shortcodes-ultimate/extra/
  Version: 1.5.3
  Author: Vladimir Anokhin
  Author URI: http://gndev.info/
  Description: Extra set of shortcodes for Shortcodes Ultimate
  Text Domain: sue
  Domain Path: /lang
  License: license.txt
 */

define( 'SUE_PLUGIN_FILE', __FILE__ );
define( 'SUE_PLUGIN_VERSION', '1.5.3' );

require_once 'inc/update.php';
require_once 'inc/shortcodes.php';
require_once 'inc/extra.php';

new WPUpdatesPluginUpdater_563( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__) );
