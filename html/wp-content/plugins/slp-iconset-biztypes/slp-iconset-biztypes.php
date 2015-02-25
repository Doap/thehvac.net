<?php
/**
 * Plugin Name: Store Locator Plus : Biz Types Icon Set
 * Plugin URI: http://www.charlestonsw.com/products/store-locator-plus-icon-set/
 * Description: A premium add-on pack for Store Locator Plus that adds biz type icons to the icon pickers.
 * Version: 0.06
 * Author: Charleston Software Associates
 * Author URI: http://charlestonsw.com/
 * Requires at least: 3.3
 * Test up to : 3.7
 *
 * Text Domain: csa-slpicons
 * Domain Path: /languages/
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// No SLP? Get out...
//
if ( !in_array( 'store-locator-le/store-locator-le.php', apply_filters( 'active_plugins', get_option('active_plugins')))) {
    return;
}

// If we have not been here before, let's get started...
//
if ( ! class_exists( 'SLPIconSet_BizTypes' ) ) {

    /**
    * IconSet
    *
    * @package StoreLocatorPlus\SLPIconSet_Pins
    * @author Lance Cleveland <lance@charlestonsw.com>
    * @copyright 2013 Charleston Software Associates, LLC
    */
    class SLPIconSet_BizTypes {

        /**
         * The base plugin.
         *
         * @var \SLPLus $plugin
         */
        public  $plugin = null;

        /**
         * Slug for this plugin.
         *
         * @var string $slug
         */
        private $slug;

        /**
         * Constructor.
         */
        function __construct() {
            $this->slug = plugin_basename(__FILE__);
            add_action('slp_init_complete'             ,array($this,'slp_init'        )             );
            add_filter('slp_icon_directories'          ,array($this,'addIconDirectory')        ,10  );
        }

        /**
         * Do this after SLP initiliazes.
         *
         * @return null
         */
        function slp_init() {
            if (!$this->setPlugin()) { return; }
            $this->plugin->register_addon(plugin_basename(__FILE__));
        }

        /**
         * Set the plugin property to point to the primary plugin object.
         *
         * Returns false if we can't get to the main plugin object.
         *
         * @global wpCSL_plugin__slplus $slplus_plugin
         * @return boolean true if plugin property is valid
         */
        function setPlugin() {
            if (!isset($this->plugin) || ($this->plugin == null)) {
                global $slplus_plugin;
                $this->plugin = $slplus_plugin;
            }
            return (isset($this->plugin) && ($this->plugin != null));
        }

        /**
         * Add our icon directory to the list used by SLP.
         *
         * @param array $directories - array of directories.
         */
        function addIconDirectory($directories) {
            $directories = array_merge(
                        $directories,
                        array(
                            array(
                                'dir'=>plugin_dir_path(__FILE__),
                                'url'=>plugins_url('',__FILE__).'/'
                                )
                        )
                        );
            return $directories;
        }
    }

   global $slplus_plugin;
   $slplus_plugin->IconSet['biztypes'] = new SLPIconSet_BizTypes();
}